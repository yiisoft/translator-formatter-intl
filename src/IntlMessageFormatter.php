<?php

declare(strict_types=1);

namespace Yiisoft\Translator\Formatter\Intl;

use Yiisoft\Translator\MessageFormatterInterface;

class IntlMessageFormatter implements MessageFormatterInterface
{
    public function format(string $message, array $parameters, string $locale): string
    {
        if ($parameters === []) {
            return $message;
        }

        // replace named arguments (https://github.com/yiisoft/yii2/issues/9678)
        $newParams = [];
        $message = $this->replaceNamedArguments($message, $parameters, $newParams);
        $parameters = $newParams;

        $formatter = new \MessageFormatter($locale, $message);

        $result = $formatter->format($parameters);

        if ($result === false) {
            return $message;
        }

        return $result;
    }

    private function replaceNamedArguments(string $pattern, array $givenParams, array &$resultingParams = [], array &$map = []): string
    {
        if (($tokens = self::tokenizePattern($pattern)) === null) {
            return '';
        }
        foreach ($tokens as $i => $token) {
            if (!is_array($token)) {
                continue;
            }
            $param = trim($token[0]);
            if (array_key_exists($param, $givenParams)) {
                // if param is given, replace it with a number
                if (!isset($map[$param])) {
                    $map[$param] = count($map);
                    // make sure only used params are passed to format method
                    $resultingParams[$map[$param]] = $givenParams[$param];
                }
                $token[0] = $map[$param];
                $quote = '';
            } else {
                // quote unused token
                $quote = "'";
            }
            $type = isset($token[1]) ? trim($token[1]) : 'none';
            // replace plural and select format recursively
            if ($type === 'plural' || $type === 'select') {
                if (!isset($token[2])) {
                    return '';
                }
                if (($subtokens = self::tokenizePattern($token[2])) === null) {
                    return '';
                }
                $c = count($subtokens);
                for ($k = 0; $k + 1 < $c; $k++) {
                    if (is_array($subtokens[$k]) || !is_array($subtokens[++$k])) {
                        return '';
                    }
                    $subpattern = $this->replaceNamedArguments(implode(',', $subtokens[$k]), $givenParams, $resultingParams, $map);
                    $subtokens[$k] = $quote . '{' . $quote . $subpattern . $quote . '}' . $quote;
                }
                $token[2] = implode('', $subtokens);
            }
            $tokens[$i] = $quote . '{' . $quote . implode(',', $token) . $quote . '}' . $quote;
        }

        return implode('', $tokens);
    }

    /**
     * Tokenizes a pattern by separating normal text from replaceable patterns.
     */
    private static function tokenizePattern(string $pattern): ?array
    {
        $charset = 'UTF-8';
        $depth = 1;
        if (($start = $pos = mb_strpos($pattern, '{', 0, $charset)) === false) {
            return [$pattern];
        }
        $pos = (int)$pos;
        $tokens = [mb_substr($pattern, 0, $pos, $charset)];
        while (true) {
            $open = mb_strpos($pattern, '{', $pos + 1, $charset);
            $close = mb_strpos($pattern, '}', $pos + 1, $charset);
            if ($open === false && $close === false) {
                break;
            }
            if ($open === false) {
                $open = mb_strlen($pattern, $charset);
            }
            if ($close > $open) {
                $depth++;
                $pos = $open;
            } else {
                $depth--;
                $pos = $close;
            }
            if ($depth === 0) {
                $tokens[] = explode(',', mb_substr($pattern, $start + 1, $pos - $start - 1, $charset), 3);
                $start = $pos + 1;
                $tokens[] = mb_substr($pattern, $start, $open - $start, $charset);
                $start = $open;
            }

            if ($depth !== 0 && ($open === false || $close === false)) {
                break;
            }
        }
        if ($depth !== 0) {
            return null;
        }

        return $tokens;
    }
}
