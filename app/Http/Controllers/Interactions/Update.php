<?php

namespace App\Http\Controllers\Interactions;

use App\Data\InteractionData;
use App\Http\Controllers\Controller;
use App\Models\Interaction;

class Update extends Controller
{
  /**
   * Handle the incoming request.
   */
  public function __invoke(
    InteractionData $interactionData,
    Interaction $interaction
  )
  {
    $validated = $interactionData->toArray();

    $interaction->update($validated);

    return back();
  }
}
