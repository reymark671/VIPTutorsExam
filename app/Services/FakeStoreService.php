<?php
namespace App\Services;

use App\Interfaces\ProductInterface;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\Response;

class FakeStoreService implements ProductInterface
{
    protected $apiUrl = 'https://fakestoreapi.com/products';

    public function addProduct(): Response
    {
        return Http::get($this->apiUrl);
    }
}