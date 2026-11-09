<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BannerResource\Pages;
use App\Filament\Resources\BannerResource\RelationManagers;
use App\Models\Banner;
use App\Traits\StorageImages;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use FilamentTiptapEditor\Enums\TiptapOutput;
use FilamentTiptapEditor\TiptapEditor;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Mohamedsabil83\FilamentFormsTinyeditor\Components\TinyEditor;

class BannerResource extends Resource
{
   use StorageImages;

   protected static ?string $model = Banner::class;

   protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
   protected static ?string $navigationGroup = 'Marketing';

   public static function form(Form $form): Form
   {
      return $form
         ->schema([
            FileUpload::make('image')
               ->optimize('webp')
               ->required()
               ->image()
               ->label('Imagen del banner')
               ->disk('local')
               ->directory('public/banners')
               ->visibility('private')
               ->multiple(false)
               ->getUploadedFileNameForStorageUsing(
                  fn(TemporaryUploadedFile $file): string => self::parseNameByImage($form->getLivewire()->data['title'] ?? ""),
               ),

            TextInput::make('title')->label('Titulo'),

            Fieldset::make('Botón del banner')
               ->schema([
                  TextInput::make('linkButton.text')->label('Texto del botón'),
                  TextInput::make('linkButton.url')->label('URL del botón'),
               ])->columns(2),

            TinyEditor::make('content')
               ->label('Texto del banner')
               ->profile('withoutMultimedia')
               ->minHeight(300)
               ->required()
         ])->columns(1);
   }

   public static function table(Table $table): Table
   {
      return $table
         ->reorderable('order')
         ->defaultSort('order')
         ->columns([
            ImageColumn::make('image')->label('Imagen')
               ->disk('local')->extraImgAttributes(['loading' => 'lazy'])->width(100),

            TextColumn::make('order')->label('Orden')->numeric(),
            TextColumn::make('title')->label('Titulo'),

            IconColumn::make('visible')
               ->boolean()
               ->action(fn(Banner $record) => $record->update(["visible" => !$record->visible])),
         ])
         ->filters([
            //
         ])
         ->actions([
            Tables\Actions\EditAction::make(),
            Tables\Actions\DeleteAction::make(),
         ])
         ->bulkActions([
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
         'index' => Pages\ListBanners::route('/'),
         'create' => Pages\CreateBanner::route('/create'),
         'edit' => Pages\EditBanner::route('/{record}/edit'),
      ];
   }
}
