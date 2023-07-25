<?php

namespace App\Services;

use GuzzleHttp\Client;

class ApiClient
{
    protected $client;

    /**
     * ApiClient constructor.
     *
     * @param Client|null $client
     */
    public function __construct(Client $client = null)
    {
        $this->client = $client ?? new Client();
    }

    /**
     * getApiResponse function
     *
     * @param string $url
     * @return array|string
     * @throws \Exception
     */
    public function getApiResponse($url)
    {
        $response = $this->client->get($url);
        $contentType = $response->getHeaderLine('Content-Type');

        // Check the content type to determine how to handle the response
        if (strpos($contentType, 'application/json') !== false) {
            // JSON response
            return json_decode($response->getBody(), true);
        } elseif (strpos($contentType, 'application/xml') !== false) {
            // XML response
            $xmlString = $response->getBody()->getContents();
            return $xmlString;
        } else {
            // Unsupported content type
            throw new \Exception('Unsupported content type: ' . $contentType);
        }
    }
}
