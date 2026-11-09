<?php

namespace App\Filament\Widgets;

use App\Models\Appointment;
use App\Models\Patient;
use App\Traits\AppointmentTrait;
use App\Traits\PatientTrait;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class CreatedHomeCharts extends BaseWidget
{
   use AppointmentTrait;
   use PatientTrait;

   protected static array $patientsData = [];
   protected static array $appointmentsData = [];

   protected static ?string $pollingInterval = '60s';
   protected $listeners = ['updateAttended' => '$refresh'];

   public static function canView(): bool
   {
      return auth()->user()->checkPermissionTo('widget_CreatedHomeCharts');
   }

   public function __construct()
   {
      self::$appointmentsData = $this->getAppointmentsByWeek();
      self::$patientsData = $this->getPatientsByWeek();
   }

    protected function getCards(): array
    {
       $moneyAppointments = $this->getMoneyAppointments();

        return [
           BaseWidget\Card::make('AppointmentMoneyCount', $this->convertStringToCurrency(array_sum($moneyAppointments)))
              ->label('Valor de citas esta semana')
              ->description('Total recogido esta semana')
              ->descriptionIcon('heroicon-o-arrow-trending-up')
              ->descriptionColor('success')
              ->chart($moneyAppointments)
              ->chartColor('success'),

           BaseWidget\Card::make('AppointmentCount', array_sum($this->getAppointments()))
              ->label('Citas creadas esta semana')
              ->description('Total de citas creadas')
              ->descriptionIcon('heroicon-o-arrow-trending-up')
              ->descriptionColor('success')
              ->chart(self::$appointmentsData)
              ->chartColor('success'),

           BaseWidget\Card::make('PatientCount', array_sum($this->getPatientsByReport()))
              ->label('Pacientes creados esta semana')
              ->description('Total de pacientes creados')
              ->descriptionIcon('heroicon-o-arrow-trending-up')
              ->descriptionColor('success')
              ->chart(self::$patientsData)
              ->chartColor('success')
        ];
    }
}
