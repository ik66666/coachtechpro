<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Comment;
use App\Models\Condition;

class CommentTest extends TestCase
{
    use RefreshDatabase;

    public function testComment()
    {
        $user = User::factory()->create();
        $condition = Condition::factory()->create();
        $item = Item::create([
            'name' => 'テスト商品',
            'description' => 'テスト商品の説明です。',
            'price' => 1000,
            'image_url' => 'test_image.jpg',
            'condition_id' => $condition->id,
            'users_id' => $user->id,
        ]);

        $response = $this->actingAs($user)->get('/comment/' . $item->id);

        $response->assertStatus(200);
        $response->assertSee($item->name);
        $response->assertSee(number_format($item->price));

        $commentData = [
            'item_id' => $item->id,
            'users_id' => $user->id,
            'comment' => 'これはテストコメントです。',
        ];

        $response = $this->actingAs($user)->post('/comment/' . $item->id, $commentData);

        $this->assertDatabaseHas('comments', $commentData);
        $response->assertRedirect(route('item.comment', $item->id));

        $response = $this->actingAs($user)->get('/comment/' . $item->id);
        $response->assertSee('これはテストコメントです。');
    }
}

