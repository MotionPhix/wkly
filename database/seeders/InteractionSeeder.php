<?php

namespace Database\Seeders;

use App\Models\Contact;
use App\Models\Interaction;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InteractionSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    Interaction::factory(10)->create(function () {
      return [
        'user_id' => User::all()->random()->id,
        'contact_id' => Contact::all()->random()->id,
      ];
    });
  }
}
