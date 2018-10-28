Utilização Básica
===========

Esta extensão é um wrapper para o [Imagine](http://imagine.readthedocs.org/) e também adiciona o mais comumente usado
métodos de manipulação de imagem. Certifique-se de estar familiarizado com a biblioteca 'Imagine' antes de usar esta extensão.

O exemplo a seguir mostra como usar esta extensão:

```php
use yii\imagine\Image;

// frame, rotate and save an image
Image::frame('path/to/image.jpg', 5, '666', 0)
    ->rotate(-8)
    ->save('path/to/destination/image.jpg', ['jpeg_quality' => 50]);
```

Seguintes métodos de manipulação de imagem estão disponíveis:

- `Image::crop()` - corta uma imagem.
- `Image::autorotate()` - gira uma imagem automaticamente com base em informações EXIF.
- `Image::thumbnail()` - cria uma imagem em miniatura.
- `Image::resize()` - redimensiona uma imagem.
- `Image::watermark()` - adiciona uma marca d'água a uma imagem existente.
- `Image::text()` - desenha uma cadeia de texto em uma imagem existente.
- `Image::frame()` - adiciona um quadro ao redor da imagem.

Note que cada método `Image` retorna uma instância de `\Imagine\Image\ImageInterface`.
Por favor, consulte a documentação da biblioteca 'Imagine' para a lista dos métodos disponíveis para isso.

## Especificação da imagem de origem

Você pode especificar a imagem de origem para qualquer método de manipulação de imagem usando um dos seguintes métodos:

- caminho para o arquivo de origem da imagem, o apelido do caminho Yii pode ser usado aqui.
- recurso de fluxo (por exemplo, resultado de`fopen()`)
- instância de `Imagine\Image\ImageInterface`.

Por exemplo:

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

> Nota: o alias de caminho Yii está disponível para a especificação da imagem de origem, mas não é permitido
   para invocação `save()` como este método pertence à biblioteca 'Imagine', que não tem conhecimento do Yii e seus recursos.
