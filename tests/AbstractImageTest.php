<?php
namespace yiiunit\extensions\imagine;

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

    protected function setUp()
    {
        FileHelper::createDirectory(Yii::getAlias('@yiiunit/extensions/imagine/runtime'));
        $this->imageFile = Yii::getAlias('@yiiunit/extensions/imagine/data/large.jpg');
        $this->watermarkFile = Yii::getAlias('@yiiunit/extensions/imagine/data/xparent.gif');
        $this->runtimeTextFile = Yii::getAlias('@yiiunit/extensions/imagine/runtime/image-text-test.png');
        $this->runtimeWatermarkFile = Yii::getAlias('@yiiunit/extensions/imagine/runtime/image-watermark-test.png');
        parent::setUp();
    }

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

        $fontFile = Yii::getAlias('@yiiunit/extensions/imagine/data/GothamRnd-Light.otf');

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

    /**
     * @expectedException \yii\base\InvalidConfigException
     */
    public function testShouldThrowExceptionOnDriverInvalidArgument()
    {
        Image::setImagine(null);
        Image::$driver = 'fake-driver';
        Image::getImagine();
    }

    abstract protected function isFontTestSupported();
}
