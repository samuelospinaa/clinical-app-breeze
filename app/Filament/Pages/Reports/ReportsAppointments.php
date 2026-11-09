<?php

namespace App\Filament\Pages\Reports;

use App\Models\Appointment;
use App\Models\PaymentMethod;
use App\Models\Professional;
use Filament\Actions\Action;
use Filament\Forms\Components;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Pages\Page;
use Filament\Support\Enums\IconPosition;
use Filament\Tables\Columns;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ReportsAppointments extends Page implements HasTable, HasForms
{
   public string $startDate;
   public string $endDate;
   public int $paymentType = 0;
   public int $professional = 0;

   use InteractsWithTable, InteractsWithForms;

   protected static ?string $navigationIcon = "heroicon-o-document-text";
   protected static string $view = "filament.pages.reports-appointments";
   protected static ?string $navigationGroup = "Reportes";
   protected static ?string $navigationLabel = "Citas por días";
   protected static ?string $title = "Citas por días";

   protected $listeners = ['refreshTable'];

   public function __construct()
   {
      if (request()->patient) {
         self::$title = 'Citas';
      }
   }

   public function mount(): void
   {
      $this->startDate = now()->startOfMonth()->format('Y-m-d');
      $this->endDate = now()->endOfMonth()->format('Y-m-d');
   }

   private function getQuery()
   {
      $query = Appointment::query()->orderByDesc('date');
      $patient = request()->patient;

      if ($patient) {
         $query->where('patient_id', $patient);
      }

      if (!$patient) {
         $query->whereBetween('date', [$this->startDate, $this->endDate]);
      }

      if ($this->paymentType != 0) {
         $query->where('payment_method_id', $this->paymentType);
      }

      if ($this->professional != 0) {
         $query->where('professional_id', $this->professional);
      }

      return $query;
   }

   protected function getFormActions(): array
   {
      return [
         Action::make('consult')
            ->label('Consultar')
            ->action('consultAppointments')
            ->color('primary')
            ->icon('heroicon-o-paper-airplane')
            ->iconPosition(IconPosition::After)
            ->extraAttributes(['onclick' => 'showLoading()']),
      ];
   }

   public function consultAppointments(): void
   {
      $this->startDate = $this->form->getState()['startDate'];
      $this->endDate = $this->form->getState()['endDate'];
      $this->paymentType = $this->form->getState()['paymentType'] ?? 0;
      $this->professional = $this->form->getState()['professional'] ?? 0;

      $this->dispatch('refreshTable');
   }

   public function table(Table $table): Table
   {
      return $table
         ->query($this->getQuery())
         ->columns([
            Columns\TextColumn::make('patient.name')->label('Paciente'),
            Columns\TextColumn::make('date')->label('Fecha de cita')->date()->sortable(),
            Columns\TextColumn::make('created_at')->label('Fecha de creación')->date()->sortable(),
            Columns\TextColumn::make('professional.name')->label('Profesional'),
            Columns\IconColumn::make('attended')
               ->sortable()
               ->alignCenter()
               ->label('Asistió')
               ->boolean(),
            Columns\TextColumn::make('price')
               ->label('Precio')
               ->formatStateUsing(fn ($state) => $this->parsePrices($state)),
            Columns\TextColumn::make('paymentMethod.name')->label('Pago')
         ])->paginated(false);
   }

   public function form(Form $form): Form
   {
      return $form
         ->schema([
            Components\DatePicker::make('startDate')->label('Desde'),
            Components\DatePicker::make('endDate')->label('Hasta'),
            Components\Select::make('paymentType')
               ->label('Tipo de pago')
               ->selectablePlaceholder(false)
               ->options(PaymentMethod::pluck('name', 'id')->prepend('Todos', 0)->all()),
            Components\Select::make('professional')
               ->label('Profesional')
               ->selectablePlaceholder(false)
               ->options(Professional::pluck('name', 'id')->prepend('Todos', 0)->all())
         ])
         ->columns(2);
   }

   private function parsePrices(float | null $price): string
   {
      if (!$price) return '$0';
      return "$" . number_format($price, 0, ',', '.');
   }

   protected function getCards(): array
   {
      $appointmentStats = $this
         ->getQuery()->get();

      $notAttendedAppointments = $appointmentStats->where('attended', 0);
      $attendedAppointments = $appointmentStats->where('attended', 1);

      return [
         Stat::make('Total Citas', $appointmentStats->count())
            ->color('primary')
            ->description('Total de citas'),

         Stat::make("Citas Atendidas: {$attendedAppointments->count()}", $this->parsePrices($attendedAppointments->sum('price')))
            ->color('success')
            ->description('Citas atendidas'),

         Stat::make("Citas No Atendidas: {$notAttendedAppointments->count()}", $this->parsePrices($notAttendedAppointments->sum('price')))
            ->color('danger')
            ->description('Citas no atendidas'),
      ];
   }
}
