<?php

namespace App\Livewire\Patients;

use App\Models\Patient;
use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;

class DepartmentsPatientsChart extends ApexChartWidget
{
   protected static ?string $chartId = 'departmentsPatientsChart';
   protected static ?string $heading = 'Departamentos';

   protected function getOptions(): array
   {
      list($departments, $counts) = $this->getPatientData();

      return [
         'chart' => [
            'type' => 'bar',
            'height' => 300,
         ],
         'series' => [
            [
               'name' => 'Departamentos',
               'data' => $counts,
            ],
         ],
         'xaxis' => [
            'categories' => $departments,
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
      $dataCounts = Patient::selectRaw('COALESCE(department, "Sin asignar") AS name, COUNT(*) AS count')
         ->groupBy('department')
         ->get();

      $departments = [];
      $counts = [];

      foreach ($dataCounts as $item) {
         $departments[] = $item->name;
         $counts[] = $item->count;
      }

      return [$departments, $counts];
   }
}
