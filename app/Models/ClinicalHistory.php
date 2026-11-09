<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClinicalHistory extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
       "reason",
       "antecedents",
       "physicalExam",
       "recommendations",
       "diagnoses",
       "patient_id",
    ];

    public function patient(): BelongsTo
    {
       return $this->belongsTo(Patient::class);
    }
}
