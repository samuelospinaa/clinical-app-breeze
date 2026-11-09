<?php

namespace App\Filament\Widgets;

use App\Models\Appointment;
use App\Models\PaymentMethod;
use Carbon\Carbon;
use Filament\Actions\EditAction;
use Filament\Forms\Form;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Filament\Support\Colors\Color;
use Filament\Forms;

class LatestAppointments extends BaseWidget
{
   protected int|string|array $columnSpan = "full";
   protected static ?string $heading = 'Cita';

   public static function canView(): bool
   {
       return auth()->user()->checkPermissionTo('widget_LatestAppointments');
   }

    protected function getTableHeading(): string
   {
      return 'Citas de Hoy';
   }

   public function table(Table $table): Table
   {
      return $table
         ->query(
            Appointment::with('patient', 'professional', 'appointmentType')
               ->orderBy('start_time', 'ASC')
               ->whereDate('date', Carbon::today())
               ->orderByDesc('date')
         )
         ->columns([
            Tables\Columns\TextColumn::make('patient.name')->label('Paciente'),
            Tables\Columns\TextColumn::make('start_time')
               ->label('Hora de inicio')
               ->formatStateUsing(fn ($state) => substr($state, 0, -3)),
            Tables\Columns\TextColumn::make('appointmentType.name')->label('Tipo de cita'),
            Tables\Columns\TextColumn::make('professional.name')->label('Paciente'),
            Tables\Columns\TextColumn::make('price')->label('Valor de la cita')->numeric()->alignCenter()->prefix('$'),
            Tables\Columns\TextColumn::make('notes')
               ->label('Notas')
               ->formatStateUsing(fn ($state) => strip_tags($state))
               ->limit(20)
               ->tooltip(function (Tables\Columns\TextColumn $column): ?string {
                  $state = $column->getState();

                  if (strlen($state) <= $column->getCharacterLimit()) {
                     return null;
                  }

                  return strip_tags($state);
               }),
            Tables\Columns\IconColumn::make('attended')
               ->alignCenter()
               ->label('Asistió')
               ->boolean()
               ->action(function (Appointment $record) {
                  $record->update(["attended" => !$record->attended]);
                  $this->dispatch('updateAttended');
               }),
            Tables\Columns\TextColumn::make('paymentMethod.name')->label('Pago')
         ])
         ->actions([
            Tables\Actions\EditAction::make()
               ->modalWidth('sm')
               ->modalHeading('Actualizar cita')
               ->form([
                  Forms\Components\TextInput::make('price')
                     ->label('Precio')
                     ->numeric()
                     ->required()
                     ->maxLength(255),
                  Forms\Components\Select::make('payment_method_id')
                     ->required()
                     ->label('Tipo de pago')
                     ->options(PaymentMethod::all()->pluck('name', 'id'))
               ])
               ->action(function (array $data, Appointment $record) {
                  $record->update($data);
                  $this->dispatch('updateAttended');
               }),
         ])
         ->poll('60s')
         ->paginated(false)
         ->headerActions([
            Tables\Actions\Action::make('createAppointment')
               ->label('Crear Cita')
               ->color(Color::Gray)
               ->action(function () {
                  return redirect()->route('filament.admin.resources.appointments.index');
               })
         ]);
   }
}
