<?php

namespace App\Http\Controllers\Interactions;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Inertia\Inertia;

class Create extends Controller
{
  /**
   * Handle the incoming request.
   */
  public function __invoke(Contact $contact)
  {
    return Inertia::render('Interactions/Form', [
      'contact_id' => $contact->id,
      'user_id' => auth()->id()
    ]);
  }
}
