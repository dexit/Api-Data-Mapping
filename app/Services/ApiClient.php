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
        return json_decode($response->getBody(), true);
    }




     /**
      * getApiResponseAndContentType function
      */
     /**
      * get api response and content type from url
      * return the array of response and content type
      * @param string $url
      * @return array
      */

     public function getApiResponseAndContentType($url)
     {
         $response = $this->client->get($url);

         $data = [];
         $data['body']         = json_decode($response->getBody(), true);
         $data['content_type'] = $response->getHeader('Content-Type');

         // Content-Type başlık değerini alırken, genellikle bir dizi olarak döner
         // Çünkü birden fazla başlık olabilir. Bu nedenle ilk elemanı alıyoruz.
         // write this in english please
         //


         $contentType = isset($data['content_type'][0]) ? $data['content_type'][0] : '';

         if (strpos($contentType, 'application/json') !== false) {
             $data['content_type'] = 'json';
         } elseif (strpos($contentType, 'application/xml') !== false) {

             $data['content_type'] = 'xml';
         } else {
            return 'This Content Type is not supported';
         }

         return $data;
     }

}
?>
