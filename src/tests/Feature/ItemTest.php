<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Profile;
use App\Models\Category;
use App\Models\Condition;
use App\Models\CategoryItem;
use App\Models\Like;

class ItemTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    use RefreshDatabase;

    public function testItemDetail()
    {
        $user = User::factory()->create();
        $condition = Condition::factory()->create();
        $item = Item::create([
            'name' => 'テスト商品',
            'description' => 'これはテスト商品の説明です。',
            'price' => 1000,
            'image_url' => 'test_image.jpg',
            'condition_id' => $condition->id,
            'users_id' => $user->id,
        ]);

        $response = $this->actingAs($user)->post('/favorite/' . $item->id, [
            'item_id' => $item->id,
            'users_id' => $user->id,
        ]);
        $this->assertDatabaseHas('likes', [
                    'users_id' => $user->id,
                    'item_id' => $item->id,
                ]);


        $response = $this->actingAs($user)->get('/detail/' . $item->id);

        $response->assertStatus(200);
        $response->assertSee($item->name);
        $response->assertSee($item->description);
        $response->assertSee(number_format($item->price));
        $response->assertSee('商品説明');
        $response->assertSee($item->condition->condition);
        $response->assertSee('購入する');
        $response->assertSee(asset('storage/images/' . $item->image_url));

        $response->assertSee('form__like');
    }

    public function testMyFavorite()
    {
        $user = User::factory()->create();
        $condition = Condition::factory()->create();
        $item = Item::create([
            'name' => 'テスト商品',
            'description' => 'これはテスト商品の説明です。',
            'price' => 1000,
            'image_url' => 'test_image.jpg',
            'condition_id' => $condition->id,
            'users_id' => $user->id,
        ]);
        Like::create(['users_id' => $user->id, 'item_id' => $item->id]);

        $response = $this->actingAs($user)->get('/my-favorite');
        $response->assertStatus(200);
        $response->assertViewIs('favorite');

        $response->assertSee('テスト商品');
        $response->assertSee('¥1,000');
    }

}
