<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Student>
 */
class StudentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $course = ['Computer Science', 'Data Science', 'Web Development', 'Machine Learning', 'Software Engineering'];

        return [
            'name' => $this->faker->name, 
            'email' => $this->faker->unique()->email, 
            'address' => $this->faker->address, 
            'study_course' => $this->faker->randomElement($course),
        ];
    }
}
