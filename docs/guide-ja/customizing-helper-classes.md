ヘルパ・クラスをカスタマイズする
================================

ヘルパ・クラス (例えば [[yii\imagine\Image]]) をカスタマイズするためには、
対応する基底クラス (例えば [[yii\imagine\BaseImage]]) を拡張して新しいクラスを作成し、
対応する具象クラス (例えば [[yii\imagine\Image]]) と名前空間も含めて同じ名前を付けなければなりません。
こうすると、この新しいクラスが、フレームワークの元の実装を置き換えるものとして設定されます。

次の例は、[[yii\imagine\Image]] クラスの [[yii\imagine\Image::autorotate()|autorotate()]]
メソッドをカスタマイズする方法を示すものです。

```php
<?php

namespace yii\imagine;

class Image extends BaseImage
{
    public static function autorotate($image, $color = '000000')
    {
        // あなた独自の実装
    }
}
```

あなたのクラスを `Image.php` と言う名前のファイルに保存します。ファイルの保存ディレクトリは、例えば、`/path/to/my-project/components` など、どこでも構いません。

次に、'composer.json' の 'autoload' セクションを修正して、あなたの実装に対するクラス・マップの参照を追加します。

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

ヘルパ・クラスのカスタマイズは、ヘルパの既存機能の動作を変更したい場合にだけ有用なものであることに注意して下さい。
アプリケーションで使用する追加の機能が欲しい場合は、
そのための独立したヘルパを作成する方が良いでしょう。
