<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Interaction extends Model
{
  use HasFactory;

  public function user(): BelongsTo {
    return $this->belongsTo(User::class);
  }

  public function contact() : BelongsTo {
    return $this->belongsTo(Contact::class);
  }
}
