<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AdminUser;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = [
            'name' => 'admin',
            'email' => 'test@test.com',
            'password' => Hash::make('password'),
        ];
        $adminUser = new AdminUser;
        $adminUser->fill($param)->save();
    }
}
