# PHP Boiler

    npm i phpboiler --save

```php
include_once('./node_modules/phpboiler/boiler.php');

Boiler::refresh([
    '../public_html/index.html' => [
        'src' => './views/greet.html',
        'model' => [
            'name' => 'Susanthany!'
        ]
    ],
    '../public_html/bye.html' => [
        'src' => './views/bye.html'
    ]
]);
```

##### event.log file
```
render completed in 0.002000 seconds
```
