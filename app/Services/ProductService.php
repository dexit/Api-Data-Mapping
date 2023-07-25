<?php

namespace App\Services;

use Symfony\Component\Yaml\Yaml;

class ProductService
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

    public function convertApiResponseToObject($apiResponse, $apiType)
    {
        try {

            $conversionRules = Yaml::parseFile('app/Config/api_conversion_' . $apiType . '.yaml');

            $products = [];
            foreach ($apiResponse as $apiProduct) {
                $product = [];
                foreach ($conversionRules['products'] as $rule) {
                    $apiField = $rule['api_field'];
                    $modelField = $rule['model_field'];
                    $product[$modelField] = $apiProduct[$apiField];
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
