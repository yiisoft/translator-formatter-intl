<p align="center">
    <a href="https://github.com/yiisoft" target="_blank">
        <img src="https://avatars0.githubusercontent.com/u/993323" height="100px">
    </a>
    <h1 align="center">Translator intl message formatter</h1>
    <br>
</p>

The package provides message formatter that utilizes PHP intl extension message formatting capabilities.

[![Latest Stable Version](https://poser.pugx.org/yiisoft/translator-formatter-intl/v/stable.png)](https://packagist.org/packages/yiisoft/translator-formatter-intl)
[![Total Downloads](https://poser.pugx.org/yiisoft/translator-formatter-intl/downloads.png)](https://packagist.org/packages/yiisoft/translator-formatter-intl)
[![Build status](https://github.com/yiisoft/translator-formatter-intl/workflows/build/badge.svg)](https://github.com/yiisoft/translator-formatter-intl/actions?query=workflow%3Abuild)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/yiisoft/translator-formatter-intl/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/yiisoft/translator-formatter-intl/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/yiisoft/translator-formatter-intl/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/yiisoft/translator-formatter-intl/?branch=master)
[![Mutation testing badge](https://img.shields.io/endpoint?style=flat&url=https%3A%2F%2Fbadge-api.stryker-mutator.io%2Fgithub.com%2Fyiisoft%2Ftranslator-formatter-intl%2Fmaster)](https://dashboard.stryker-mutator.io/reports/github.com/yiisoft/translator-formatter-intl/master)
[![static analysis](https://github.com/yiisoft/translator-formatter-intl/workflows/static%20analysis/badge.svg)](https://github.com/yiisoft/translator-formatter-intl/actions?query=workflow%3A%22static+analysis%22)
[![type-coverage](https://shepherd.dev/github/yiisoft/translator-formatter-intl/coverage.svg)](https://shepherd.dev/github/yiisoft/translator-formatter-intl)

The package could be installed with composer:

```
composer require yiisoft/translator-formatter-intl
```

## General usage

### Example of usage with `yiisoft/translator`
```php
/** @var \Yiisoft\Translator\Translator $translator **/

$categoryName = 'moduleId';
$pathToModuleTranslations = './module/messages/';
$additionalCategory = new Yiisoft\Translator\Category(
    $categoryName, 
    new \Yiisoft\Translator\Message\Php\MessageSource($pathToModuleTranslations),
    new \Yiisoft\Translator\Formatter\Intl\IntlMessageFormatter()
);
$translator->addCategorySource($additionalCategory);

$translator->translate('Test string: {str}', ['str' => 'string data'], 'moduleId', 'en');
// output: Test string: string data
```

### Example of usage without `yiisoft/translator` package
```php

/** @var \Yiisoft\Translator\Formatter\Intl\IntlMessageFormatter $formatter */
$pattern = 'Total {count, number} {count, plural, one{item} other{items}}.';
$params = ['count' => 1];
echo $formatter->format($pattern, $params);
// output: Total 1 item. 

$pattern = '{gender, select, female{Уважаемая} other{Уважаемый}} {firstname}';
$params = ['gender' => null, 'firstname' => 'Vadim'];
echo $formatter->format($pattern, $params, 'ru');
// output: Уважаемый Vadim 

$pattern = '{name} is {gender} and {gender, select, female{she} male{he} other{it}} loves Yii!';
$params = ['name' => 'Alexander', 'gender' => 'male'];
echo $formatter->format($pattern, $params);
// output: Alexander is male and he loves Yii! 
```

To get a list of options available for locale you're using - see [https://intl.rmcreative.ru/](https://intl.rmcreative.ru/)

### Unit testing

The package is tested with [PHPUnit](https://phpunit.de/). To run tests:

```shell
./vendor/bin/phpunit
```

### Mutation testing

The package tests are checked with [Infection](https://infection.github.io/) mutation framework. To run it:

```shell
./vendor/bin/infection
```

### Static analysis

The code is statically analyzed with [Psalm](https://psalm.dev/). To run static analysis:

```shell
./vendor/bin/psalm
```

### Support the project

[![Open Collective](https://img.shields.io/badge/Open%20Collective-sponsor-7eadf1?logo=open%20collective&logoColor=7eadf1&labelColor=555555)](https://opencollective.com/yiisoft)

### Follow updates

[![Official website](https://img.shields.io/badge/Powered_by-Yii_Framework-green.svg?style=flat)](https://www.yiiframework.com/)
[![Twitter](https://img.shields.io/badge/twitter-follow-1DA1F2?logo=twitter&logoColor=1DA1F2&labelColor=555555?style=flat)](https://twitter.com/yiiframework)
[![Telegram](https://img.shields.io/badge/telegram-join-1DA1F2?style=flat&logo=telegram)](https://t.me/yii3en)
[![Facebook](https://img.shields.io/badge/facebook-join-1DA1F2?style=flat&logo=facebook&logoColor=ffffff)](https://www.facebook.com/groups/yiitalk)
[![Slack](https://img.shields.io/badge/slack-join-1DA1F2?style=flat&logo=slack)](https://yiiframework.com/go/slack)

## License

The Translator intl message formatter is free software. It is released under the terms of the BSD License.
Please see [`LICENSE`](./LICENSE.md) for more information.

Maintained by [Yii Software](https://www.yiiframework.com/).
