<?php

namespace App\Data;

use Illuminate\Support\Collection;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;

/** @typescript * */
class FirmData extends Data
{
  public function __construct(
    public int|Optional              $id,

    public string|Optional           $fid,

    public string|Optional      $slogan,

    public AddressData|Optional $address,

    public string|Optional      $url,

    public string|Optional      $name,

    /** @var Collection<TagData> */
    public Collection|Optional  $tags,
  ) {}
}
