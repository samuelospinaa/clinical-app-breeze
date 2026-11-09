<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TestimonyResource\Pages;
use App\Filament\Resources\TestimonyResource\RelationManagers;
use App\Models\Testimony;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TestimonyResource extends Resource
{
   protected static ?string $model = Testimony::class;

   protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-right';
   protected static ?string $label = "Testimonio";
   protected static ?string $navigationGroup = "Marketing";

   public static function form(Form $form): Form
   {
      return $form
         ->schema([
            Forms\Components\TextInput::make('name')->required(),
            Forms\Components\TextInput::make('title')->required(),
            Forms\Components\TextInput::make('rating')->required()->numeric()->minValue(0)->maxValue(5)->default(0),
            Forms\Components\RichEditor::make('body')->required()->columnSpanFull()
         ])->columns(3);
   }

   public static function table(Table $table): Table
   {
      return $table
         ->columns([
            Tables\Columns\TextColumn::make('name'),
            Tables\Columns\TextColumn::make('title'),
            Tables\Columns\TextColumn::make('rating')->numeric(),
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
         'index' => Pages\ListTestimonies::route('/'),
         'create' => Pages\CreateTestimony::route('/create'),
         'edit' => Pages\EditTestimony::route('/{record}/edit'),
      ];
   }
}
