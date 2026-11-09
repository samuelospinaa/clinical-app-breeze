<?php

namespace App\Filament\Resources\ClinicalHistoryResource\Pages;

use App\Filament\Resources\ClinicalHistoryResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListClinicalHistories extends ListRecords
{
    protected static string $resource = ClinicalHistoryResource::class;

    public function __construct()
    {
       $this->redirect('/admin/patients');
    }

   protected function getHeaderActions(): array
    {
        return [
            //
        ];
    }
}
