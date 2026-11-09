<?php

namespace App\Filament\Resources\ClinicalHistoryResource\Pages;

use App\Filament\Resources\ClinicalHistoryResource;
use App\Models\Patient;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewClinicalHistory extends ViewRecord
{
   public function getBreadcrumbs(): array
   {
      $idRecord = $this->data['id'];
      $patient = Patient::findOrFail($this->data['patient_id']);

      return ["/admin/patients/{$idRecord}/edit" => $patient->name, '' => 'Editar historia clínica'];
   }

   protected static string $resource = ClinicalHistoryResource::class;
}
