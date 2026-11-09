<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AppointmentResource\Pages;
use App\Filament\Resources\AppointmentResource\RelationManagers;
use App\Filament\Resources\AppointmentResource\Widgets\CalendarWidget;
use App\Models\Appointment;
use App\Policies\AppointmentPolicy;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Table;

class AppointmentResource extends Resource
{
   protected static ?string $model = Appointment::class;

   protected static ?string $navigationIcon = 'heroicon-o-calendar-days';
   protected static ?string $label = 'Cita';
   protected static ?string $navigationGroup = "Clínica";
   protected static bool $shouldCheckPolicyExistence = true;

   public static function getWidgets(): array
   {
      return [
         CalendarWidget::class,
      ];
   }

   public static function form(Form $form): Form
   {
      return $form
         ->schema([
            TextInput::make('date')
         ]);
   }

   public static function table(Table $table): Table
   {
      return $table
         ->paginated(false);
   }

   public static function getRelations(): array
   {
      return [
         //
      ];
   }

   public static function getPages(): array
   {
      return [
         'index' => Pages\ListAppointments::route('/'),
      ];
   }
}
