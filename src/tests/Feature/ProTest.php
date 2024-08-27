<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
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

    public function testIndex()
    {

        $user1 = User::create([
            'name' => 'John Doe',
            'email' => 'johndoe@example.com',
            'password' => Hash::make('password'),
        ]);
        $condition = Condition::create([
            'condition' => '非常に良い',
        ]);

        $category = Category::create([
            'name' => 'スポーツ',
        ]);

        

        Item::factory()->create([
            'name'  => 'サンプル',
            'price' => '5000',
            'description' => 'あいうえお',
            'users_id' => $user1->id,
            'condition_id' => $condition->id,
        ]);

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
