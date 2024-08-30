<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\AdminUser;
use App\Models\User;
use App\Models\Comment;
use App\Models\Item;
use App\Models\Condition;
use App\Mail\AdminEmail;
use Illuminate\Support\Facades\Mail;

use Illuminate\Foundation\Testing\RefreshDatabase;

class AdminTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function testAdminLoginView()
    {
        $response = $this->get('/admin/login_form');

        $response->assertStatus(200);
        $response->assertSee('管理者ログイン');
    }

    /** @test */
    public function testAdminLogin()
    {
        $admin = AdminUser::create([
            'name' => 'test',
            'email' => 'admin@example.com',
            'password' => bcrypt('password123'),
        ]);

        $response = $this->post('/admin/login_form', [
            'name' => 'test',
            'email' => 'admin@example.com',
            'password' => 'password123',
        ]);

        $response->assertRedirect('/admin');
        $this->assertAuthenticatedAs($admin, 'admin');
    }
    
    /** @test */
    public function testAdminHome()
    {
        $admin = AdminUser::create([
            'name' => 'test',
            'email' => 'admin@example.com',
            'password' => bcrypt('password123'),
        ]);

        $this->actingAs($admin, 'admin');

        $response = $this->get('/admin');

        $response->assertStatus(200);
        $response->assertSee('管理画面');
    }

    /** @test */
    public function testAdminComment()
    {
        $admin = AdminUser::create([
            'name' => 'test',
            'email' => 'admin@example.com',
            'password' => bcrypt('password123'),
        ]);
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
        $comment = Comment::create([
            'users_id' => $user->id ,
            'item_id' => $item->id ,
            'comment' => 'テスト' ,
        ]);

        $this->actingAs($admin, 'admin');

        $response = $this->get("/admin/{$user->id}");

        $response->assertStatus(200);
        $response->assertSee($comment->comment);
    }

    /** @test */
    public function testDeleteUser()
    {
         $admin = AdminUser::create([
            'name' => 'test',
            'email' => 'admin@example.com',
            'password' => bcrypt('password123'),
        ]);

        $this->actingAs($admin, 'admin');

        $user = User::factory()->create();
        $response = $this->delete(route('admin.deleteUser', ['user' => $user->id]));

        $this->assertDatabaseMissing('users', ['id' => $user->id]);
        $response->assertRedirect('/admin');
    }

    /** @test */
    public function testDeleteComment()
    {
         $admin = AdminUser::create([
            'name' => 'test',
            'email' => 'admin@example.com',
            'password' => bcrypt('password123'),
        ]);
        $this->actingAs($admin, 'admin');

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
        $comment = Comment::create([
            'users_id' => $user->id ,
            'item_id' => $item->id ,
            'comment' => 'テスト' ,
        ]);
        $response = $this->delete(route('admin.deleteComment', ['comment' => $comment->id]));

        $this->assertDatabaseMissing('comments', ['id' => $comment->id]);

        $response->assertRedirect();
    }

}

