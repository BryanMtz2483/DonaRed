<?php

namespace Database\Factories;

use App\Models\Donation;
use App\Models\DonationRequest;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DonationRequest>
 */
class DonationRequestFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'donation_id' => Donation::inRandomOrder()->first()->id ?? Donation::factory(),
            'user_id' => User::inRandomOrder()->first()->id ?? User::factory(),
            'estado' => $this->faker->randomElement(['pendiente', 'aceptada', 'rechazada']),
        ];
    }
}
