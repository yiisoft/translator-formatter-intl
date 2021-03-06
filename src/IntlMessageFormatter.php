<?php

declare(strict_types=1);

namespace Yiisoft\Translator\Formatter\Intl;

use MessageFormatter;
use Yiisoft\Translator\MessageFormatterInterface;

final class IntlMessageFormatter implements MessageFormatterInterface
{
    /**
     * This method uses \MessageFormatter::format()
     *
     * @link https://php.net/manual/en/messageformatter.format.php
     */
    public function format(string $message, array $parameters, string $locale): string
    {
        if ($parameters === []) {
            return $message;
        }

        $formatter = new MessageFormatter($locale, $message);

        $result = $formatter->format($parameters);

        if ($result === false) {
            return $message;
        }

        return $result;
    }
}
