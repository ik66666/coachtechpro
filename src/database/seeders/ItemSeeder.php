<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('items')->insert([
            'name'  => 'サンプル',
            'price' => '5000',
            'description' => 'あいうえお',
            'user_id' => 1,
            'category_item_id' => 1,
            'condition_id' => 1,

            
        ]);
    }
}
