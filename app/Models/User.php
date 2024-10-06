<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
  use HasFactory, Notifiable, HasApiTokens;

  /**
   * The attributes that are mass assignable.
   *
   * @var array<int, string>
   */
  protected $fillable = [
    'first_name',
    'last_name',
    'role',
    'email',
    'password',
  ];

  /**
   * The attributes that should be hidden for serialization.
   *
   * @var array<int, string>
   */
  protected $hidden = [
    'password',
    'remember_token',
  ];

  /**
   * Get the attributes that should be cast.
   *
   * @return array<string, string>
   */
  protected function casts(): array
  {
    return [
      'email_verified_at' => 'datetime',
      'password' => 'hashed',
    ];
  }

  public function name(): Attribute
  {
    return Attribute::make(
      get: fn() => "{$this->first_name} {$this->last_name}",
    )->shouldCache();
  }

  public function avatar(): MorphOne
  {
    return $this->morphOne(File::class, 'model');
  }

  public function comments(): HasMany
  {
    return $this->hasMany(Comment::class);
  }

  public function replies(): HasMany
  {
    return $this->hasMany(Reply::class);
  }

  public function interactions() : HasMany {
    return $this->hasMany(Interaction::class)->chaperone('interactions');
  }

  public function projects() : HasMany {
    return $this->hasMany(Project::class)->chaperone('projects');
  }

  public function avatarUrl(): Attribute
  {
    return Attribute::make(
      get: fn() => $this->avatar?->full_url ?? 'https://www.gravatar.com/avatar/' . md5(strtolower(trim($this->email)))
    );
  }

  protected static function boot()
  {
    parent::boot();

    static::created(function ($user) {

      if (static::count() === 1) {

        $user->role = 'admin';

        $user->save();

      }

    });

  }
}
