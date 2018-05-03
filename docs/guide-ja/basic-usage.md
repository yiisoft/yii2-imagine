基本的な使用方法
================

このエクステンションは [Imagine](http://imagine.readthedocs.org/) のラッパーであり、また、最もよく使われる画像操作メソッドを追加するものです。
このエクステンションを使用する前に、必ず `Imagine` ライブラリに慣れ親しんで下さい。

下記にこのエクステンションの使い方を例示します。

```php
use yii\imagine\Image;

// 画像に枠を付け、回転し、そして保存する
Image::frame('path/to/image.jpg', 5, '666', 0)
    ->rotate(-8)
    ->save('path/to/destination/image.jpg', ['jpeg_quality' => 50]);
```

下記の画像操作メソッドを利用することが出来ます。

- `Image::crop()` - 画像を切り抜く
- `Image::autorotate()` - EXIF 情報に基づいて画像を自動的に回転する
- `Image::thumbnail()` - サムネール画像を作る
- `Image::resize()` - 画像をリサイズする
- `Image::watermark()` - 既存の画像に透かし(ウォーターマーク）を入れる
- `Image::text()` - 既存の画像の上にテキスト文字列を描画する
- `Image::frame()` - 画像の周囲に枠を追加する

全ての `Image` メソッドは `\Imagine\Image\ImageInterface` のインスタンスを返すことに留意して下さい。
'Imagine' ライブラリで利用可能なメソッドのリストについては、そのドキュメントを参照して下さい。


## ソース画像の指定

全ての画像操作メソッドについて、ソース画像を次の方法によって指定することが出来ます。

- 画像ソース・ファイルへのパス。Yii のパス・エイリアスをここで使うことが出来ます。
- ストリーム・リソース (例えば、`fopen()` の結果).
- `Imagine\Image\ImageInterface` のインスタンス。

例えば、

```php
use yii\imagine\Image;

// パス・エイリアスを使用
Image::crop('@app/src/image.jpg', 100, 100)
    ->save('path/to/destination/image.jpg');

// ストリームを使用
$resource = fopen('/path/to/src/image.jpg', 'r');
Image::crop($resource, 100, 100)
    ->save('/path/to/destination/image.jpg');

// `Imagine\Image\ImageInterface` を使用
$binarySource = file_get_contents('/path/to/src/image.jpg');
$image = Image::getImagine()->load($binarySource);
Image::crop($resource, 100, 100)
    ->save('/path/to/destination/image.jpg');
```

> Note: ソース画像の指定には Yii のパス・エイリアスを使用することが出来ますが、`save()` メソッドの呼び出しについては、それは許されていません。
  というのは、`save()` メソッドは Yii とその機能を知らない 'Imagine' ライブラリに属するからです。
