<?php

namespace App\Filament\Resources\PatientResource\RelationManagers;

use App\Filament\Resources\ClinicalHistoryResource;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class ClinicalHistoryRelationManager extends RelationManager
{
    protected static string $relationship = 'clinicalHistory';

    public function form(Form $form): Form
    {
        return ClinicalHistoryResource::form($form);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('id')
            ->headerActions([
                Tables\Actions\CreateAction::make()->hidden((bool)$this->ownerRecord->clinicalHistory),
            ]);
    }
}
