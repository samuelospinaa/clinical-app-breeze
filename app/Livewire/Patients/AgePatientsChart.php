<?php

namespace App\Livewire\Patients;

use App\Models\Patient;
use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;

class AgePatientsChart extends ApexChartWidget
{
   protected int | string | array $columnSpan = 'full';

   /**
    * Chart Id
    *
    * @var string
    */
   protected static ?string $chartId = 'agePatientsChart';

   /**
    * Widget Title
    *
    * @var string|null
    */
   protected static ?string $heading = 'Edad del paciente';

   /**
    * Chart options (series, labels, types, size, animations...)
    * https://apexcharts.com/docs/options
    *
    * @return array
    */
   protected function getOptions(): array
   {
      list($ages, $counts) = $this->getPatientData();

      return [
         'chart' => [
            'type' => 'bar',
            'height' => 300,
         ],
         'series' => [
            [
               'name' => 'Origen',
               'data' => $counts,
            ],
         ],
         'xaxis' => [
            'categories' => $ages,
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
      $agesCounts = Patient::selectRaw('YEAR(CURDATE()) - YEAR(birthday) AS age, COUNT(*) as count')
         ->groupBy('age')
         ->having('age', '>=', 0)
         ->orderBy('age')
         ->get();

      $ages = [];
      $counts = [];

      foreach ($agesCounts as $data) {
         $ages[] = $data->age;
         $counts[] = $data->count;
      }

      return [$ages, $counts];
   }
}
