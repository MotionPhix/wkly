<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::middleware('auth')->group(function () {

  Route::prefix('interactions')->group(function () {

    Route::get(
      '/c/{contact:cid}',
      \App\Http\Controllers\Interactions\Create::class
    )->name('interaction.create');

    Route::get(
      '/e/{interaction}',
      \App\Http\Controllers\Interactions\Edit::class
    )->name('interaction.edit');

    Route::patch(
      '/u/{interaction}',
      \App\Http\Controllers\Interactions\Update::class
    )->name('interaction.update');

    Route::post(
      '/s/{contact}',
      \App\Http\Controllers\Interactions\Store::class
    )->name('interaction.store');

    Route::delete(
      'd/{interaction}',
      \App\Http\Controllers\Interactions\Destroy::class
    )->name('interaction.destroy');

  });

});

require __DIR__ . '/auth.php';
