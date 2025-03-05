<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
class UpdateProductQuantity extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-product-quantity {--id=} {--quantity=}';
    //sample command: php artisan app:update-product-quantity --id=1 --quantity=10
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update product quantity. If no ID is given, update all products.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
        $this->info('Product quantities updating.');
        $id = $this->option('id'); 
        $quantity = (int) $this->option('quantity'); 

        if ($id) {
            
            $product = Product::find($id);

            if (!$product) {
                $this->error("Product not found.");
                return;
            }

            $product->increment('quantity', $quantity);
            $this->info("Updated product ID $id. New quantity: " . $product->quantity);
        } else {
            Product::query()->update(['quantity' => DB::raw("quantity + $quantity")]);
            $this->info("Updated all products by $quantity.");
        }
    }
}
