<?php
namespace App\Factories;

use App\Interfaces\ProductInterface;
use App\Services\FakeStoreService;
use App\Services\PlatziService;
use InvalidArgumentException;

class ProductServiceFactory
{
    public static function make(string $provider): ProductInterface
    {
        return match ($provider) {
            'fakestore' => new FakeStoreService(),
            'platzi' => new PlatziService(),
            default => throw new InvalidArgumentException("Invalid provider: $provider"),
        };
    }
}
