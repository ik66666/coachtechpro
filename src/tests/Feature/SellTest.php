<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Profile;
use App\Models\Category;
use App\Models\Condition;


class SellTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */

     use RefreshDatabase;

       public function testShowSell()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('sell'));
        $response->assertStatus(200);
        $response->assertSee('商品の出品');
    }

    public function testSell()
    {
        $user = User::factory()->create();
        $condition = Condition::factory()->create();

        $response = Item::create([
            'name' => 'テスト商品',
            'price' => 5000,
            'description' => 'テスト商品の説明',
            'users_id' => $user->id,
            'condition_id' => $condition->id,
            'image_url' => 'profile_image.jpg',
        ]);
        
        $this->assertDatabaseHas('items', [
            'name' => 'テスト商品',
            'description' => 'テスト商品の説明',
            'price' => 5000,
            'users_id' => $user->id,
            'condition_id' => $condition->id,
            'image_url' => 'profile_image.jpg',
        ]);
    }
}
