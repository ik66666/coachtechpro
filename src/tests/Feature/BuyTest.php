<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Condition;
use App\Models\Profile;
use App\Models\SoldItem;


class BuyTest extends TestCase
{
    use RefreshDatabase;

    public function testPurchase()
    {
        $user = User::factory()->create();
        $condition = Condition::factory()->create();
        $profile = Profile::factory()->create(['users_id' => $user->id]);
        $item = Item::create([
            'name' => 'テスト商品',
            'description' => 'これはテスト商品の説明です。',
            'price' => 5000,
            'image_url' => 'test_image.jpg',
            'condition_id' => $condition->id,
            'users_id' => $user->id,
        ]);

        $response = $this->actingAs($user)->get('/perchase/' . $item->id);
        $response->assertStatus(200);
        $response->assertSee($item->name);
        $response->assertSee(number_format($item->price));
        $response->assertSee($profile->address);
        $response->assertSee('購入する');

        $response = $this->actingAs($user)->get(route('bought.item', ['item' => $item->id]));
        
        $this->assertDatabaseHas('sold_items', [
            'users_id' => $user->id,
            'item_id' => $item->id,
        ]);

        $response->assertStatus(200);
        $response->assertSee('商品の購入が完了しました');
    }

    public function testChangePaymentMethod()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();
        $profile = Profile::factory()->create(['users_id' => $user->id]);

        $response = $this->actingAs($user)->post(route('change.method', ['item' => $item->id]), [
            'paymethod' => 'credit',
            'item_id' => $item->id,
        ]);

        $response->assertViewIs('buy');
        $response->assertViewHas('paymethod', 'credit');
        $response->assertViewHas('items', $item);
        $response->assertViewHas('profile', $profile);
    }

    public function testUpdateAddress()
    {
        $user = User::factory()->create();
        $profile = Profile::factory()->create(['users_id' => $user->id]);

        $updatedData = [
            'postcode' => '1234567',
            'address' => '新宿区1-1-1',
            'building' => '新宿ビル',
        ];

        $response = $this->actingAs($user)->post('/address', $updatedData);

        $this->assertDatabaseHas('profiles', [
            'users_id' => $user->id,
            'postcode' => '1234567',
            'address' => '新宿区1-1-1',
            'building' => '新宿ビル',
        ]);
        $response->assertRedirect();
    }
}

