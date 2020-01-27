<?php

namespace Yiisoft\I18n\Formatter;

use Yiisoft\I18n\FormattingException;
use Yiisoft\I18n\MessageFormatterInterface;

class IntlMessageFormatter implements MessageFormatterInterface
{
    public function format(string $message, array $parameters, string $language): string
    {
        if ($parameters === []) {
            return $message;
        }

        try {
            $formatter = new \MessageFormatter($language, $message);
        } catch (\IntlException $e) {
            throw new FormattingException('Message pattern is invalid: ' . $e->getMessage(), $e->getCode(), $e);
        }

        $result = $formatter->format($parameters);

        if ($result === false) {
            throw new FormattingException($formatter->getErrorMessage(), $formatter->getErrorCode());
        }

        return $result;
    }
}
