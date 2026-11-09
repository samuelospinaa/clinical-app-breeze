<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Professional extends Model
{
   use HasFactory, SoftDeletes;

   protected $fillable = [
      "name",
      "image",
      "identification",
      "professional_type",
      "user_id",
   ];

   protected static function boot()
   {
      parent::boot();

      static::deleting(function ($model) {
         if($model->credentials) {
            $model->credentials->update([
               "deleted_at" => new \DateTime()
            ]);
         }
      });
   }

   public function credentials(): BelongsTo
   {
      return $this->belongsTo(User::class, 'user_id');
   }
}
