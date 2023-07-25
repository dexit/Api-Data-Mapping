<?php

namespace App\ProductSources;

interface SourceInterface
{
    /**
     * Convert API response to object based on the conversion rules
     *
     * @param array $apiResponse
     * @return array
     */
    public function convertApiResponseToObject($apiResponse);
}
