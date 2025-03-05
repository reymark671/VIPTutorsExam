<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Product;
use PHPUnit\Framework\Attributes\Test;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ProductTest extends TestCase
{
    use DatabaseTransactions;
    protected function setUp(): void
    {
        parent::setUp();

        // Ensure migrations run automatically (if not already applied)
        $this->artisan('migrate', ['--database' => 'mysql']);
    }

   #[Test] 
    public function it_can_create_a_product()
    {
        $product = Product::create([
            'id' => 1,
            'title' => 'Test Product',
            'price' => 100.50,
            'description' => 'This is a test product',
            'category' => 'Test Category',
            'image' => 'https://example.com/image.jpg',
        ]);

        $this->assertDatabaseHas('products', ['title' => 'Test Product']);
    }

   #[Test] 
    public function it_can_read_a_product()
    {
        $product = Product::factory()->create();

        $foundProduct = Product::find($product->id);

        $this->assertNotNull($foundProduct);
        $this->assertEquals($product->title, $foundProduct->title);
    }

   #[Test] 
    public function it_can_update_a_product()
    {
        $product = Product::factory()->create();

        $product->update(['title' => 'Updated Title']);

        $this->assertDatabaseHas('products', ['title' => 'Updated Title']);
    }

   #[Test] 
    public function it_can_delete_a_product()
    {
        $product = Product::factory()->create(); 
    
        $this->assertDatabaseHas('products', ['id' => $product->id]); 

        $product->delete(); 

        $this->assertDatabaseMissing('products', ['id' => $product->id]); 
    }
}
