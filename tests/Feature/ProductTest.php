<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    private $product;

    public function setUp(): void
    {
        parent::setUp();

        $this->product = Product::factory()->create();
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_products_route_returns_ok()
    {
        $response = $this->get('/products');

        $response->assertSee('Products index');

        $response->assertStatus(200);
    }

    public function test_product_has_name()
    {
        $this->assertNotEmpty($this->product->name);
    }

    public function test_products_are_not_empty()
    {
        $response = $this->get('/products');
        $response->assertSee($this->product->name);
    }

    public function test_auth_user_can_see_the_buy_button()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get('/products');
        $response->assertSee('Buy Product');
    }

    public function test_unauth_user_cannot_see_the_buy_button()
    {
        $response = $this->get('/products');
        $response->assertDontSee('Buy Product');
    }
}
