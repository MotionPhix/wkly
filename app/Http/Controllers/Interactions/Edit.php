<?php

namespace App\Http\Controllers\Interactions;

use App\Http\Controllers\Controller;
use App\Models\Interaction;
use Inertia\Inertia;

class Edit extends Controller
{
  /**
   * Handle the incoming request.
   */
  public function __invoke(Interaction $interaction)
  {
    return Inertia::render('Interactions/Form', [
      'interaction' => $interaction,
    ]);
  }
}
