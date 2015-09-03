<?php
namespace tzfrs\LongURL\Tests;
use tzfrs\LongURL\Endpoints\Expand;

/**
 * Class ExpandTest
 *
 * This class is used to make tests for the class that makes requests to the expand endpoint of the longURL API
 *
 * @package tzfrs\LongURL\Tests
 * @version 0.0.1
 * @author tzfrs
 * @license MIT License
 */
class ExpandTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Expand
     */
    protected static $expand;

    public static function setUpBeforeClass()
    {
        self::$expand = new Expand();
    }

    public function testExpand()
    {
        $response = self::$expand->expandURL('https://t.co/XdXRudPXH5');
        $this->assertEquals('https://blog.twitter.com/2013/rich-photo-experience-now-in-embedded-tweets-3', $response);
    }

    public function testExpandLongURL()
    {
        $response = self::$expand->expandURL('https://blog.twitter.com/2013/rich-photo-experience-now-in-embedded-tweets-3');
        $this->assertEquals('https://blog.twitter.com/2013/rich-photo-experience-now-in-embedded-tweets-3', $response);
    }
}