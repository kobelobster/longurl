<?php
namespace tzfrs\LongURL\Endpoints;

use GuzzleHttp\Psr7\Stream;
use tzfrs\LongURL\Client;
use tzfrs\LongURL\Exceptions\ExpandException;

/**
 * Class Expand
 *
 * This class is used to make requests to the expand endpoint of the longURL API
 *
 * @package tzfrs\LongURL\Services
 * @version 0.0.2
 * @author tzfrs
 * @license MIT License
 */
class Expand extends Client
{
    /**
     * The endpoint that is used for requests to the API
     * @var string
     */
    protected $endpoint = 'expand';

    /**
     * This method makes a rquest to the expand endpoint and gets the long version of an URL
     *
     * The method takes a short URL and makes a request to the API of longurl.org. Then, if it was successful,
     * meaning there wasn't an Exception the Content XML is parsed and the long-url is extracted from the response.
     * Otherwise an Exception is thrown.
     *
     * @see Client::request
     *
     * @param string $url The URL that should be expanded
     * @param string $format The format in which the response should be returned. Defaults to xml
     * @return string Returns the long URL version of the short URL
     * @throws ExpandException Throws an Exception when there was an Error
     */
    public function expandURL($url, $format = 'json')
    {
        // Check if a short url has been passed
        if ((new Services)->isShortURL($url) === false) {
            return $url;
        }

        $parameters['url']  = $url;
        $stream     = $this->request($parameters, $format);
        if ($stream instanceof Stream) {
            $content = $stream->getContents();
            $content = $format === 'json' ? json_decode($content) : $this->parseXML($content);
            return $content->{'long-url'};
        }
        throw new ExpandException($stream);
    }
}