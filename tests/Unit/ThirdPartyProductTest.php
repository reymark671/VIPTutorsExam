<?php
namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Product;
use App\Services\FakeStoreService;
use App\Services\PlatziService;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use PHPUnit\Framework\Attributes\Test;

class ThirdPartyProductTest extends TestCase
{
    use DatabaseTransactions;
    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan('migrate', ['--database' => 'mysql']);
    }

    #[Test]
    public function it_can_add_a_product_from_fakestore()
    {
        $service = new FakeStoreService();

        $response = $service->addProduct();

        // Check if API response is valid
        $this->assertNotNull($response, 'API response is null.');
        $this->assertTrue($response->successful(), 'API request failed.');

        $data_raw = $response->json();
        $data = $data_raw[0]; //just take the first product
        Product::create([
            'id' => $data['id'],
            'title' => $data['title'],
            'price' => $data['price'],
            'description' => $data['description'],
            'image' => $data['image'],
        ]);

        // Check if product is in the database
        $this->assertDatabaseHas('products', ['title' => $data['title']]);
    }

    #[Test]
    public function it_can_add_a_product_from_platzistore()
    {
        $service = new PlatziService();

        
       
        $response = $service->addProduct();
        
        // Check if API response is valid
        $this->assertNotNull($response, 'API response is null.');
        $this->assertTrue($response->successful(), 'API request failed.');

        $data_raw = $response->json();
       
        $data = $data_raw[0]; 
    
        // Save API response to the database
        Product::create([
            'id' => $data['id'],
            'title' => $data['title'],
            'price' => $data['price'],
            'description' => $data['description'],
            'image' => $data['images'][0], 
        ]);

        // Check if product is in the database
        $this->assertDatabaseHas('products', ['title' => $data['title']]);
    }
}
