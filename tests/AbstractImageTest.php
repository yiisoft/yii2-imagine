<?php

namespace yiiunit\imagine;

use Yii;
use yii\helpers\FileHelper;
use yii\imagine\Image;
use Imagine\Image\ImageInterface;
use Imagine\Image\Point;

abstract class AbstractImageTest extends TestCase
{
    protected $imageFile;
    protected $watermarkFile;
    protected $runtimeTextFile;
    protected $runtimeWatermarkFile;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        FileHelper::createDirectory(Yii::getAlias('@yiiunit/imagine/runtime'));
        $this->imageFile = Yii::getAlias('@yiiunit/imagine/data/large.jpg');
        $this->watermarkFile = Yii::getAlias('@yiiunit/imagine/data/xparent.gif');
        $this->runtimeTextFile = Yii::getAlias('@yiiunit/imagine/runtime/image-text-test.png');
        $this->runtimeWatermarkFile = Yii::getAlias('@yiiunit/imagine/runtime/image-watermark-test.png');
        parent::setUp();
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown()
    {
        @unlink($this->runtimeTextFile);
        @unlink($this->runtimeWatermarkFile);
    }

    public function testText()
    {
        if (!$this->isFontTestSupported()) {
            $this->markTestSkipped('Skipping ImageGdTest Gd not installed');
        }

        $fontFile = Yii::getAlias('@yiiunit/imagine/data/GothamRnd-Light.otf');

        $img = Image::text($this->imageFile, 'Yii-2 Image', $fontFile, [0, 0], [
            'size' => 12,
            'color' => '000'
        ]);

        $img->save($this->runtimeTextFile);
        $this->assertTrue(file_exists($this->runtimeTextFile));

    }

    public function testCrop()
    {
        $point = [20, 20];
        $img = Image::crop($this->imageFile, 100, 100, $point);

        $this->assertEquals(100, $img->getSize()->getWidth());
        $this->assertEquals(100, $img->getSize()->getHeight());

    }

    public function testWatermark()
    {
        $img = Image::watermark($this->imageFile, $this->watermarkFile);
        $img->save($this->runtimeWatermarkFile);
        $this->assertTrue(file_exists($this->runtimeWatermarkFile));
    }

    public function testFrame()
    {
        $frameSize = 5;
        $original = Image::getImagine()->open($this->imageFile);
        $originalSize = $original->getSize();
        $img = Image::frame($this->imageFile, $frameSize, '666', 0);
        $size = $img->getSize();

        $this->assertEquals($size->getWidth(), $originalSize->getWidth() + ($frameSize * 2));
    }

    public function testThumbnail()
    {
        // THUMBNAIL_OUTBOUND mode.
        $img = Image::thumbnail($this->imageFile, 120, 120);

        $this->assertEquals(120, $img->getSize()->getWidth());
        $this->assertEquals(120, $img->getSize()->getHeight());

        // THUMBNAIL_INSET mode. Missing thumbnail part is filled with background so dimensions are exactly
        // the ones specified.
        $img = Image::thumbnail($this->imageFile, 120, 120, ImageInterface::THUMBNAIL_INSET);

        $this->assertEquals(120, $img->getSize()->getWidth());
        $this->assertEquals(120, $img->getSize()->getHeight());

        // Height omitted and is calculated based on original image aspect ratio regardless of the mode.
        $img = Image::thumbnail($this->imageFile, 120, null);

        $this->assertEquals(120, $img->getSize()->getWidth());
        $this->assertEquals(62, $img->getSize()->getHeight());

        $img = Image::thumbnail($this->imageFile, 120, null, ImageInterface::THUMBNAIL_INSET);

        $this->assertEquals(120, $img->getSize()->getWidth());
        $this->assertEquals(62, $img->getSize()->getHeight());

        // Width omitted and is calculated based on original image aspect ratio regardless of the mode.
        $img = Image::thumbnail($this->imageFile, null, 120);

        $this->assertEquals(234, $img->getSize()->getWidth());
        $this->assertEquals(120, $img->getSize()->getHeight());

        $img = Image::thumbnail($this->imageFile, null, 120, ImageInterface::THUMBNAIL_INSET);

        $this->assertEquals(234, $img->getSize()->getWidth());
        $this->assertEquals(120, $img->getSize()->getHeight());
    }

