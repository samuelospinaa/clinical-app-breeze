<?php

namespace App\Filament\Resources\AppointmentResource\Pages;

use App\Filament\Resources\AppointmentResource;
use App\Filament\Resources\AppointmentResource\Widgets\CalendarWidget;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Tables\Table;

class ListAppointments extends ListRecords
{
   protected static string $resource = AppointmentResource::class;

   protected function getHeaderActions(): array
   {
      return [
         //
      ];
   }

   protected function getHeaderWidgets(): array
   {
      return [
         CalendarWidget::class
      ];
   }
}
