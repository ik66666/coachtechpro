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

        $items = Item::factory()->count(5)->create();
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertViewIs('index');

        foreach ($items as $item) {
        $response->assertSee($item->name);
        $response->assertSee(number_format($item->price)); 
        }
    }
    public function testNoRoute()
    {
        
        $response = $this->get('/no_route');
        $response->assertStatus(404); 
    }
    public function testRegister()
    {
        $userData = [
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ];

        $response = $this->post('/register', $userData);

        $response->assertRedirect('/login'); 

        $this->assertDatabaseHas('users', [
            'email' => 'test@example.com',
        ]);
    }

    public function testLogin()
    {

        $user = User::create([
            'email' => 'iii@example.com',
            'password' => Hash::make('password'),
        ]);


        $response = $this->post('/login', [
            'email' => 'iii@example.com',
            'password' => 'password',
        ]);


        $response->assertRedirect('/login');
        $this->assertAuthenticatedAs($user);
    }

    

}
