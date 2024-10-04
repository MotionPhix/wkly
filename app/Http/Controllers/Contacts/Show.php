<?php

namespace App\Http\Controllers\Contacts;

use App\Data\ContactFullData;
use App\Http\Controllers\Controller;
use App\Models\Contact;
use Inertia\Inertia;

class Show extends Controller
{
  public function __invoke(Contact $contact)
  {
    $contactsQuery = ContactFullData::from($contact->load('phones', 'emails', 'firm.tags:id,name', 'firm.address', 'interactions'));
    //     ->when($contact->firm, function ($query) {
    //         // Eager load the address relationship if the firm is loaded
    //         return $query->with(['firm.address']);
    //     })
    // );;

    return Inertia::render('Contacts/Show', [
      'contact' => $contactsQuery,
    ]);
  }
}
