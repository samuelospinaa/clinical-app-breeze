<?php

namespace App\Livewire\Patients;

use App\Models\Patient;
use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;

class OriginsPatientsChart extends ApexChartWidget
{
   protected static ?string $chartId = 'originsPatientsChart';
   protected static ?string $heading = 'Origen del paciente';

   protected function getOptions(): array
   {
      list($origins, $counts) = $this->getPatientData();

      return [
         'chart' => [
            'type' => 'bar',
            'height' => 300,
         ],
         'series' => [
            [
               'name' => 'Origenes',
               'data' => $counts,
            ],
         ],
         'xaxis' => [
            'categories' => $origins,
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
      $dataCounts = Patient::with('originPatient')
         ->selectRaw('select_options.name AS name, COUNT(*) AS count')
         ->join('select_options', "patients.origin", '=', 'select_options.id')
         ->groupBy('select_options.name')
         ->get();

      $origins = [];
      $counts = [];

      foreach ($dataCounts as $item) {
         $origins[] = $item->name;
         $counts[] = $item->count;
      }

      return [$origins, $counts];
   }
}
