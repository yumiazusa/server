<?php
namespace Modules\Students\Database\factories;

use Modules\Students\Entities\Students;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class StudentsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Students::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'phone' =>$this->faker->phoneNumber,
            'email' => $this->faker->unique()->safeEmail,
            'stdid' =>$this->faker->unique()->numberBetween($min = 2000000, $max = 3000000),
            'status' => rand(0, 1),
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        ];
    }
}

