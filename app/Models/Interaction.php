<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Interaction extends Model
{
  use HasFactory;

  protected $fillable = [
    'description',
    'event_date',
    'location',
    'user_id',
    'contact_id',
    'interaction_type',
  ];

  protected $appends = ['display_event_date'];

  public function displayEventDate(): Attribute
  {
    return Attribute::make(
      get: fn () => Carbon::parse($this->event_date)->format('j M, Y')
    );
  }

  public function user(): BelongsTo {
    return $this->belongsTo(User::class);
  }

  public function contact() : BelongsTo {
    return $this->belongsTo(Contact::class);
  }
}
