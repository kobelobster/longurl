<?php
require __DIR__ . '/vendor/autoload.php';

$expand = new \tzfrs\LongURL\Endpoints\Expand();
$expand->expandURL('https://t.co/XdXRudPXH5'); // https://blog.twitter.com/2013/rich-photo-experience-now-in-embedded-tweets-3

$expand = new \tzfrs\LongURL\Endpoints\Expand();
$expand->expandURL('https://blog.twitter.com/2013/rich-photo-experience-now-in-embedded-tweets-3'); // https://blog.twitter.com/2013/rich-photo-experience-now-in-embedded-tweets-3

$services = new \tzfrs\LongURL\Endpoints\Services();
$services = $services->getServices(); // List of all services

$services = new \tzfrs\LongURL\Endpoints\Services();
$services->isShortURL('https://t.co/XdXRudPXH5'); // True

$services = new \tzfrs\LongURL\Endpoints\Services();
$services->isShortURL('https://blog.twitter.com/2013/rich-photo-experience-now-in-embedded-tweets-3'); // False