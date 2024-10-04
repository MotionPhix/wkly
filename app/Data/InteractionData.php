<?php

namespace App\Data;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;

/**
 * @typescript
 */
class InteractionData extends Data
{
  public function __construct(
    public int|Optional $id,
    public int $user_id,
    public int $contact_id,
    public Optional|string $description,
    public Optional|ContactData $contact,
    public string $interaction_type,
    public string $event_date,
    public string $location
  ) {}
}
