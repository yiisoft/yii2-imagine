<p align="center">
    <a href="https://imagine.readthedocs.org/" target="_blank" rel="external">
        <img src="https://imagine.readthedocs.io/en/latest/_static/logo.png" height="100px">
    </a>
    <h1 align="center">Imagine Extension for Yii 2</h1>
    <br>
</p>

This extension adds most common image functions and also acts as a wrapper to [Imagine](https://imagine.readthedocs.org/)
image manipulation library for [Yii framework 2.0](https://www.yiiframework.com).

For license information check the [LICENSE](LICENSE.md)-file.

[![Latest Stable Version](https://poser.pugx.org/yiisoft/yii2-imagine/v/stable.png)](https://packagist.org/packages/yiisoft/yii2-imagine)
[![Total Downloads](https://poser.pugx.org/yiisoft/yii2-imagine/downloads.png)](https://packagist.org/packages/yiisoft/yii2-imagine)
[![Build Status](https://github.com/yiisoft/yii2-imagine/workflows/build/badge.svg)](https://github.com/yiisoft/yii2-imagine/actions)
[![codecov](https://codecov.io/gh/yiisoft/yii2-imagine/graph/badge.svg?token=F1oonww6bw)](https://codecov.io/gh/yiisoft/yii2-imagine)

Requirements
------------

- PHP 7.3 or higher.

Installation
------------

The preferred way to install this extension is through [composer](https://getcomposer.org/download/).

Either run

```
composer require --prefer-dist yiisoft/yii2-imagine
```

or add

```json
"yiisoft/yii2-imagine": "~2.2.0"
```

to the `require` section of your composer.json.


Basic Usage
-----------

This extension is a wrapper to the [Imagine](https://imagine.readthedocs.org/) and also adds the most commonly used
image manipulation methods.

The following example shows how to use this extension:

```php
use yii\imagine\Image;

// frame, rotate and save an image
Image::frame('path/to/image.jpg', 5, '666', 0)
    ->rotate(-8)
    ->save('path/to/destination/image.jpg', ['jpeg_quality' => 50]);
```
