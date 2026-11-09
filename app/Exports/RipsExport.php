<?php

namespace App\Exports;

use App\Models\Appointment;
use App\Models\ClinicalHistory;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class RipsExport implements FromCollection, WithHeadings, WithMapping, WithColumnFormatting
{
   public function __construct(protected $month, protected $year)
   {
      //
   }

   /**
    * @return \Illuminate\Support\Collection
    */
   public function collection()
   {
      $appointments = Appointment::with('patient.document_type', 'appointmentType')
         ->whereIn('appointment_type_id', [2,4,5])
         ->whereMonth('date', $this->month)
         ->whereYear('date', $this->year)
         ->get();

      $clinicalHistories = ClinicalHistory::with('patient.document_type')
         ->whereMonth('created_at', $this->month)
         ->whereYear('created_at', $this->year)
         ->get();

      return $appointments->merge($clinicalHistories);
   }

   /**
    * @param $row
    * @return array
    * @throws Exception
    */
   public function map($row): array
   {
      $splitFullName = $this->splitFullName($row->patient->name);

      return [
         '',
         '1082861558',
         $row->patient->document_type()->get()->first()?->name,
         $row->patient->document_number,
         'Cotizante',
         $splitFullName['names'],
         $splitFullName['lastnames'],
         $this->getAgeByDateOfBirth($row->patient->birthday),
         $row->patient->genderPatient?->name,
         $row->patient->city,
         'urbano',
         (new \DateTime($row->date ?? $row->created_at))->format('Y-m-d'),
         $row->getTable() === 'appointments' ? $row->appointmentType->name : strip_tags($row->reason),
         'Enfermedad General',
         '',
         'R238',
         'R238',
         'Procedimiento',
         $row->getTable() === 'appointments' ? $row->appointmentType->name : strip_tags($row->reason),
         'No aplica',
         'No aplica',
         'No aplica',
         'No aplica',
         'No aplica',
      ];
   }

   public function columnFormats(): array
   {
      return [
         //'E' => NumberFormat::FORMAT_CURRENCY_USD,
         //'F' => NumberFormat::FORMAT_CURRENCY_USD,
         //'G' => NumberFormat::FORMAT_CURRENCY_USD,
      ];
   }

   public function headings(): array
   {
      return [
         'Código de habilitación',
         'Nit de la ips o cédula del Dr.',
         'Tipo documento del usuario',
         'Número de Documento del usuario',
         'Regimen (Subsidiado - Contributivo)',
         'Nombres del usuario',
         'Apellidos del usuario',
         'Edad del usuario',
         'Sexo del usuario',
         'Municipio donde vive',
         'Urbano - Rural',
         'Fecha de consulta o procedimiento',
         'Finalidad',
         'Causa Externa',
         'Tipo Diagnostico',
         'Diagnóstico principal CIE 10',
         'Diagnóstico relacionado si tiene CIE 10',
         'Tipo de atencion (Consulta o Procedimiento)',
         'Descripción de la atención',
         'Numero de Autoriazción',
         'Codigo Cups Procedimiento',
         'Valor de la consulta o procedimiento',
         'Cuota Moderadora',
         'Número de factura o de Recibo si tiene',
      ];
   }

   private function getAgeByDateOfBirth(string | null $dateOfBirth): int
   {
      if (!$dateOfBirth) return 0;

      $date = Carbon::createFromFormat('Y-m-d', $dateOfBirth);
      return $date->age;
   }

   private function splitFullName($fullName)
   {
      $nameParts = Str::of($fullName)->trim()->explode(' ');

      $count = $nameParts->count();
      $names = '';
      $lastNames = '';

      if ($count === 2) {
         $names = $nameParts[0];
         $lastNames = $nameParts[1];
      } elseif ($count === 3) {
         $names = $nameParts[0];
         $lastNames = $nameParts->slice(1)->implode(' ');
      } elseif ($count === 4) {
         $names = $nameParts->take(2)->implode(' ');
         $lastNames = $nameParts->slice(2)->implode(' ');
      }

      return [
         'names' => $names,
         'lastnames' => $lastNames
      ];
   }
}
