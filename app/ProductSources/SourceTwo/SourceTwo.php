<?php

namespace App\ProductSources\SourceTwo;

use Carbon\Carbon;
use Symfony\Component\Yaml\Yaml;
use App\ProductSources\SourceInterface;

class SourceTwo implements SourceInterface
{

    CONST SOURCE_NAME = 'SourceTwo';
    CONST SOURCE_URL = 'https://run.mocky.io/v3/e2128410-6caa-4637-b07f-2f49fe656f24';

    CONST SOURCE_TYPE = 'xml';


    /**
     * convertApiResponseToObject function
     */
    /**
     * get api response and content type from url
     * convert the api response to object based on the conversion rules
     * return the array of response
     * @param string $apiResponse
     * @param string $apiType
     * @return array
     */


    public function convertApiResponseToObject($apiResponse)
    {
        try {
            $conversionRules = Yaml::parseFile('app/ProductSources/SourceTwo/' . self::SOURCE_NAME . '.yaml');

            $xml = simplexml_load_string($apiResponse); // Parse the XML data

            $products = []; // Initialize the $products array

            foreach ($xml->product as $apiProduct) {
                $product = [];
                foreach ($conversionRules['products'] as $rule) {
                    $apiField = $rule['api_field'];
                    $modelField = $rule['model_field'];

                    // Check if the field is a timestamp
                    if (isset($rule['is_timestamp']) && $rule['is_timestamp'] === true) {
                        // Convert the timestamp field using Carbon
                        $timestamp = Carbon::parse((string) $apiProduct->{$apiField})->toDateTimeString();
                        $product[$modelField] = $timestamp;
                    } else {
                        $product[$modelField] = (string) $apiProduct->{$apiField};
                    }
                }
                $products[] = $product;
            }

            return $products;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }


}

?>
