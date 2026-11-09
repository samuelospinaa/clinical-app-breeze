<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PackResource\Pages;
use App\Filament\Resources\PackResource\RelationManagers;
use App\Models\Pack;
use App\Models\Service;
use Closure;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class PackResource extends Resource
{
   protected static ?string $model = Pack::class;

   protected static ?string $navigationIcon = 'heroicon-o-archive-box';
   protected static ?string $label = "Paquete";
   protected static ?string $navigationGroup = "Clínica";

   public static function form(Form $form): Form
   {
      return $form
         ->schema([
            Forms\Components\TextInput::make('name')->label('Nombre')->required(),
            Forms\Components\RichEditor::make('description')->label('Descripción')->required()->columnSpanFull(),
            Forms\Components\Select::make('services')
               ->multiple()
               ->relationship('services')
               ->options(Service::all()->pluck('name', 'id'))
               ->label('Servicios')
               ->required(),
         ])->columns(1);
   }

   public static function table(Table $table): Table
   {
      return $table
         ->columns([
            Tables\Columns\TextColumn::make('name')->label('Nombre')
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
         'index' => Pages\ListPacks::route('/'),
         'create' => Pages\CreatePack::route('/create'),
         'edit' => Pages\EditPack::route('/{record}/edit'),
      ];
   }
}
