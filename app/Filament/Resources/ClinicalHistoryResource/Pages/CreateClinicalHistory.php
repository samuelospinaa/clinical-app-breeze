<?php

namespace App\Filament\Resources\ClinicalHistoryResource\Pages;

use App\Filament\Resources\ClinicalHistoryResource;
use App\Models\HistoryPatient;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateClinicalHistory extends CreateRecord
{
   protected static string $resource = ClinicalHistoryResource::class;
   protected static bool $canCreateAnother = false;

   protected function getRedirectUrl(): string
   {
      return $this->previousUrl ?? $this->getResource()::getUrl('index');
   }

   protected function afterCreate(): void
   {
      $data = $this->data;
      $record = $this->record;

      HistoryPatient::create([
         "type_consulting" => "Primera Visita",
         "reason_consulting" => $data['reason'],
         "is_important" => 1,
         "patient_id" => $record->patient_id,
      ]);
   }
}
