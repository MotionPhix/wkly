<?php

namespace App\Http\Controllers\Contacts;

use App\Data\ContactData;
use App\Http\Controllers\Controller;
use App\Models\Contact;
use Inertia\Inertia;

class Index extends Controller
{
  public function __invoke()
  {
    $contactsQuery = ContactData::collect(Contact::where('user_id', auth()->id())->with('emails', 'firm')->get());

    return Inertia::render('Contacts/Index', [
      'contacts' => $contactsQuery
    ]);
  }
}
