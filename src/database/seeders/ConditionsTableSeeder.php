<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Condition;
use Illuminate\Support\Facades\DB;

class ConditionsTableSeeder extends Seeder
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
            'condition' => '未使用',
        ];
        DB::table('conditions')->insert($param);
        $param = [
            'id' => 2,
            'condition' => '未使用に近い',
        ];
        DB::table('conditions')->insert($param);
        $param = [
            'id' => 3,
            'condition' => '目立った傷や汚れなし',
        ];
        DB::table('conditions')->insert($param);
        $param = [
            'id' => 4,
            'condition' => 'やや傷や汚れあり',
        ];
        DB::table('conditions')->insert($param);
        $param = [
            'id' => 5,
            'condition' => '傷や汚れあり',
        ];
        DB::table('conditions')->insert($param);
        $param = [
            'id' => 6,
            'condition' => '全体的に状態が悪い',
        ];
        DB::table('conditions')->insert($param);
    }
}
