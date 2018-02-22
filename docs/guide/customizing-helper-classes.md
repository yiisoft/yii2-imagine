Customizing Helper Classes
==========================

To customize a helper class (e.g. [[yii\imagine\Image]]), you should create a new class extending
from the helper corresponding base class (e.g. [[yii\imagine\BaseImage]]) and name your class the same
as the corresponding concrete class (e.g. [[yii\imagine\Image]]), including its namespace. This class
will then be set up to replace the original implementation of the framework.

The following example shows how to customize the [[yii\imagine\Image::autorotate()|autorotate()]] method of the
[[yii\imagine\Image]] class:

```php
<?php

namespace yii\imagine;

class Image extends BaseImage
{
    public static function autorotate($image, $color = '000000')
    {
        // your custom implementation
    }
}
```

Save your class in a file named `Image.php`. The file can be in any directory, for example `/path/to/my-project/components`.

Next, you should adjust 'autoload' section in your 'composer.json' adding a class map reference to your implementation:

```json
{
    ...
    "autoload": {
        ...
        "classmap": [
            {"yii\imagine\Image": "components/Image.php"},
            ...
        ]
    }
}
```

Note that customizing of helper class is only useful if you want to change the behavior of an existing function
of the helper. If you want to add additional functions to use in your application, you may be better off creating a separate
helper for that.
