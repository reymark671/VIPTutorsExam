<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Product;
use App\Factories\ProductServiceFactory;

class FetchProductsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'products:fetch {provider}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch products from an external API and store them in the database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $provider = $this->argument('provider');

        try {
            $service = ProductServiceFactory::make($provider);
            $response = $service->addProduct([]);
           
            if ($response->successful()) {
                $products = $response->json();
                
                foreach ($products as $product) {
                    
                    Product::updateOrCreate(
                        ['title' => $product['title']],
                        [
                            'title' => $product['title'] ?? 'No Title',
                            'price' => $product['price'] ?? 0.0,
                            'description' => $product['description'] ?? 'No description available',
                            'category' => $this->getCategory($product),
                            'image' => $this->getImage($product),
                        ]
                    );
                }

                $this->info('Products fetched and saved successfully.');
            } else {
                $this->error('Failed to fetch products.');
            }
        } catch (\Exception $e) {
            $this->error('Error: ' . $e->getMessage());
        }
    }

    /**
     * Handle different category structures.
     */
    private function getCategory(array $product): string
    {
        if (isset($product['category']) && is_array($product['category'])) {
            return $product['category']['name'] ?? 'Unknown Category'; // Platzi API
        }

        return is_string($product['category'] ?? '') ? $product['category'] : 'Unknown Category'; // FakeStore API
    }

    /**
     * Handle different image structures.
     */
    private function getImage(array $product): string
    {
        if (isset($product['images']) && is_array($product['images']) && count($product['images']) > 0) {
            return $product['images'][0]; // Platzi API
        }

        return $product['image'] ?? ''; // FakeStore API
    }
}
