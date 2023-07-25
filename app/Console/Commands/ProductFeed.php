<?php

namespace App\Console\Commands;

use App\Models\Product;
use App\ProductSources\SourceOne\SourceOne;
use App\ProductSources\SourceTwo\SourceTwo;
use App\Services\ApiClient;
use Illuminate\Console\Command;

class ProductFeed extends Command
{
    protected $signature = 'app:product-feed {source}';
    protected $description = 'Fetch data from API based on the source';



    protected $ApiClient;
    protected $ProductService;
    protected $Product;


    /**
     * __construct function
     */
    public function __construct(ApiClient $ApiClient)
    {
        parent::__construct();
        $this->ApiClient = $ApiClient;
        $this->Product = new Product();
    }


    /**
     * handle function
     */
    public function handle()
    {
        try {
            $sourceName = $this->argument('source');

            // Check if the specified source is valid
            if (!in_array($sourceName, ['sourceOne', 'sourceTwo'])) {
                $this->error('Invalid source name');
                return;
            }

            $sourceClass = null;
            switch ($sourceName) {
                case 'sourceOne':
                    $sourceClass = SourceOne::class;
                    break;
                case 'sourceTwo':
                    $sourceClass = SourceTwo::class;
                    break;
            }

            // Check if the source class is valid
            if ($sourceClass === null || !class_exists($sourceClass)) {
                $this->error('Invalid source class');
                return;
            }

            // Instantiate the source class
            $source = new $sourceClass();

            // Get the source-specific constants
            $sourceName = $source::SOURCE_NAME;
            $sourceUrl = $source::SOURCE_URL;
            $sourceType = $source::SOURCE_TYPE;

            $data = $this->ApiClient->getApiResponse($sourceUrl);

            $this->info('Data fetched from source');


            // Convert the data using the source-specific conversion method
            $data = $source->convertApiResponseToObject($data);

            $this->info('Data successfully converted to writable format');
            $this->Product->insert($data);

            $this->info('Data successfully inserted to the database');

        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }
    }
}
