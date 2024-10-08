<?php

namespace App\Http\Controllers\Interactions;

use App\Http\Controllers\Controller;
use App\Models\Interaction;

class Destroy extends Controller
{
  /**
   * Handle the incoming request.
   */
  public function __invoke(Interaction $interaction)
  {
    $interaction->delete();

    return back();
  }
}
