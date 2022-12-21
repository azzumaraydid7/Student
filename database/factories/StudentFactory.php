<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class StudentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'first_name' => fake()->name(),
            'last_name' => fake()->name(),
            'address' => fake()->address(),
            'student_registration_number' => fake()->ssn(),
            'contact_number' => fake()->phoneNumber(),
            'photo' => 'https://randomuser.me/api/portraits/men/'. rand(1, 10) .'.jpg'
        ];
    }
}
