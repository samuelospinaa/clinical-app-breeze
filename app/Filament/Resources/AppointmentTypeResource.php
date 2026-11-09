<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AppointmentTypeResource\Pages;
use App\Filament\Resources\AppointmentTypeResource\RelationManagers;
use App\Models\AppointmentType;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AppointmentTypeResource extends Resource
{
   protected static ?string $model = AppointmentType::class;

   protected static ?string $navigationIcon = 'heroicon-o-list-bullet';
   protected static ?string $label = "Tipo de cita";
   protected static ?string $pluralLabel = "Tipo de citas";
   protected static ?string $navigationGroup = "Clínica";

   public static function form(Form $form): Form
   {
      return $form
         ->schema([
            Forms\Components\TextInput::make('name'),
            Forms\Components\ColorPicker::make('color'),
         ]);
   }

   public static function table(Table $table): Table
   {
      return $table
         ->columns([
            Tables\Columns\TextColumn::make('name'),
            Tables\Columns\ColorColumn::make('color'),
         ])
         ->filters([
            //
         ])
         ->actions([
            Tables\Actions\EditAction::make(),
         ])
         ->bulkActions([
            Tables\Actions\BulkActionGroup::make([
               Tables\Actions\DeleteBulkAction::make(),
            ]),
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
         'index' => Pages\ListAppointmentTypes::route('/'),
         'create' => Pages\CreateAppointmentType::route('/create'),
         'edit' => Pages\EditAppointmentType::route('/{record}/edit'),
      ];
   }
}
