<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ApiEndpointsTest extends TestCase
{
    use RefreshDatabase;

    public function test_register_endpoint()
    {
        $response = $this->postJson('/api/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertStatus(201);
    }

    public function test_login_endpoint()
    {
        $user = \App\Models\User::factory()->create([
            'password' => bcrypt('password')
        ]);

        $response = $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

       $response->assertStatus(200)
         ->assertJsonStructure([
             'data' => ['token', 'user'],
             'message',
             'status',
         ]);

    }

    public function test_get_categories()
    {
        Category::factory()->count(3)->create();

        $response = $this->getJson('/api/categories');

        $response->assertStatus(200)
         ->assertJsonStructure(['data' => [['id', 'name']]]);
;
    }

    public function test_get_category_products()
    {
        $category = Category::factory()->create();
        Product::factory()->count(2)->create(['category_id' => $category->id]);

        $response = $this->getJson("/api/categories/{$category->id}/products");

        $response->assertStatus(200)
         ->assertJsonStructure([
             'data' => [
                 'products' => [
                     ['id', 'name', 'category_id']
                 ],
                 'pagination' => [
                     'current_page',
                     'last_page',
                     'per_page',
                     'total',
                 ]
             ],
             'message',
             'status',
         ]);


    }

    public function test_authenticated_routes()
{
    Sanctum::actingAs(User::factory()->create());

    // ✅ Ensure product exists before calling cart/favourites
    $product = Product::factory()->create(['id' => 1]);

    $this->getJson('/api/products')->assertStatus(200);

    $this->postJson('/api/cart', ['product_id' => 1, 'quantity' => 1])->assertStatus(200);
    $this->postJson('/api/payment', [/* valid payment data if required */])->assertStatus(422); 
    $this->getJson('/api/favourites')->assertStatus(201);
    $this->postJson('/api/favourites', ['product_id' => 1])->assertStatus(201); 
    $this->postJson('/api/logout')->assertStatus(200);
}


    public function test_unauthenticated_routes_are_blocked()
    {
        $this->getJson('/api/products')->assertStatus(401);
        $this->postJson('/api/cart', [])->assertStatus(401);
        $this->postJson('/api/payment', [])->assertStatus(401);
        $this->getJson('/api/favourites')->assertStatus(401);
        $this->postJson('/api/logout')->assertStatus(401);
    }
}
