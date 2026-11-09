<?php

namespace App\Filament\Resources;

use App\Filament\Components\SelectOptionsDBBuilder;
use App\Filament\Resources\PatientResource\Pages;
use App\Filament\Resources\PatientResource\Widgets\PatientDataWidget;
use App\Models\Patient;
use App\Traits\PatientTrait;
use App\Traits\StorageImages;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use \Illuminate\Database\Eloquent\Builder;

class PatientResource extends Resource
{
   use PatientTrait, StorageImages;

   protected static ?string $model = Patient::class;
   protected static ?string $label = 'Paciente';
   protected static ?string $navigationGroup = "Clínica";
   protected static ?string $navigationIcon = 'heroicon-o-user-group';

   public static function getEloquentQuery(): Builder
   {
      return parent::getEloquentQuery()->with('clinicalHistory');
   }

   public static function form(Form $form): Form
   {
      $recordId = $form->getLivewire()->data['id'] ?? false;

      return $form
         ->schema([
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
                  fn (TemporaryUploadedFile $file): string => self::parseNameByImage($form->getLivewire()->data['name']),
               ),

            TextInput::make('name')->label('Nombre')->required(),

            Grid::make()
               ->schema([
                  TextInput::make('email')->unique(ignoreRecord: $recordId),
                  DatePicker::make('birthday')->label('Fecha de nacimiento'),
               ]),

            Grid::make()
               ->schema([
                  SelectOptionsDBBuilder::make('document_type', 'Tipo de documento', true)->schema(),
                  TextInput::make('document_number')->label('Número de documento')->numeric()->required()->unique(ignoreRecord: $recordId),
               ]),

            Grid::make()
               ->columns(2)
               ->schema([
                  TextInput::make('phone')->label('Teléfono'),
                  TextInput::make('cellular')->label('Celular'),
               ]),

            Grid::make()
               ->columns(2)
               ->schema([
                  TextInput::make('address')->label('Dirección')->columnSpanFull(),
                  TextInput::make('address_indications')->label('Indicaciones extra'),
                  SelectOptionsDBBuilder::make('origin', 'Procedencia')->schema(),
               ]),

            Grid::make()
               ->columns(4)
               ->schema([
                  SelectOptionsDBBuilder::make('gender', 'Género')->schema(),
                  SelectOptionsDBBuilder::make('civil_status', 'Estado Civil')->schema(),
                  SelectOptionsDBBuilder::make('profession', 'Profesión')->schema(),
                  SelectOptionsDBBuilder::make('health_name', 'EPS')->schema(),
               ]),

            Fieldset::make()
               ->schema([
                  TextInput::make('companion_name')->label('Nombre'),
                  TextInput::make('companion_phone')->numeric()->label('teléfono'),
                  SelectOptionsDBBuilder::make(name: 'companion_gender', label: 'Género', optionType: 'gender')->schema(),
                  SelectOptionsDBBuilder::make('companion_relationship', 'Relación con el paciente')->schema(),
               ])
               ->columns(2)
               ->label('Acompañante'),
         ])
         ->columns(1);
   }

   public static function table(Table $table): Table
   {
      return $table
         ->columns([
            Tables\Columns\ImageColumn::make('image')->circular()->disk('local')->visibility('private'),
            Tables\Columns\TextColumn::make('name')->label('Nombre')->searchable(),
            Tables\Columns\TextColumn::make('document_number')->label('Documento')->searchable(),
            Tables\Columns\TextColumn::make('phone')->label('Teléfono'),
            Tables\Columns\TextColumn::make('email'),
            Tables\Columns\IconColumn::make('clinicalHistory.id')->boolean()->label('HC')->sortable(),
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
         'index' => Pages\ListPatients::route('/'),
         'create' => Pages\CreatePatient::route('/create'),
         'edit' => Pages\EditPatient::route('/{record}/edit'),
      ];
   }
}


