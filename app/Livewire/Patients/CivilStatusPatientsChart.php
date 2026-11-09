<?php

namespace App\Livewire\Patients;

use App\Models\Patient;
use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;

class CivilStatusPatientsChart extends ApexChartWidget
{
   protected static ?string $chartId = 'civilStatusPatientsChart';
   protected static ?string $heading = 'Estado civil del paciente';

   protected function getOptions(): array
   {
      list($civilStatus, $counts) = $this->getPatientData();

      return [
         'chart' => [
            'type' => 'bar',
            'height' => 300,
         ],
         'series' => [
            [
               'name' => 'Estado civil',
               'data' => $counts,
            ],
         ],
         'xaxis' => [
            'categories' => $civilStatus,
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
      $dataCounts = Patient::with('civilStatus')
         ->selectRaw('select_options.name AS name, COUNT(*) AS count')
         ->join('select_options', "patients.civil_status", '=', 'select_options.id')
         ->groupBy('select_options.name')
         ->get();

      $civilStatus = [];
      $counts = [];

      foreach ($dataCounts as $item) {
         $civilStatus[] = $item->name;
         $counts[] = $item->count;
      }

      return [$civilStatus, $counts];
   }
}
