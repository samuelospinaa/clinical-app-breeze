<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HistoryPatientResource\Pages;
use App\Filament\Resources\HistoryPatientResource\RelationManagers;
use App\Models\HistoryPatient;
use App\Models\Service;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Mohamedsabil83\FilamentFormsTinyeditor\Components\TinyEditor;

class HistoryPatientResource extends Resource
{
   protected static ?string $model = HistoryPatient::class;
   protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
   protected static bool $shouldRegisterNavigation = false;
   protected static ?string $label = "Histórico de paciente";

   public static function form(Form $form): Form
   {
      return $form->schema([
         Forms\Components\Hidden::make('patient_id')->default(request()->patient),

         Forms\Components\Select::make('service_id')
            ->label('Servicio')
            ->options(Service::all()->pluck('name', 'id')),

         Forms\Components\Select::make('type_consulting')
            ->required()
            ->label('Tipo de consulta')
            ->options([
               "Evolución Médica" => "Evolución Médica",
               "Procedimiento" => "Procedimiento",
               "Formula" => "Formula",
               "Otras Ordenes" => "Otras Ordenes",
            ]),

         TinyEditor::make('reason_consulting')
            ->label('Motivo de consulta')
            ->profile('withoutMultimedia')
            ->minHeight(300)
            ->columnSpanFull()
            ->required(),

         Forms\Components\Toggle::make('is_important')
            ->label('Es un evento importante?')
      ]);
   }

   public static function table(Table $table): Table
   {
      return $table->columns([
         Tables\Columns\TextColumn::make('service.name')
            ->label('Servicio'),

         Tables\Columns\TextColumn::make('type_consulting')
            ->label('Tipo de consulta'),

         Tables\Columns\TextColumn::make('is_important')
            ->label('Importancia del evento')
            ->badge()
            ->formatStateUsing(fn (string $state): string => $state === '1' ? 'Es importante' : 'Normal')
            ->color(fn (string $state): string => match($state) {
               '1' => 'success',
               default => 'info',
            }),
      ])->filters([

      ])->actions([
         Tables\Actions\EditAction::make()
      ])->bulkActions([
         //
      ]);
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
         'index' => Pages\ListHistoryPatients::route('/'),
         'create' => Pages\CreateHistoryPatient::route('/create'),
         'edit' => Pages\EditHistoryPatient::route('/{record}/edit'),
      ];
   }
}
