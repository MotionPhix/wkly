<?php

namespace App\Http\Controllers\Interactions;

use App\Data\InteractionData;
use App\Http\Controllers\Controller;
use App\Models\Interaction;

class Store extends Controller
{
  /**
   * Handle the incoming request.
   */
  public function __invoke(InteractionData $interactionData)
  {
    Interaction::create($interactionData->toArray());

    return back();
  }
}
