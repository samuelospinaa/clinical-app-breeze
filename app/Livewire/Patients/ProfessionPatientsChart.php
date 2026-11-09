<?php

namespace App\Livewire\Patients;

use App\Models\Patient;
use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;

class ProfessionPatientsChart extends ApexChartWidget
{
   protected int | string | array $columnSpan = 'full';

   protected static ?string $chartId = 'professionPatientsChart';
   protected static ?string $heading = 'Profesión del paciente';

   protected function getOptions(): array
   {
      list($professions, $counts) = $this->getPatientData();

      return [
         'chart' => [
            'type' => 'bar',
            'height' => 300,
         ],
         'series' => [
            [
               'name' => 'Profesiones',
               'data' => $counts,
            ],
         ],
         'xaxis' => [
            'categories' => $professions,
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
      $dataCounts = Patient::with('professionPatient')
         ->selectRaw('select_options.name AS name, COUNT(*) AS count')
         ->join('select_options', "patients.profession", '=', 'select_options.id')
         ->groupBy('select_options.name')
         ->get();

      $professions = [];
      $counts = [];

      foreach ($dataCounts as $item) {
         $professions[] = $item->name;
         $counts[] = $item->count;
      }

      return [$professions, $counts];
   }
}
