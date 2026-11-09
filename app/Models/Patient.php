<?php

namespace App\Models;

use App\Traits\PatientTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use phpDocumentor\Reflection\Types\This;

class Patient extends Model
{
   use HasFactory, SoftDeletes, PatientTrait;

   protected $fillable = [
      "name",
      "image",
      "document_type",
      "document_number",
      "birthday",
      "email",
      "phone",
      "cellular",
      "country",
      "department",
      "city",
      "address",
      "address_indications",
      "gender",
      "origin",
      "civil_status",
      "profession",
      "health_type",
      "health_name",
      "companion_name",
      "companion_phone",
      "companion_gender",
      "companion_relationship",
   ];

   public function document_type(): BelongsTo
   {
      return $this->belongsTo(SelectOption::class, 'document_type');
   }

   public function genderPatient(): BelongsTo
   {
      return $this->belongsTo(SelectOption::class, 'gender');
   }

   public function civilStatus(): BelongsTo
   {
      return $this->belongsTo(SelectOption::class, 'civil_status');
   }

   public function professionPatient(): BelongsTo
   {
      return $this->belongsTo(SelectOption::class, 'profession');
   }

   public function healthType(): BelongsTo
   {
      return $this->belongsTo(SelectOption::class, 'health_type');
   }

   public function healthName(): BelongsTo
   {
      return $this->belongsTo(SelectOption::class, 'health_name');
   }

   public function companion_gender(): BelongsTo
   {
      return $this->belongsTo(SelectOption::class, 'companion_gender');
   }

   public function companion_relationship(): BelongsTo
   {
      return $this->belongsTo(SelectOption::class, 'companion_relationship');
   }

   public function originPatient(): BelongsTo
   {
      return $this->belongsTo(SelectOption::class, 'origin');
   }

   public function clinicalHistory(): HasOne
   {
      return $this->hasOne(ClinicalHistory::class);
   }

   /**
    * Relación con las citas.
    */
   public function appointments(): HasMany
   {
      return $this->hasMany(Appointment::class);
   }

   /**
    * Obtener la última cita del paciente.
    */
   public function getLastAppointment()
   {
      return $this->appointments()->latest()->first();
   }

   /**
    * Obtener la última cita cumplida del paciente.
    */
   public function getLastAttendedAppointment()
   {
      return $this->appointments()->where('attended', 1)->latest()->first();
   }
}
