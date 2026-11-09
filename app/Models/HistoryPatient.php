<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class HistoryPatient extends Model
{
   use HasFactory, SoftDeletes;

   protected $fillable = [
      "patient_id",
      "service_id",
      "type_consulting",
      "reason_consulting",
      "is_important",
   ];

   protected $with = ['service'];

   public function service(): BelongsTo
   {
      return $this->belongsTo(Service::class);
   }
}
