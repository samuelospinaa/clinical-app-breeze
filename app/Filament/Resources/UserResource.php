<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use App\Traits\StorageImages;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Phpsa\FilamentPasswordReveal\Password;

class UserResource extends Resource
{
   use StorageImages;

   protected static ?string $model = User::class;
   protected static ?string $navigationGroup = 'Administrativo';
   protected static ?string $navigationIcon = 'heroicon-o-user-group';
   protected static ?string $label = "Usuario";

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery()->with('roles');

        if (Auth::id() !== 1) {
            $query->where('id', '!=', 1);
        }

        return $query;
    }

   public static function form(Form $form): Form
   {
      return $form
         ->schema([
            FileUpload::make('image')
               ->optimize('webp')
               ->avatar()
               ->alignCenter()
               ->image()
               ->label('')
               ->disk('local')
               ->directory('public/users')
               ->visibility('private')
               ->multiple(false)
               ->getUploadedFileNameForStorageUsing(
                  fn(TemporaryUploadedFile $file): string => self::parseNameByImage($file, $form->getLivewire()->data['name']),
               ),

            Grid::make()
               ->columns(2)
               ->schema([
                  TextInput::make('name')
                     ->required(),
                  TextInput::make('email')
                     ->unique(ignoreRecord: true)
                     ->required(),
               ]),

            Grid::make()
               ->columns(2)
               ->schema([
                  Password::make('password')
                     ->revealable()
                     ->confirmed()
                     ->password()
                     ->requiredWith('password_confirmation')
                     ->required(fn() => $form->getOperation() === 'create'),

                  Password::make('password_confirmation')
                     ->revealable()
                     ->password()
                     ->requiredWith('password')
                     ->required(fn() => $form->getOperation() === 'create')
               ]),

            Select::make('roles')
               ->multiple()
               ->relationship('roles', 'name')->preload(),
         ])->columns(1);
   }

   public static function table(Table $table): Table
   {
      return $table
         ->columns([
            Tables\Columns\TextColumn::make('name'),
            Tables\Columns\TextColumn::make('roles.name')
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
         'index' => Pages\ListUsers::route('/'),
         'create' => Pages\CreateUser::route('/create'),
         'edit' => Pages\EditUser::route('/{record}/edit'),
      ];
   }
}
