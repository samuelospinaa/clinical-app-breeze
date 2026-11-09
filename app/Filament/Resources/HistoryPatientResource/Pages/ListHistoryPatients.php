<?php

namespace App\Filament\Resources\HistoryPatientResource\Pages;

use App\Filament\Resources\HistoryPatientResource;
use App\Models\Patient;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListHistoryPatients extends ListRecords
{
   protected static string $resource = HistoryPatientResource::class;

   protected function getHeaderActions(): array
   {
      return [
         Actions\Action::make('Crear histórico')
            ->url(fn(): string => route('filament.admin.resources.history-patients.create', ['patient' => request()->patient])),
      ];
   }

   public function getBreadcrumbs(): array
   {
      $patientId = request()->patient;
      $patient = Patient::findOrFail($patientId);

      return ["/admin/patients/{$patientId}/edit" => $patient->name, '' => 'Histórico'];
   }

   protected function getTableQuery(): Builder
   {
      $patient = request()->patient;
      return parent::getTableQuery()->with('service')->where('patient_id', $patient);
   }
}
