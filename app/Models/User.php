<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Model
{
  use HasFactory;

  protected $fillable = [
    'username',
    'phone_number',
    'unique_link',
    'link_expires_at',
  ];

  protected $casts = [
    'link_expires_at' => 'datetime',
  ];

  public function games(): HasMany
  {
    return $this->hasMany(Game::class);
  }
}
