<?php

namespace App\Livewire\Patients;

use App\Models\Patient;
use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;

class CityPatientsChart extends ApexChartWidget
{
   protected int | string | array $columnSpan = 'full';

   protected static ?string $chartId = 'cityPatientsChart';
   protected static ?string $heading = 'Ciudades';

   protected function getOptions(): array
   {
      list($cities, $counts) = $this->getPatientData();

      return [
         'chart' => [
            'type' => 'bar',
            'height' => 300,
         ],
         'series' => [
            [
               'name' => 'Ciudades',
               'data' => $counts,
            ],
         ],
         'xaxis' => [
            'categories' => $cities,
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
      $dataCounts = Patient::selectRaw('COALESCE(city, "Sin asignar") AS name, COUNT(*) AS count')
         ->groupBy('city')
         ->get();

      $cities = [];
      $counts = [];

      foreach ($dataCounts as $item) {
         $cities[] = $item->name;
         $counts[] = $item->count;
      }

      return [$cities, $counts];
   }
}
