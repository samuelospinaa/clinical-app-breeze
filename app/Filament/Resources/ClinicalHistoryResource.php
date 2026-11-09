<?php

namespace App\Filament\Resources;

use App\Apis\IcdApi;
use App\Filament\Resources\ClinicalHistoryResource\Pages;
use App\Filament\Resources\ClinicalHistoryResource\RelationManagers;
use App\Models\ClinicalHistory;
use App\Traits\PatientTrait;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class ClinicalHistoryResource extends Resource
{
   use PatientTrait;

   protected static ?string $model = ClinicalHistory::class;
   protected static bool $shouldRegisterNavigation = false;
   protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

   public static function getEloquentQuery(): Builder
   {
      return parent::getEloquentQuery()->with('patient');
   }

   public static function form(Form $form): Form
   {
      $operation = $form->getOperation();

      return $form
         ->schema([
            self::getDiagnosesField($operation),
            Hidden::make('patient_id')->default(request()->patient),
            RichEditor::make('reason')->required()->label('Motivo de consulta'),
            RichEditor::make('antecedents')->required()->label('Antecedentes'),
            RichEditor::make('physicalExam')->required()->label('Exámen físico'),
            RichEditor::make('recommendations')->required()->label('Recomendaciones'),
         ])
         ->columns(1);
   }

   protected static function getDiagnosesField(string $operation)
   {
      if ($operation === 'create') {
         return Grid::make()
            ->columns(2)
            ->schema([
               Select::make('category_diagnoses')
                  ->label('Categoria del diagnostico')
                  ->required()
                  ->live()
                  ->afterStateUpdated(fn (Set $set) => $set('diagnoses', null))
                  ->dehydrated(false)
                  ->options(function () {
                     return self::getCieXCategories();
                  })
                  ->searchable(),

               Select::make('diagnoses')
                  ->label('Diagnóstico')
                  ->required()
                  ->live()
                  ->options(fn (Get $get): Collection => self::getCieXCodesByCategory($get('category_diagnoses')))
                  ->searchable(),
            ]);
      } else {
         return TextInput::make('diagnoses')->label('Diagnóstico');
      }
   }

   public static function table(Table $table): Table
   {
      return $table;
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
         'index' => Pages\ListClinicalHistories::route('/'),
         'create' => Pages\CreateClinicalHistory::route('/create'),
         'edit' => Pages\EditClinicalHistory::route('/{record}/edit'),
         'view' => Pages\ViewClinicalHistory::route('/{record}'),
      ];
   }
}
