<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Interaction>
 */
class InteractionFactory extends Factory
{
  /**
   * Define the model's default state.
   *
   * @return array<string, mixed>
   */
  public function definition(): array
  {
    return [
      'user_id' => \App\Models\User::factory(),
      'contact_id' => \App\Models\Contact::factory(),
      'description' => fake()->paragraph(),
      'interaction_type' => fake()->randomElement(['meeting', 'phone call', 'email', 'social media']),
      'event_date' => fake()->date(),
      'location' => fake()->city(),
    ];
  }
}
