Personalizando Classes Auxiliares
==========================

Para personalizar uma classe auxiliar (por exemplo, [[yii\imagine\Image]]), você deve criar uma nova classe estendendo da classe base correspondente do assistente (por exemplo, [[yii\imagine\BaseImage]]) e nomeie sua classe como a classe  correspondente (por exemplo, [[yii\imagine\Image]]), incluindo seu namespace. Esta classe será então configurada para substituir a implementação original do framework.

O exemplo a seguir mostra como personalizar o método [[yii\imagine\Image::autorotate()|autorotate()]] da classe [[yii\imagine\Image]]:

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

Salve sua classe em um arquivo chamado `Image.php`. O arquivo pode estar em qualquer diretório, por exemplo, `/path/to/my-project/components`.

Em seguida, você deve ajustar a seção 'autoload' em seu 'composer.json' adicionando uma referência de mapa de classe à sua implementação:

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

Observe que a personalização da classe auxiliar só é útil se você quiser alterar o comportamento de uma função existente. Se você quiser adicionar funções adicionais ao seu aplicativo, talvez seja melhor criar um aplicativo separado para isso.
