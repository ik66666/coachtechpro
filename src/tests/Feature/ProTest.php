<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Category;
use App\Models\Condition;



class ProTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $condition = Condition::factory()->count(5)->create();
        $category = Category::factory()->count(5)->create();
    }

    public function testIndex()
    {
        $category = Category::factory()->count(5)->create();
        $items = Item::factory()->count(5)->create();

        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertViewIs('index');
        $response = $this->get('/no_route');
        $response->assertStatus(404);
        
        foreach ($items as $item) {
            $response->assertSee($item->name);
        }
        foreach ($items as $item) {
            $response->assertSee($item->price);
        }
    }
}
