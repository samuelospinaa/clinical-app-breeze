<?php

namespace App\Filament\Resources\PatientResource\Pages;

use App\Filament\Resources\PatientResource;
use App\Filament\Resources\PatientResource\Widgets\PatientDataWidget;
use App\Models\Patient;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Support\Colors\Color;

class EditPatient extends EditRecord
{
   protected static string $resource = PatientResource::class;

   protected function getHeaderActions(): array
   {
      $record = $this->getRecord();

      return [
         Actions\DeleteAction::make()->hidden(!auth()->user()->isSuperAdmin()),

         Actions\Action::make($record->clinicalHistory ? 'Historia clínica' : 'Crear Historia clínica')
            ->url(fn(Patient $record): string => $record->clinicalHistory
               ? route('filament.admin.resources.clinical-histories.view', $record->clinicalHistory->id)
               : route('filament.admin.resources.clinical-histories.create', ['patient' => $record->id])),

         Actions\Action::make('Histórico de paciente')
            ->color(Color::Gray)
            ->url(fn(Patient $record): string => route('filament.admin.resources.history-patients.index', ['patient' => $record->id])),

         Actions\Action::make('Citas del paciente')
            ->color(Color::Amber)
            ->url(fn(Patient $record): string => route('filament.admin.pages.reports-appointments', ['patient' => $record->id]))
      ];
   }

   protected function getHeaderWidgets(): array
   {
      return [
         PatientDataWidget::class
      ];
   }
}
