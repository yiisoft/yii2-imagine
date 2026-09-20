<?php

/**
 * @link https://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license https://www.yiiframework.com/license/
 */

namespace yiiunit\imagine;

use yii\imagine\Image;

/**
 * @group imagick
 */
class ImageImagickTest extends AbstractImageTest
{
    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        if (!class_exists('Imagick')) {
            $this->markTestSkipped('Skipping ImageImagickTest, Imagick is not installed');
        } elseif (defined('HHVM_VERSION')) {
            $this->markTestSkipped('Imagine does not seem to support HHVM right now.');
        } else {
            Image::setImagine(null);
            Image::$driver = Image::DRIVER_IMAGICK;
            parent::setUp();
        }
    }

    protected function isFontTestSupported(): bool
    {
        return true;
    }
}
