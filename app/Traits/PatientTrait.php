<?php

namespace App\Traits;

use App\Models\Patient;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

trait PatientTrait
{
   public static function getCieXCodes(): array
   {
      $file = Storage::path('public/assets/CIEX.csv');
      $csv = array_map('str_getcsv', file($file));

      $header = array_shift($csv);

      $data = [];
      foreach ($csv as $row) {
         $data[] = array_combine($header, $row);
      }

      return $data;
   }

   public static function getCieXCodesByCategory(string | null $category): Collection
   {
      try {
         return collect(self::getCieXCodes())->where('Categoria', $category)->pluck('DescCiex', 'DescCiex');
      } catch (\Throwable $error) {
         return collect([]);
      }
   }

   public static function getCieXCategories(): Collection
   {
      try {
         return collect(self::getCieXCodes())->pluck('Categoria', 'Categoria')->unique();
      } catch (\Throwable $error) {
         return collect([]);
      }
   }

   public function getDataPatientsChart(): array
   {
      $currentYear = Carbon::now()->year;

      $patientsByMonths = Patient::select(
         \DB::raw('MONTH(created_at) as month'),
         \DB::raw('COUNT(*) as count')
      )
         ->whereYear('created_at', $currentYear)
         ->groupBy('month')
         ->orderBy('month')
         ->pluck('count', 'month')
         ->toArray();

      $data = [];

      for ($i = 1; $i <= 12; $i++) {
         $data[$i] = $patientsByMonths[$i] ?? 0;
      }

      return array_values($data);
   }

   protected function getPatientsByReport()
   {
      $startOfWeek = Carbon::now()->startOfWeek();
      $endOfWeek = Carbon::now()->endOfWeek();

      return Patient::select(
         \DB::raw('DAYOFWEEK(created_at) as day'),
         \DB::raw('COUNT(*) as count')
      )
         ->whereBetween('created_at', [$startOfWeek, $endOfWeek])
         ->groupBy('day')
         ->orderBy('day')
         ->pluck('count', 'day')
         ->toArray();
   }
   protected function getPatientsByWeek(): array
   {
      $appointmentsByDay = $this->getAppointments();

      $weekDays = [];

      for ($day = 1; $day <= 7; $day++) {
         $weekDays[$day] = $appointmentsByDay[$day] ?? 0;
      }

      return $weekDays;
   }
}
