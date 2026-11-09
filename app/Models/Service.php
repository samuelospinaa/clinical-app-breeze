<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Service extends Model
{
   use HasFactory, SoftDeletes;

   protected $fillable = [
      "name",
      "description",
      "image",
      "duration",
      "price",
      "color",
   ];

   public function pack(): BelongsToMany
   {
      return $this->belongsToMany(Pack::class);
   }
}
