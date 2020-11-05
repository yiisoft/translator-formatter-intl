<?php

declare(strict_types=1);

namespace Yiisoft\Translator\Formatter\Intl;

use Yiisoft\Translator\MessageFormatterInterface;

final class IntlMessageFormatter implements MessageFormatterInterface
{
    public function format(string $message, array $parameters, string $locale): string
    {
        if ($parameters === []) {
            return $message;
        }

        $formatter = new \MessageFormatter($locale, $message);

        $result = $formatter->format($parameters);

        if ($result === false) {
            return $message;
        }

        return $result;
    }
}
