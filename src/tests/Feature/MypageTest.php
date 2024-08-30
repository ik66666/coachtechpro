<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Profile;
use App\Models\Category;
use App\Models\Condition;
use App\Models\SoldItem;


class MypageTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */

     use RefreshDatabase;

    public function testMypage()
    {
         $user = User::create([
            'email' => 'iii@example.com',
            'password' => Hash::make('password'),
            'image_url' => 'profile_image.jpg', 
        ]);

        $profile = Profile::create([
            'users_id' => $user->id,
            'name' => 'aaa',
            'postcode'  => 1234567,
            'address' => '千葉県',
            'image_url' => 'profile_image.jpg', 
        ]);

        $items = Item::factory()->count(3)->create(['users_id' => $user->id]);

        $this->actingAs($user);
        $response = $this->get('/mypage');
        $response->assertStatus(200);
        $response->assertViewIs('mypage');

        $response->assertSee($profile->name);
        $response->assertSee('<img src="' . asset('storage/images/' . $profile->image_url) . '"', false);

        foreach ($items as $item) {
            $response->assertSee($item->name);
            $response->assertSee('<img src="' . asset('storage/images/' . $item->image_url) . '"', false);
        }
        $response->assertSee('プロフィールを編集');
    }

    public function testProfileEdit()
    {
        $user = User::create([
            'email' => 'iii@example.com',
            'password' => Hash::make('password'),
        ]);

        $this->actingAs($user);

        $response = $this->get('/mypage/profile');

        $response->assertStatus(200);
        $response->assertViewIs('profile');
    }
    public function testProfileUpdate()
    {
        $user = User::create([
            'email' => 'iii@example.com',
            'password' => Hash::make('password'),
        ]);

        $this->actingAs($user);

         $profile = Profile::create([
            'users_id' => $user->id,
            'name' => 'aaa',
            'postcode'  => 1234567,
            'address' => '千葉県',
            'image_url' => 'profile_image.jpg', 
        ]);

        $data = [
            'users_id' => $user->id,
            'name' => 'bbb',
            'postcode'  => 1234555,
            'address' => '千葉',
            'image_url' => 'profile_image.jpg',
        ];

        $response = $this->post('/mypage/edit-profile', $data);

        $this->assertDatabaseHas('profiles', [
            'users_id' => $user->id,
            'name' => 'aaa',
            'postcode'  => 1234567,
            'address' => '千葉県',
            'image_url' => 'profile_image.jpg',
        ]);
    }

    public function testMyBuyItem()
    {
        $user = User::factory()->create();
        $condition = Condition::factory()->create();
        $profile = Profile::factory()->create(['users_id' => $user->id]);
        $item = Item::create([
            'name' => 'テスト商品',
            'description' => 'これはテスト商品の説明です。',
            'price' => 1000,
            'image_url' => 'test_image.jpg',
            'condition_id' => $condition->id,
            'users_id' => $user->id,
        ]);

        SoldItem::create(['users_id' => $user->id, 'item_id' => $item->id]);

        $response = $this->actingAs($user)->get('/mypage/buy');
        $response->assertStatus(200);
        $response->assertViewIs('buy-item');

        $response->assertSee('テスト商品');
        $response->assertSee($profile->name);
    }
}
