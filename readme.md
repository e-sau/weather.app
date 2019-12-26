### Weather App
**A small training project**

#### Install
Add 'config-local.php' file into 'main' directory with this code:
```
return [
    'provider' => [
        'AccuWeatherDataProvider' => [
            'apiKey' => 'yourApiKey',
        ],
        'OpenWeatherDataProvider' => [
            'apiKey' => 'yourApiKey',
        ],
    ]
];
``` 
Change 'yourApiKey' on your API key.

Enjoy! ;-)
