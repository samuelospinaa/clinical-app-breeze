<?php

namespace App\Livewire\Patients;

use App\Models\Patient;
use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;

class GenderPatientsChart extends ApexChartWidget
{
   protected static ?string $chartId = 'genderPatientsChart';
   protected static ?string $heading = 'Sexo del paciente';

   protected function getOptions(): array
   {
      list($genders, $counts) = $this->getPatientData();

      return [
         'chart' => [
            'type' => 'bar',
            'height' => 300,
         ],
         'series' => [
            [
               'name' => 'Generos',
               'data' => $counts,
            ],
         ],
         'xaxis' => [
            'categories' => $genders,
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
      $dataCounts = Patient::with('genderPatient')
         ->selectRaw('select_options.name AS name, COUNT(*) AS count')
         ->join('select_options', "patients.gender", '=', 'select_options.id')
         ->groupBy('select_options.name')
         ->get();

      $genders = [];
      $counts = [];

      foreach ($dataCounts as $item) {
         $genders[] = $item->name;
         $counts[] = $item->count;
      }

      return [$genders, $counts];
   }
}
