<?php

namespace App\ProductSources\SourceOne;

use Carbon\Carbon;
use Symfony\Component\Yaml\Yaml;
use App\ProductSources\SourceInterface;

class SourceOne implements SourceInterface
{
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

    CONST SOURCE_NAME = 'SourceOne';
    CONST SOURCE_URL = 'https://run.mocky.io/v3/b7c51d7d-52c4-4364-8e26-ba5e33a99e32';

    CONST SOURCE_TYPE = 'json';

    public function convertApiResponseToObject($apiResponse)
    {
        try {
            $conversionRules = Yaml::parseFile('app/ProductSources/SourceOne/' . self::SOURCE_NAME . '.yaml');

            $products = [];
            foreach ($apiResponse as $apiProduct) {
                $product = [];
                foreach ($conversionRules['products'] as $rule) {
                    $apiField = $rule['api_field'];
                    $modelField = $rule['model_field'];

                    // Check if the field is a timestamp
                    if (isset($rule['is_timestamp']) && $rule['is_timestamp'] === true) {
                        // Convert the timestamp field using Carbon
                        $timestamp = Carbon::parse($apiProduct[$apiField])->toDateTimeString();
                        $product[$modelField] = $timestamp;
                    } else {
                        $product[$modelField] = $apiProduct[$apiField];
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
