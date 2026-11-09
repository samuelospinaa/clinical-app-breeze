<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProfessionalResource\Pages;
use App\Filament\Resources\ProfessionalResource\RelationManagers;
use App\Models\Professional;
use App\Models\User;
use App\Traits\StorageImages;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Validation\Rules\Password;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Phpsa\FilamentPasswordReveal\Password as PasswordField;

class ProfessionalResource extends Resource
{
   use StorageImages;

   protected static ?string $model = Professional::class;
   protected static ?string $label = 'Profesional';
   protected static ?string $pluralLabel = 'Profesionales';
   protected static ?string $navigationIcon = 'heroicon-o-user-circle';
   protected static ?string $navigationGroup = "Clínica";

   public static function form(Form $form): Form
   {
      $operation = $form->getOperation();
      $credentials = null;

      if ($operation !== 'create') {
         $credentials = $form->model->credentials;
      }

      return $form
         ->schema([
            FileUpload::make('image')
               ->optimize('webp')
               ->avatar()
               ->alignCenter()
               ->image()
               ->label('')
               ->disk('local')
               ->directory('public/professionals')
               ->visibility('private')
               ->multiple(false)
               ->getUploadedFileNameForStorageUsing(
                  fn (TemporaryUploadedFile $file): string => self::parseNameByImage($form->getLivewire()->data['name']),
               ),

            Grid::make()
               ->columns(2)
               ->schema([
                  TextInput::make('name')->label('Nombre')->required(),
                  TextInput::make('identification')->numeric()->label('Documento')->required(),
               ]),

            Select::make('professional_type')
               ->required()
               ->options([
                  'médico' => 'Médic@',
                  'enfermero' => 'Enfermer@',
                  'cosmetólogo' => 'Cosmetólog@',
               ]),

            Select::make('user_id')
               ->hidden(fn() => $credentials)
               ->visible(fn() => auth()->user()->hasRole('admin') && $operation === 'edit')
               ->options(User::withoutProfessional()->pluck('name', 'id')),

            Fieldset::make('Credenciales')
               ->hidden(fn() => $operation === 'edit')
               ->schema([
                  TextInput::make('email')->required()->columnSpanFull(),

                  PasswordField::make('password')
                     ->minLength(6)
                     ->minValue(6)
                     ->revealable()
                     ->label(__('filament-panels::pages/auth/edit-profile.form.password.label'))
                     ->password()
                     ->rule(Password::default())
                     ->autocomplete('new-password')
                     ->dehydrated(fn ($state): bool => filled($state))
                     ->live()
                     ->same('passwordConfirmation'),

                  PasswordField::make('passwordConfirmation')
                     ->revealable()
                     ->label(__('filament-panels::pages/auth/edit-profile.form.password_confirmation.label'))
                     ->password()
                     ->required()
                     ->dehydrated(false)
               ])
               ->columns(2)
         ])->columns(1);
   }

   public static function table(Table $table): Table
   {
      return $table
         ->columns([
            Tables\Columns\ImageColumn::make('image')->circular()->disk('local')->visibility('private'),
            Tables\Columns\TextColumn::make('name')->label('Nombre'),
            Tables\Columns\TextColumn::make('identification')->label('Documento'),
            Tables\Columns\TextColumn::make('professional_type')->label('Tipo'),
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
            ])->hidden(!auth()->user()->isAdmin()),
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
         'index' => Pages\ListProfessionals::route('/'),
         'create' => Pages\CreateProfessional::route('/create'),
         'edit' => Pages\EditProfessional::route('/{record}/edit'),
      ];
   }
}
