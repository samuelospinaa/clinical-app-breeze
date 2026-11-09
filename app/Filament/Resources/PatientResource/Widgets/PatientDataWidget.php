<?php

namespace App\Filament\Resources\PatientResource\Widgets;

use Carbon\Carbon;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Database\Eloquent\Model;

class PatientDataWidget extends BaseWidget
{
   public ?Model $record = null;

   protected function getStats(): array
   {
      $dateCreated = (new \DateTime($this->record->created_at))->format('Y-m-d');

      $getLastAppointment = $this->record->getLastAppointment();
      $lastAppointment = $getLastAppointment
         ? (new \DateTime($getLastAppointment->date))->format('Y-m-d')
         : 'N/A';

      $getLastAttendedAppointment = $this->record->getLastAttendedAppointment();
      $lastAttendedAppointment = $getLastAttendedAppointment
         ? (new \DateTime($getLastAttendedAppointment->date))->format('Y-m-d')
         : 'N/A';

      return [
         Stat::make('Feacha de creación', $this->parseDate($dateCreated)),
         Stat::make('Ultima cita registrada', $this->parseDate($lastAppointment)),
         Stat::make('Ultima visita', $this->parseDate($lastAttendedAppointment)),
      ];
   }

   private function parseDate($dateString): string
   {
      if ($dateString === 'N/A') return $dateString;
      $date = Carbon::createFromFormat('Y-m-d', $dateString);
      return $date->format('M d, Y');
   }
}
