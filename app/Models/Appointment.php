<?php

namespace App\Models;

use App\Casts\CleanHtml;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Appointment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
       "price",
       "service_id",
       "date",
       "start_time",
       "end_time",
       "appointment_type_id",
       "patient_id",
       "professional_id",
       "notes",
       "attended",
       "payment_method_id",
    ];

    protected $casts = [
       "notes" => CleanHtml::class
    ];

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

    public function professional(): BelongsTo
    {
        return $this->belongsTo(Professional::class);
    }

    public function appointmentType(): BelongsTo
    {
        return $this->belongsTo(AppointmentType::class);
    }

    public function paymentMethod(): BelongsTo
    {
        return $this->belongsTo(PaymentMethod::class);
    }

   public function attendedAppointments()
   {
      return $this->where('attended', true);
   }

   // Relationship for not attended appointments
   public function notAttendedAppointments()
   {
      return $this->where('attended', false);
   }
}
