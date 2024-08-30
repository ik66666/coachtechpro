<?php

namespace Database\Factories;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProfileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'users_id' => User::factory(), // ユーザーモデルに関連付け
            'name' => $this->faker->word(),
            'postcode' => $this->faker->postcode,
            'address' => $this->faker->address,
            'building' => $this->faker->optional()->secondaryAddress,
        ];
    }
}
