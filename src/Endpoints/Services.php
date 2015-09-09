<?php
namespace tzfrs\LongURL\Endpoints;

use GuzzleHttp\Psr7\Stream;
use tzfrs\LongURL\Client;
use tzfrs\LongURL\Exceptions\ServicesException;

/**
 * Class Services
 *
 * This class is used to make requests to the Services endpoint of the longURL API
 *
 * @package tzfrs\LongURL\Services
 * @version 0.0.3
 * @author tzfrs
 * @license MIT License
 */
class Services extends Client
{
    /**
     * The endpoint that is used for requests to the API
     * @var string
     */
    protected $endpoint = 'services';

    /**
     * This method lists the services from the LongURL Endpoint, which it supports.
     *
     * @param string $format
     * @return mixed
     * @throws ServicesException
     */
    public function getServices($format = 'xml')
    {
        $cacheName = md5(__FUNCTION__ . $format);

        if ($this->useCache) {
            $content = $this->cache->get_cache($cacheName);
            if ($content !== false) {
                return $format === 'json' ? json_decode($content) : $this->parseXML($content);
            }
        }

        $stream     = $this->request([], $format);
        if ($stream instanceof Stream) {
            $content    = $stream->getContents();
            if ($this->useCache === true) {
                $this->cache->set_cache($cacheName, $content);
            }
            return $format === 'json' ? json_decode($content) : $this->parseXML($content);
        }
        throw new ServicesException($stream);
    }

    /**
     * This method checks wheter an URL is shortened or a long version
     *
     * This method gets the url as a parameter, then gets all the services that are supported by LongURL.
     * The method then checks if the url has parts of a url shortener service in it and returns a boolean accordingly
     * @param $url
     * @return bool
     * @throws ServicesException
     */
    public function isShortURL($url)
    {
        $cacheName  = md5(__FUNCTION__ . $url);

        if ($this->useCache === true) {
            $data = $this->cache->get_cache($cacheName);
            if ($data !== false) {
                return $data === '1';
            }
        }

        $services   = $this->getServices();
        $isShortURL = false;
        foreach ($services as $service=>$info) {
            if (stripos($url, $service) !== false) {
                $isShortURL = true;
                break;
            }
        }
        $this->cache->set_cache($cacheName, $isShortURL);
        return $isShortURL;
    }
}