Basic Usage
===========

This extension is a wrapper to the [Imagine](http://imagine.readthedocs.org/) and also adds the most commonly used
image manipulation methods. Make sure you are familiar with 'Imagine' library before using this extension.

The following example shows how to use this extension:

```php
use yii\imagine\Image;

// frame, rotate and save an image
Image::frame('path/to/image.jpg', 5, '666', 0)
    ->rotate(-8)
    ->save('path/to/destination/image.jpg', ['jpeg_quality' => 50]);
```

Following image manipulation methods are available:

- `Image::crop()` - crops an image.
- `Image::autorotate()` - rotates an image automatically based on EXIF information.
- `Image::thumbnail()` - creates a thumbnail image.
- `Image::resize()` - resizes an image.
- `Image::watermark()` - adds a watermark to an existing image.
- `Image::text()` - draws a text string on an existing image.
- `Image::frame()` - adds a frame around of the image.

Note that each `Image` method returns an instance of `\Imagine\Image\ImageInterface`.
Please refer to 'Imagine' library documentation for the list of the methods available for it.


## Source image specification

You can specify the the source image for any image manipulation method using one of the following way:

- path to the image source file, Yii path alias can be used here.
- stream resource (e.g. result of `fopen()`).
- instance of `Imagine\Image\ImageInterface`.

For example:

```php
use yii\imagine\Image;

// using path alias :
Image::crop('@app/src/image.jpg', 100, 100)
    ->save('path/to/destination/image.jpg');

// using stream
$resource = fopen('/path/to/src/image.jpg', 'r');
Image::crop($resource, 100, 100)
    ->save('/path/to/destination/image.jpg');

// using `Imagine\Image\ImageInterface`
$binarySource = file_get_contents('/path/to/src/image.jpg');
$image = Image::getImagine()->load($binarySource);
Image::crop($resource, 100, 100)
    ->save('/path/to/destination/image.jpg');
```

> Note: while Yii path alias is available for the source image specification, it is not allowed for
  the `save()` invocation as this method belongs to 'Imagine' library, which is unaware of Yii and its features.
