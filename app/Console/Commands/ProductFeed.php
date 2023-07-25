<?php

namespace App\Console\Commands;

use App\Models\Product;
use App\Services\ApiClient;
use App\Services\ProductService;
use Illuminate\Console\Command;

class ProductFeed extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:product-feed {source}';

    protected $description = 'Fetch data from API based on the source';


    public function __construct(ApiClient $ApiClient, ProductService $ProductService, Product $Product)
    {
        parent::__construct();
        $this->ApiClient = $ApiClient;
        $this->ProductService = $ProductService;
        $this->Product = $Product;
    }
    /**
     * The console command description.
     *
     * @var string
     */
    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {

            $sourceName = $this->argument('source');

            if(!in_array($sourceName, ['source1', 'source2'])) {
                $this->error('Invalid source name');
                return;
            }

            if($sourceName == 'source1')
                $source = "https://run.mocky.io/v3/b7c51d7d-52c4-4364-8e26-ba5e33a99e32";
            else if($sourceName == 'source2')
            {
                $source = "https://run.mocky.io/v3/e2128410-6caa-4637-b07f-2f49fe656f24";
            }

            $data = $this->ApiClient->getApiResponseAndContentType($source);

            $this->info('Data fetched from source');

            $data =  $this->ProductService->convertApiResponseToObject($data['body'],$data['content_type']);

            $this->info('Data successfully converted to writable format');

            $this->Product->insertOrUpdate($data);

            $this->info('Data successfully inserted to database');

        } catch (\Exception $e) {
            $this->error('Error while fetching data from source');
        }


    }
}
