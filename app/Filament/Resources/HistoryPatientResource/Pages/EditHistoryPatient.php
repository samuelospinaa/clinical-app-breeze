<?php

namespace App\Filament\Resources\HistoryPatientResource\Pages;

use App\Filament\Resources\HistoryPatientResource;
use App\Models\Patient;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditHistoryPatient extends EditRecord
{
   protected static string $resource = HistoryPatientResource::class;

   protected function getHeaderActions(): array
   {
      return [
         //Actions\DeleteAction::make()
      ];
   }

   public function getBreadcrumbs(): array
   {
      return [$this->previousUrl => "Histórico de pacientes", '' => 'Editar'];
   }
}
