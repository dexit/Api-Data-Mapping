<?php

namespace App\Services;

use GuzzleHttp\Client;

 class ApiClient
{
    protected $client;


    /**
    * __construct function
    */
    /**
    * ApiClient constructor.
    */
    public function __construct()
    {
        $this->client = new Client();
    }



     /**
      * getApiResponse function
      */
     /**
      * get api response and content type from url
      * return the array of response
      * @param string $url
      * @return array
      */
     public function getApiResponse($url)
     {
         $response = $this->client->get($url);
         $contentType = $response->getHeaderLine('Content-Type');

         // Check the content type to determine how to handle the response
         if (strpos($contentType, 'application/json') !== false) {
             // JSON response
             return $response->getBody();
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
?>
