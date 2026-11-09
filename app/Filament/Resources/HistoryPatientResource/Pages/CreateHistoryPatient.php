<?php

namespace App\Filament\Resources\HistoryPatientResource\Pages;

use App\Filament\Resources\HistoryPatientResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateHistoryPatient extends CreateRecord
{
    protected static string $resource = HistoryPatientResource::class;

   protected function getRedirectUrl(): string
   {
      return route('filament.admin.resources.history-patients.index', ['patient' => $this->record->patient_id]);
   }
}
