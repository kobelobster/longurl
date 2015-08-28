<?php

namespace tzfrs\LongURL;

use \GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\ClientException;

class Client
{
    protected $baseURL  = 'http://api.longurl.org';
    protected $version  = 'v2';
    protected $endpoint = null;

    /**
     * This method executes requests to the LongURL API.
     *
     * The method has two function arguments, parameters and url. The parameters are the  query parameters sent with
     * the request, e.g. the URL that should be queried. The method builds a base URL by building a string with the
     * API baseURL, version and the endpoint (which is set by the classes that are extending the base Class).
     * Then Guzzle is used to make a request. If an error occurs, e.g. 400 or 404, and error message is thrown.
     *
     * @param array $parameters The parameters that are sent with the request
     * @return \Psr\Http\Message\StreamInterface|string
     */
    protected function request(Array $parameters = [])
    {
        $url    = $this->baseURL . '/' . $this->version . '/' . $this->endpoint;
        $client = new GuzzleClient;
        try {
            $result = $client->get($url, [
                'query' => $parameters
            ]);
            return $result->getBody();
        } catch (ClientException $e) {
            return 'API-Request to: '. $e->getRequest()->getUri() . ' failed. ' . $e->getMessage();
        }
    }

    /**
     * This method gets XML and simply converts it into JSON
     *
     * The method takes an XML string and loads an SimpleXMLElement object while keeping CDATA values which would be
     * lost without the last attribute. The method then encodes the XML and decodes it afterwards finally turning it
     * into json. It's optional to get the JSON as array or as objects
     *
     * @param string $xml The XML that should be parsed
     * @param bool $asArray If the returned json should be an array or a json
     *
     * @return mixed
     */
    protected function parseXML($xml, $asArray = false)
    {
        $xml    = simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA);
        $json   = json_encode($xml);
        return json_decode($json, $asArray);
    }
}