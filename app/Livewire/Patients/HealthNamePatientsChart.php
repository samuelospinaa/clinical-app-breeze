<?php

namespace App\Livewire\Patients;

use App\Models\Patient;
use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;

class HealthNamePatientsChart extends ApexChartWidget
{
   protected static ?string $chartId = 'healthNamePatientsChart';
   protected static ?string $heading = 'Salud del paciente';

   protected function getOptions(): array
   {
      list($healthNames, $counts) = $this->getPatientData();

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
            'categories' => $healthNames,
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
      $dataCounts = Patient::with('healthName')
         ->selectRaw('select_options.name AS name, COUNT(*) AS count')
         ->join('select_options', "patients.health_name", '=', 'select_options.id')
         ->groupBy('select_options.name')
         ->get();

      $healthNames = [];
      $counts = [];

      foreach ($dataCounts as $item) {
         $healthNames[] = $item->name;
         $counts[] = $item->count;
      }

      return [$healthNames, $counts];
   }
}
