<?php
namespace tzfrs\LongURL\Endpoints;

use GuzzleHttp\Psr7\Stream;
use tzfrs\LongURL\Client;
use tzfrs\LongURL\Exceptions\ServiceException;

/**
 * Class Services
 *
 * This class is used to make requests to the Services endpoint of the longURL API
 *
 * @package tzfrs\LongURL\Services
 * @version 0.0.2
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
     * @throws ServiceException
     */
    public function getServices($format = 'json')
    {
        $stream     = $this->request();
        if ($stream instanceof Stream) {
            $content    = $stream->getContents();
            return $format === 'json' ? json_decode($content) : $this->parseXML($content);
        }
        throw new ServiceException($stream);
    }

    /**
     * This method checks wheter an URL is shortened or a long version
     *
     * This method gets the url as a parameter, then gets all the services that are supported by LongURL.
     * The method then checks if the url has parts of a url shortener service in it and returns a boolean accordingly
     * @param $url
     * @return bool
     * @throws ServiceException
     */
    public function isShortURL($url)
    {
        $services = $this->getServices();
        foreach ($services as $service=>$info) {
            if (stripos($url, $service) !== false) {
                return true;
            }
        }
        return false;
    }
}