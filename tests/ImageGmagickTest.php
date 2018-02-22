<?php

namespace yiiunit\imagine;

use yii\imagine\Image;

/**
 * @group gmagick
 */
class ImageGmagickTest extends AbstractImageTest
{
    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        if (!class_exists('Gmagick')) {
            $this->markTestSkipped('Skipping ImageGmagickTest, Gmagick is not installed');
        } else {
            Image::setImagine(null);
            Image::$driver = Image::DRIVER_GMAGICK;
            parent::setUp();
        }
    }

    protected function isFontTestSupported()
    {
        return true;
    }
}
