<?php

namespace App\Observers;

use App\Models\Product;
use App\Mail\ProductCreatedMail;
use Illuminate\Support\Facades\Mail;
class ProductObserver
{
    /**
     * Handle the Product "created" event.
     */
    public function created(Product $product): void
    {
        // no instruction for observers in the exam

        Mail::to('poknaitz@gmail.com')->send(new ProductCreatedMail($product));
    }

    /**
     * Handle the Product "updated" event.
     */
    public function updated(Product $product): void
    {
        //
    }

    /**
     * Handle the Product "deleted" event.
     */
    public function deleted(Product $product): void
    {
        //
    }

    /**
     * Handle the Product "restored" event.
     */
    public function restored(Product $product): void
    {
        //
    }

    /**
     * Handle the Product "force deleted" event.
     */
    public function forceDeleted(Product $product): void
    {
        //
    }
}
