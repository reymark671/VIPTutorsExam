<?php
namespace App\Services;

use App\Interfaces\ProductInterface;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\Response;

class PlatziService implements ProductInterface
{
    protected $apiUrl = 'https://api.escuelajs.co/api/v1/products';

    public function addProduct(): Response
    {
        return Http::get($this->apiUrl);
    }
}
