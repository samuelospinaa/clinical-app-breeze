<?php

namespace App\Filament\Resources\ClinicalHistoryResource\Pages;

use App\Filament\Resources\ClinicalHistoryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditClinicalHistory extends EditRecord
{
    protected static string $resource = ClinicalHistoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            //
        ];
    }
}
