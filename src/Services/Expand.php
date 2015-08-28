<?php
namespace tzfrs\LongURL\Services;

use GuzzleHttp\Psr7\Stream;
use tzfrs\LongURL\Client;
use tzfrs\LongURL\Exceptions\ExpandException;

/**
 * Class Expand
 *
 * This class is used to make requests to the expand endpoint of the longURL API
 *
 * @package tzfrs\LongURL\Services
 * @version 0.0.1
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
     * @return string Returns the long URL version of the short URL
     * @throws ExpandException Throws an Exception when there was an Error
     */
    public function expandURL($url)
    {
        $parameters['url'] = $url;
        $stream     = $this->request($parameters);
        if ($stream instanceof Stream) {
            $content    = $this->parseXML($stream->getContents());
            return $content->{'long-url'};
        }
        throw new ExpandException($stream);
    }
}