<?php
namespace tzfrs\LongURL\Tests;
use tzfrs\LongURL\Endpoints\Services;

/**
 * Class ServicesTest
 *
 * This class is used to make tests for the class that makes requests to the services endpoint of the longURL API
 *
 * @package tzfrs\LongURL\Tests
 * @version 0.0.4
 * @author tzfrs
 * @license MIT License
 */
class ServicesTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Services
     */
    protected static $services;

    public static function setUpBeforeClass()
    {
        self::$services = new Services();
    }

    public function testIsShortURL()
    {
        $response = self::$services->isShortURL('https://t.co/XdXRudPXH5');
        $this->assertTrue($response);
    }

    public function testIsShortURLLong()
    {
        $response = self::$services->isShortURL('https://blog.twitter.com/2013/rich-photo-experience-now-in-embedded-tweets-3');
        $this->assertFalse($response);
    }

    public function testGetServices()
    {
        $response = self::$services->getServices();
        $this->assertInstanceOf(\stdClass::class, $response);
    }

}