<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use App\Console\Commands\DeleteLowStockProducts;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('products:delete-low-stock', function () {
    (new DeleteLowStockProducts())->handle();
})->describe('Deletes low stock products');
