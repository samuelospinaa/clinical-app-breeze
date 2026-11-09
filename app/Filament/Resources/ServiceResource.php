<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ServiceResource\Pages;
use App\Filament\Resources\ServiceResource\RelationManagers;
use App\Models\Service;
use App\Traits\StorageImages;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class ServiceResource extends Resource
{
   use StorageImages;

   protected static ?string $model = Service::class;
   protected static ?string $label = 'Servicio';
   protected static ?string $navigationIcon = 'heroicon-o-book-open';
   protected static ?string $navigationGroup = "Clínica";

   public static function form(Form $form): Form
   {
      return $form
         ->schema([
            Hidden::make('color')->default('#000'),

            FileUpload::make('image')
               ->optimize('webp')
               ->avatar()
               ->alignCenter()
               ->image()
               ->label('')
               ->disk('local')
               ->directory('public/patients')
               ->visibility('private')
               ->multiple(false)
               ->getUploadedFileNameForStorageUsing(
                  fn(TemporaryUploadedFile $file): string => self::parseNameByImage($form->getLivewire()->data['name']),
               ),

            Grid::make()
               ->columns(3)
               ->schema([
                  TextInput::make('name')->label('Nombre')->required(),
                  TextInput::make('duration')->label('Duración')->numeric()->required(),
                  TextInput::make('price')->label('Precio')->numeric()->required(),
               ]),

            RichEditor::make('description')->label('Descripción'),
         ])->columns(1);
   }

   public static function table(Table $table): Table
   {
      return $table
         ->columns([
            Tables\Columns\ImageColumn::make('image')->circular()->disk('local')->visibility('private'),
            Tables\Columns\TextColumn::make('name')->label('Nombre'),
            Tables\Columns\TextColumn::make('duration')->label('Duración')->numeric(),
            Tables\Columns\TextColumn::make('price')->label('Precio')->getStateUsing(function (Model $record) {
               return "$ " . number_format($record->price, 0, ',', '.');
            }),
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
         'index' => Pages\ListServices::route('/'),
         'create' => Pages\CreateService::route('/create'),
         'edit' => Pages\EditService::route('/{record}/edit'),
      ];
   }
}
