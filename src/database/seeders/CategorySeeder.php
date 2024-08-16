<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = [
            'id' => 1,
            'name' => 'ファッション',
        ];
        DB::table('categories')->insert($param);
        $param = [
            'id' => 2,
            'name' => '家電',
        ];
        DB::table('categories')->insert($param);
        $param = [
            'id' => 3,
            'name' => 'スポーツ',
        ];
        DB::table('categories')->insert($param);
        $param = [
            'id' => 4,
            'name' => '日用品',
        ];
        DB::table('categories')->insert($param);
        $param = [
            'id' => 5,
            'name' => 'レジャー',
        ];
        DB::table('categories')->insert($param);
    }
}
