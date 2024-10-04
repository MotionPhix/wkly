<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
  /**
   * Seed the application's database.
   */
  public function run(): void
  {

    User::factory()->create([
      'email' => 'hello@ultrashots.net',
      'first_name' => 'Kingsley',
      'last_name' => 'Nyirenda',
      'role' => 'manager',
    ]);

    User::factory(3)->create();

    $this->call([
      FirmSeeder::class,
      ContactSeeder::class,
      ProjectSeeder::class,
      BoardSeeder::class,
      TaskSeeder::class,
      PhoneSeeder::class,
      EmailSeeder::class,
      InteractionSeeder::class,
    ]);
  }
}
