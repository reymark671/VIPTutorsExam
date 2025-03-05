<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Product;

class DeleteLowStockProducts extends Command
{
    protected $signature = 'products:delete-low-stock';
    protected $description = 'Deletes products with quantity less than 10 every Monday midnight.';

    public function handle()
    {
        $deletedCount = Product::where('quantity', '<', 10)
                        ->orWhereNull('quantity')
                        ->delete();

        // Ensure the output stream is available before using $this->info()
        if ($this->getOutput()) {
            $this->info("Deleted {$deletedCount} products with quantity less than 10.");
        }
    }
}
