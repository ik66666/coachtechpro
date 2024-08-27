<?php

namespace Database\Factories;
use App\Models\User;
use App\Models\CategoryItem;
use App\Models\Condition;
use Faker\Generator as Faker;
use App\Models\Item;


use Illuminate\Database\Eloquent\Factories\Factory;

class ItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */

     protected $model = Item::class;


    public function definition()
    {
        return [
            'name' => $this->faker->word(),
            'price' => $this->faker->numberBetween(100,999999),
            'description' => $this->faker->sentence(),
            'users_id' => User::factory(),
            'category_item_id' => CategoryItem::factory(),
            'condition_id' => Condition::factory(),
        ];
    }
}