    public function testThumbnailWithUpscaleFlag()
    {
        // THUMBNAIL_OUTBOUND mode.
        $img = Image::thumbnail($this->imageFile, 700, 700, ImageInterface::THUMBNAIL_OUTBOUND | ImageInterface::THUMBNAIL_FLAG_UPSCALE);

        $this->assertEquals(700, $img->getSize()->getWidth());
        $this->assertEquals(700, $img->getSize()->getHeight());

        // THUMBNAIL_INSET mode. Missing thumbnail part is filled with background so dimensions are exactly
        // the ones specified.
        $img = Image::thumbnail($this->imageFile, 700, 700, ImageInterface::THUMBNAIL_INSET | ImageInterface::THUMBNAIL_FLAG_UPSCALE);

        $this->assertEquals(700, $img->getSize()->getWidth());
        $this->assertEquals(700, $img->getSize()->getHeight());

        // Height omitted and is calculated based on original image aspect ratio regardless of the mode.
        $img = Image::thumbnail($this->imageFile, 840, null, ImageInterface::THUMBNAIL_OUTBOUND | ImageInterface::THUMBNAIL_FLAG_UPSCALE);

        $this->assertEquals(840, $img->getSize()->getWidth());
        $this->assertEquals(432, $img->getSize()->getHeight());

        $img = Image::thumbnail($this->imageFile, 840, null, ImageInterface::THUMBNAIL_INSET | ImageInterface::THUMBNAIL_FLAG_UPSCALE);

        $this->assertEquals(840, $img->getSize()->getWidth());
        $this->assertEquals(432, $img->getSize()->getHeight());

        // Width omitted and is calculated based on original image aspect ratio regardless of the mode.
        $img = Image::thumbnail($this->imageFile, null, 540, ImageInterface::THUMBNAIL_OUTBOUND | ImageInterface::THUMBNAIL_FLAG_UPSCALE);

        $this->assertEquals(1050, $img->getSize()->getWidth());
        $this->assertEquals(540, $img->getSize()->getHeight());

        $img = Image::thumbnail($this->imageFile, null, 540, ImageInterface::THUMBNAIL_INSET | ImageInterface::THUMBNAIL_FLAG_UPSCALE);

        $this->assertEquals(1050, $img->getSize()->getWidth());
        $this->assertEquals(540, $img->getSize()->getHeight());
    }

    /**
     * @dataProvider providerResize
     */
    public function testResize($width, $height, $keepAspectRatio, $allowUpscaling, $newWidth, $newHeight)
    {
        $img = Image::resize($this->imageFile, $width, $height, $keepAspectRatio, $allowUpscaling);

        $this->assertEquals($newWidth, $img->getSize()->getWidth());
        $this->assertEquals($newHeight, $img->getSize()->getHeight());
    }

    public function providerResize()
    {
        // [width, height, keepAspectRatio, allowUpscaling, newWidth, newHeight]
        return [
            'Height and width set. Image should keep aspect ratio.' =>
                [350, 350, true, false, 350, 180],
            'Height and width set. Image should be resized to exact dimensions.' =>
                [350, 350, false, false, 350, 350],
            'Height omitted and is calculated based on original image aspect ratio.' =>
                [350, null, true, false, 350, 180],
            'Width omitted and is calculated based on original image aspect ratio.' =>
                [null, 180, true, false, 350, 180],
            'Upscaling' =>
                [800, 800, true, true, 800, 411],
        ];
    }

    /**
     * @expectedException \yii\base\InvalidConfigException
     */
    public function testShouldThrowExceptionOnDriverInvalidArgument()
    {
        Image::setImagine(null);
        Image::$driver = 'fake-driver';
        Image::getImagine();
    }

    public function testIfAutoRotateThrowsException()
    {
        $img = Image::thumbnail($this->imageFile, 120, 120);
        $this->assertInstanceOf('\Imagine\Image\ImageInterface', Image::autorotate($img));
    }

    abstract protected function isFontTestSupported();
}
