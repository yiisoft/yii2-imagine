<?php

namespace yiiunit\imagine;

use yii\imagine\Image;

/**
 * @group gd
 */
class ImageGdTest extends AbstractImageTest
{
    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        if (!function_exists('gd_info')) {
            $this->markTestSkipped('Skipping ImageGdTest, Gd not installed');
        } else {
            Image::setImagine(null);
            Image::$driver = Image::DRIVER_GD2;
            parent::setUp();
        }
    }

    protected function isFontTestSupported()
    {
        $infos = gd_info();

        return isset($infos['FreeType Support']) ? $infos['FreeType Support'] : false;
    }
}
