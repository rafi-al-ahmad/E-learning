<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'email' =>'work.Dr'. $this->faker->unique()->safeEmail,
            'user_name' =>'Dr'. $this->faker->unique()->userName,
            'email_verified_at' => now(),
            'settings' => json_decode('[{
                "notifications": true
            }]'),

            'roles' => json_decode('[{
                "role_id": "anyId",
                "role_name": "Role-name",
                "permissions": ["access-dashboard"]
            }, {
                "role_id": "anyId",
                "role_name": "Role-name",
                "permissions": ["add-users", "brows-logs"]
            }]'),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
