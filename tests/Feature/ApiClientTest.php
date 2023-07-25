<?php
namespace Tests\Feature;

use App\Services\ApiClient;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Mockery;
use Tests\TestCase;

class ApiClientTest extends TestCase
{
    public function testGetDataFromApiSourceOne()
    {
        // Mock the API response
        $apiResponse = $this->apiResponseForSourceOne();

        // Create a mock client
        $mockClient = Mockery::mock(Client::class);
        $mockClient->shouldReceive('get')->andReturn(new Response(200, ['Content-Type' => 'application/json'], json_encode($apiResponse)));

        // Bind the mock client instance to the ApiClient in the service container
        $this->app->bind(Client::class, function () use ($mockClient) {
            return $mockClient;
        });

        // Create an instance of the ApiClient
        $apiService = $this->app->make(ApiClient::class);

        // Call the getApiResponse method, which should use the mocked client
        $data = $apiService->getApiResponse('https://run.mocky.io/v3/b7c51d7d-52c4-4364-8e26-ba5e33a99e32');

        // Assert that the data returned is as expected
        $this->assertEquals($apiResponse, $data);
    }



    public function testGetJsonApiResponse()
    {
        // Mock the API response
        $apiResponse = $this->apiResponseForSourceOne();

        // Create a mock client for JSON response
        $mockClient = Mockery::mock(Client::class);
        $mockClient->shouldReceive('get')->andReturn(new Response(200, ['Content-Type' => 'application/json'], json_encode($apiResponse)));

        // Bind the mock client instance to the ApiClient in the service container
        $this->app->bind(Client::class, function () use ($mockClient) {
            return $mockClient;
        });

        // Create an instance of the ApiClient
        $apiService = $this->app->make(ApiClient::class);

        // Call the getApiResponse method with a URL for JSON response
        $data = $apiService->getApiResponse('https://run.mocky.io/v3/b7c51d7d-52c4-4364-8e26-ba5e33a99e32');

        // Assert that the data returned is as expected
        $this->assertEquals($apiResponse, $data);
    }



//    public function testGetDataFromApiXml()
//    {
//        // Mock the API XML response
//        $mockApiResponse = $this->apiResponseForSourceTwo();
//        $xmlString = $this->convertArrayToXml($mockApiResponse);
//
//        $mockUrl = 'https://run.mocky.io/v3/e2128410-6caa-4637-b07f-2f49fe656f24';
//
//        $httpClient = Mockery::mock(Client::class);
//        $httpClient->shouldReceive('get')->andReturn(
//            new Response(200, ['Content-Type' => 'application/xml'], $xmlString)
//        );
//
//        $apiService = new ApiClient($httpClient);
//        $data = $apiService->getApiResponse($mockUrl);
//
//        // Expected PHP array from XML data
//        $expectedArray = $mockApiResponse;
//
//        // Assert that the data returned is as expected
//        $this->assertEquals($expectedArray, $data);
//    }

    private function convertArrayToXml(array $data)
    {
        $xml = new \SimpleXMLElement('<?xml version="1.0"?><products></products>');
        $this->arrayToXml($data, $xml);
        return $xml->asXML();
    }

    private function arrayToXml(array $data, \SimpleXMLElement $xml)
    {
        foreach ($data as $key => $value) {
            if (is_array($value)) {
                if (is_numeric($key)) {
                    $key = 'product';
                }
                $subnode = $xml->addChild($key);
                $this->arrayToXml($value, $subnode);
            } else {
                $xml->addChild($key, $value);
            }
        }
    }


    private function apiResponseForSourceOne()
    {
       return [
            [
                "product_name" => "Widget A",
                "product_quantity" => 100,
                "product_price" => 19.99,
                "created_at" => "2023-07-23T10:15:00Z",
                "updated_at" => "2023-07-23T10:15:00Z",
            ],
            [
                "product_name" => "Gadget B",
                "product_quantity" => 50,
                "product_price" => 49.95,
                "created_at" => "2023-07-23T11:30:00Z",
                "updated_at" => "2023-07-23T11:30:00Z",
            ],
            [
                "product_name" => "Tool C",
                "product_quantity" => 25,
                "product_price" => 29.99,
                "created_at" => "2023-07-23T12:45:00Z",
                "updated_at" => "2023-07-23T12:45:00Z",
            ],
            [
                "product_name" => "Device D",
                "product_quantity" => 75,
                "product_price" => 99,
                "created_at" => "2023-07-23T14:00:00Z",
                "updated_at" => "2023-07-23T14:00:00Z",
            ],
            [
                "product_name" => "Accessory E",
                "product_quantity" => 200,
                "product_price" => 9.95,
                "created_at" => "2023-07-23T15:15:00Z",
                "updated_at" => "2023-07-23T15:15:00Z",
            ],
            [
                "product_name" => "Appliance F",
                "product_quantity" => 30,
                "product_price" => 249.99,
                "created_at" => "2023-07-23T16:30:00Z",
                "updated_at" => "2023-07-23T16:30:00Z",
            ],
            [
                "product_name" => "Software G",
                "product_quantity" => 500,
                "product_price" => 149.95,
                "created_at" => "2023-07-23T17:45:00Z",
                "updated_at" => "2023-07-23T17:45:00Z",
            ],
            [
                "product_name" => "Book H",
                "product_quantity" => 75,
                "product_price" => 12.99,
                "created_at" => "2023-07-23T19:00:00Z",
                "updated_at" => "2023-07-23T19:00:00Z",
            ],
            [
                "product_name" => "Clothing I",
                "product_quantity" => 150,
                "product_price" => 29.95,
                "created_at" => "2023-07-23T20:15:00Z",
                "updated_at" => "2023-07-23T20:15:00Z",
            ],
            [
                "product_name" => "Toy J",
                "product_quantity" => 50,
                "product_price" => 19.99,
                "created_at" => "2023-07-23T21:30:00Z",
                "updated_at" => "2023-07-23T21:30:00Z",
            ],
        ];

    }


