<?php
namespace Yii\I18n\Formatter;

use Yii\I18n\FormattingFailed;
use Yii\I18n\MessageFormatter;

class IntlMessageFormatter implements MessageFormatter
{
    public function format(string $message, array $parameters, string $language): string
    {
        if ($parameters === []) {
            return $message;
        }

        try {
            $formatter = new \MessageFormatter($language, $message);
        } catch (\IntlException $e) {
            throw new FormattingFailed('Message pattern is invalid: ' . $e->getMessage(), $e->getCode(), $e);
        }

        $result = $formatter->format($parameters);

        if ($result === false) {
            throw new FormattingFailed($formatter->getErrorMessage(), $formatter->getErrorCode());
        }

        return $result;
    }
}
