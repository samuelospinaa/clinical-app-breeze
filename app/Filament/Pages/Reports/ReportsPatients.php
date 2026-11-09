<?php

namespace App\Filament\Pages\Reports;


use App\Livewire\Patients;
use Filament\Pages\Page;

class ReportsPatients extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.reports-patients';
    protected static ?string $navigationLabel = 'Pacientes';
    protected static ?string $title = 'Reporte de pacientes';
    protected static ?string $navigationGroup = 'Reportes';

    protected function getHeaderWidgets(): array
    {
       return [
          Patients\CivilStatusPatientsChart::class,
          Patients\DepartmentsPatientsChart::class,
          Patients\GenderPatientsChart::class,
          Patients\HealthNamePatientsChart::class,
          Patients\HealthTypePatientsChart::class,
          Patients\OriginsPatientsChart::class,
          Patients\AgePatientsChart::class,
          Patients\CityPatientsChart::class,
          Patients\ProfessionPatientsChart::class,
       ];
    }
}
