<?php

namespace App\Livewire\Patients;

use App\Models\Patient;
use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;

class HealthTypePatientsChart extends ApexChartWidget
{
   protected static ?string $chartId = 'healthTypePatientsChart';
   protected static ?string $heading = 'Tipo de salud del paciente';

   protected function getOptions(): array
   {
      list($healthTypes, $counts) = $this->getPatientData();

      return [
         'chart' => [
            'type' => 'bar',
            'height' => 300,
         ],
         'series' => [
            [
               'name' => 'Tipos de salud',
               'data' => $counts,
            ],
         ],
         'xaxis' => [
            'categories' => $healthTypes,
            'labels' => [
               'style' => [
                  'fontFamily' => 'inherit',
                  'fontWeight' => 600,
               ],
            ],
         ],
         'yaxis' => [
            'labels' => [
               'style' => [
                  'fontFamily' => 'inherit',
               ],
            ],
         ],
         'colors' => ['#1797b6'],
      ];
   }

   private function getPatientData(): array
   {
      $dataCounts = Patient::with('healthType')
         ->selectRaw('select_options.name AS name, COUNT(*) AS count')
         ->join('select_options', "patients.health_type", '=', 'select_options.id')
         ->groupBy('select_options.name')
         ->get();

      $healthTypes = [];
      $counts = [];

      foreach ($dataCounts as $item) {
         $healthTypes[] = $item->name;
         $counts[] = $item->count;
      }

      return [$healthTypes, $counts];
   }
}
