<?php

namespace App\Traits;

use App\Models\Appointment;
use Carbon\Carbon;

trait AppointmentTrait
{
   protected function getAppointments(): array
   {
      $startOfWeek = Carbon::now()->startOfWeek();
      $endOfWeek = Carbon::now()->endOfWeek();

      return Appointment::select(
         \DB::raw('DAYOFWEEK(created_at) as day'),
         \DB::raw('COUNT(*) as count')
      )
         ->whereBetween('created_at', [$startOfWeek, $endOfWeek])
         ->groupBy('day')
         ->orderBy('day')
         ->pluck('count', 'day')
         ->toArray();
   }

   protected function getMoneyAppointments(): array
   {
      $startOfWeek = Carbon::now()->startOfWeek();
      $endOfWeek = Carbon::now()->endOfWeek();

      $dailyTotals = array_fill(0, 7, 0);

      $results = Appointment::select(
         \DB::raw('DAYOFWEEK(date) as day_of_week'),
         \DB::raw('SUM(price) as total_price')
      )
         ->whereBetween('date', [$startOfWeek, $endOfWeek])
         ->where('attended', 1)
         ->groupBy('day_of_week')
         ->orderBy('day_of_week')
         ->get();

      foreach ($results as $result) {
         $index = ($result->day_of_week == 1) ? 6 : $result->day_of_week - 1;
         $dailyTotals[$index] = $result->total_price;
      }

      return $dailyTotals;
   }

   protected function getAppointmentsByWeek(): array
   {
      $appointmentsByDay = $this->getAppointments();

      $weekDays = [];

      for ($day = 1; $day <= 7; $day++) {
         $weekDays[$day] = $appointmentsByDay[$day] ?? 0;
      }

      return $weekDays;
   }

   protected function convertStringToCurrency(string $stringValue): string
   {
      return '$' . number_format($stringValue, 0, ',', '.');
   }
}
