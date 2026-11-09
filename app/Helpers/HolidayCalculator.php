<?php

namespace App\Helpers;

use Carbon\Carbon;
use Carbon\CarbonInterface;

class HolidayCalculator
{
   const FORMAT_DATES = 'Y-m-d';

   public array $nonBusinessDays = [];
   public array $businessDays = [];
   public array $sundays = [];
   public array $holidays = [];

   protected array $fixedHolidays = [
      '01-01', // Año nuevo
      '05-01', // Día del trabajo
      '07-20', // Día de la independencia
      '08-07', // Batalla de Boyacá
      '12-08', // Inmaculada Concepción
      '12-25', // Navidad
   ];

   protected array $holidaysInMonday = [
      '01-06', // Reyes magos
      '03-19', // Día de San José
      '06-29', // Día de San Pedro y San Pablo
      '08-15', // Asunción de la Virgen
      '10-12', // Día de la Raza
      '11-01', // Día de todos los Santos
      '11-11', // Independencia de Cartagena
   ];

   public function __construct()
   {
      $this->iterateCalendar();
   }

   private function easterDay(int $year): Carbon
   {
      return Carbon::createFromTimestamp(easter_date($year));
   }

   private function datesAfterEaster(int $days, int $year): Carbon
   {
      $date = $this->easterDay($year)->addDays($days);

      while ($date->dayOfWeek !== CarbonInterface::MONDAY) {
         $date->addDay();
      }

      return $date;
   }

   private function easterWeekAndAfter(int $year): array
   {
      $easterDay = $this->easterDay($year);

      return [
         $easterDay->copy()->subDays(3)->format(self::FORMAT_DATES), // Jueves Santo
         $easterDay->copy()->subDays(2)->format(self::FORMAT_DATES), // Viernes Santo
         $this->datesAfterEaster(40, $year)->format(self::FORMAT_DATES), // Ascensión
         $this->datesAfterEaster(60, $year)->format(self::FORMAT_DATES), // Corpus Christi
         $this->datesAfterEaster(71, $year)->format(self::FORMAT_DATES), // Sagrado Corazón
      ];
   }

   private function holidaysToMonday(int $year): array
   {
      $holidaysToMonday = [];

      foreach ($this->holidaysInMonday as $holiday) {
         $date = Carbon::createFromFormat('m-d', $holiday)->year($year);

         if ($date->dayOfWeek !== CarbonInterface::MONDAY) {
            $date->next(CarbonInterface::MONDAY);
         }

         $holidaysToMonday[] = $date->format(self::FORMAT_DATES);
      }

      return $holidaysToMonday;
   }

   private function holidays(int $year): void
   {
      $this->holidays = array_merge(
         $this->easterWeekAndAfter($year),
         $this->holidaysToMonday($year),
         $this->getFixedHolidaysForYear($year)
      );
   }

   private function getFixedHolidaysForYear(int $year): array
   {
      $fixedHolidays = [];

      foreach ($this->fixedHolidays as $holiday) {
         $date = Carbon::createFromFormat('m-d', $holiday)->year($year);
         $fixedHolidays[] = $date->format(self::FORMAT_DATES);
      }

      return $fixedHolidays;
   }

   public function iterateCalendar(int $year = null): void
   {
      $year = $year ?? Carbon::now()->year;

      $initialDate = Carbon::create($year, 1, 1);
      $finalDate = Carbon::create($year, 12, 31);

      $nonBusinessDaysSet = collect();

      $this->holidays($year);

      while ($initialDate <= $finalDate) {
         $formattedDate = $initialDate->format(self::FORMAT_DATES);

         $isSunday = $initialDate->isSunday();
         $isHoliday = in_array($formattedDate, $this->holidays);

         if ($isSunday) {
            $this->sundays[] = $formattedDate;
            $nonBusinessDaysSet->add($formattedDate);
         }

         if ($isHoliday) {
            $nonBusinessDaysSet->add($formattedDate);
         }

         if (!$isSunday && !$isHoliday) {
            $this->businessDays[] = $formattedDate;
         }

         $initialDate->addDay();
      }

      $this->nonBusinessDays = $nonBusinessDaysSet->unique()->values()->all();
   }
}
