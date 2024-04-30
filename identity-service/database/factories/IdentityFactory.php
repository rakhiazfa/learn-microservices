<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Identity>
 */
class IdentityFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $genders = ['Pria', 'Wanita'];

        return [
            'registration_number' => fake()->unique()->numerify('################'),
            'name' => fake()->name(),
            'place_of_birth' => fake()->city(),
            'date_of_birth' => fake()->date(),
            'gender' => $genders[array_rand($genders)],
            'email' => fake()->unique()->email(),
            'password' => 'password',
            'is_active' => fake()->boolean(),
        ];
    }
}
