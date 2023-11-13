# core
provide cloud operation interface for volc tos Cloud


# Install
```
composer require easy-cloud-request/volc-tos -vvv
```

## Usage
```php

<?php

require_once './vendor/autoload.php';

use EasyCloudRequest\Core\SimpleCloud;
use EasyCloudRequest\Core\Support\RequestBag;
use EasyCloudRequest\VolcTos\Gateway;
use EasyCloudRequest\VolcTos\Helper\Helper;

$request = new RequestBag(
    'GET',
    'https://bucketname.tos-cn-beijing.volces.com',
    [
        'list-type' => 2,
        'region' => 'cn-beijing',
    ],
    // [
    //     'Host' => 'bucketname.tos-cn-beijing.volces.com',
    // ],
);

$cloud = new SimpleCloud([
    'default' => Gateway::class,
    'gateway' => [
        'volcTos' => [
            'ak' => 'your-ak',
            'sk' => 'your-sk',
        ]
    ],
    'http_options' => [
        "http_errors" => false,
        "proxy" => [],
        "verify" => false,
        "timeout" => 120,
        "connect_timeout" => 60,
    ]
]);
$result = $cloud->requests($request);
var_dump($result);
```