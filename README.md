# longurl

This library can be used to expand short URLs such as https://t.co/XdXRudPXH5 and get the URL that is behind the short URL

## Install

Install via [composer](https://getcomposer.org):

```javascript
{
    "require": {
        "tzfrs/longurl": "0.0.2"
    }
}
```

## Attention

This library currently only supports one method, because I'm just using it for a project that only needs this service. 
If you want extra features then just open an issue.

Run `composer install` or `composer update`.

## Getting Started

### Basic parsing

```php
<?php
require __DIR__ . '/vendor/autoload.php';

$expand = new \tzfrs\LongURL\Services\Expand();
try {
    print $expand->expandURL('https://t.co/XdXRudPXH5'); //https://blog.twitter.com/2013/rich-photo-experience-now-in-embedded-tweets-3
} catch (\tzfrs\LongURL\Exceptions\ExpandException $e) {
    print $e->getMessage();
}
```