    private function apiResponseForSourceTwo()
    {
        return [
            [
                "product_name" => "Smartphone X",
                "product_quantity" => 50,
                "product_price" => 599.99,
                "created_at" => "2023-07-23T09:00:00Z",
                "updated_at" => "2023-07-23T09:00:00Z",
            ],
            [
                "product_name" => "Laptop Y",
                "product_quantity" => 25,
                "product_price" => 899.95,
                "created_at" => "2023-07-23T10:30:00Z",
                "updated_at" => "2023-07-23T10:30:00Z",
            ],
            [
                "product_name" => "Headphones Z",
                "product_quantity" => 100,
                "product_price" => 59.99,
                "created_at" => "2023-07-23T12:00:00Z",
                "updated_at" => "2023-07-23T12:00:00Z",
            ],
            [
                "product_name" => "Camera A",
                "product_quantity" => 20,
                "product_price" => 449.00,
                "created_at" => "2023-07-23T13:30:00Z",
                "updated_at" => "2023-07-23T13:30:00Z",
            ],
            [
                "product_name" => "Watch B",
                "product_quantity" => 75,
                "product_price" => 149.95,
                "created_at" => "2023-07-23T15:00:00Z",
                "updated_at" => "2023-07-23T15:00:00Z",
            ],
            [
                "product_name" => "Tablet C",
                "product_quantity" => 30,
                "product_price" => 299.99,
                "created_at" => "2023-07-23T16:30:00Z",
                "updated_at" => "2023-07-23T16:30:00Z",
            ],
            [
                "product_name" => "Printer D",
                "product_quantity" => 50,
                "product_price" => 199.95,
                "created_at" => "2023-07-23T18:00:00Z",
                "updated_at" => "2023-07-23T18:00:00Z",
            ],
            [
                "product_name" => "Speaker E",
                "product_quantity" => 40,
                "product_price" => 79.99,
                "created_at" => "2023-07-23T19:30:00Z",
                "updated_at" => "2023-07-23T19:30:00Z",
            ],
            [
                "product_name" => "Drone F",
                "product_quantity" => 15,
                "product_price" => 299.00,
                "created_at" => "2023-07-23T21:00:00Z",
                "updated_at" => "2023-07-23T21:00:00Z",
            ],
            [
                "product_name" => "Keyboard G",
                "product_quantity" => 60,
                "product_price" => 49.95,
                "created_at" => "2023-07-23T22:30:00Z",
                "updated_at" => "2023-07-23T22:30:00Z",
            ],
        ];

    }




    private function xmlFileForSourceTwo()
    {
       return   "<products>
<product>
<product_name>Smartphone X</product_name>
<product_quantity>50</product_quantity>
<product_price>599.99</product_price>
<created_at>2023-07-23T09:00:00Z</created_at>
<updated_at>2023-07-23T09:00:00Z</updated_at>
</product>
<product>
<product_name>Laptop Y</product_name>
<product_quantity>25</product_quantity>
<product_price>899.95</product_price>
<created_at>2023-07-23T10:30:00Z</created_at>
<updated_at>2023-07-23T10:30:00Z</updated_at>
</product>
<product>
<product_name>Headphones Z</product_name>
<product_quantity>100</product_quantity>
<product_price>59.99</product_price>
<created_at>2023-07-23T12:00:00Z</created_at>
<updated_at>2023-07-23T12:00:00Z</updated_at>
</product>
<product>
<product_name>Camera A</product_name>
<product_quantity>20</product_quantity>
<product_price>449.00</product_price>
<created_at>2023-07-23T13:30:00Z</created_at>
<updated_at>2023-07-23T13:30:00Z</updated_at>
</product>
<product>
<product_name>Watch B</product_name>
<product_quantity>75</product_quantity>
<product_price>149.95</product_price>
<created_at>2023-07-23T15:00:00Z</created_at>
<updated_at>2023-07-23T15:00:00Z</updated_at>
</product>
<product>
<product_name>Tablet C</product_name>
<product_quantity>30</product_quantity>
<product_price>299.99</product_price>
<created_at>2023-07-23T16:30:00Z</created_at>
<updated_at>2023-07-23T16:30:00Z</updated_at>
</product>
<product>
<product_name>Printer D</product_name>
<product_quantity>50</product_quantity>
<product_price>199.95</product_price>
<created_at>2023-07-23T18:00:00Z</created_at>
<updated_at>2023-07-23T18:00:00Z</updated_at>
</product>
<product>
<product_name>Speaker E</product_name>
<product_quantity>40</product_quantity>
<product_price>79.99</product_price>
<created_at>2023-07-23T19:30:00Z</created_at>
<updated_at>2023-07-23T19:30:00Z</updated_at>
</product>
<product>
<product_name>Drone F</product_name>
<product_quantity>15</product_quantity>
<product_price>299.00</product_price>
<created_at>2023-07-23T21:00:00Z</created_at>
<updated_at>2023-07-23T21:00:00Z</updated_at>
</product>
<product>
<product_name>Keyboard G</product_name>
<product_quantity>60</product_quantity>
<product_price>49.95</product_price>
<created_at>2023-07-23T22:30:00Z</created_at>
<updated_at>2023-07-23T22:30:00Z</updated_at>
</product>
</products>";
    }


}
