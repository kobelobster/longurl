<?php
require __DIR__ . '/vendor/autoload.php';

$expand = new \tzfrs\LongURL\Services\Expand();
try {
    print $expand->expandURL('https://t.co/XdXRudPXH5'); //https://blog.twitter.com/2013/rich-photo-experience-now-in-embedded-tweets-3
} catch (\tzfrs\LongURL\Exceptions\ExpandException $e) {
    print $e->getMessage();
}