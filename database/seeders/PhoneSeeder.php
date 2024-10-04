<?php

namespace Database\Seeders;

use App\Models\Phone;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PhoneSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    Phone::factory(50)->create(fn () => [

      'phoneable_id' => \App\Models\Contact::all()->random()->id

    ]);
  }
}