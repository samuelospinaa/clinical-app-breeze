<?php

namespace App\Filament\Resources\AppointmentTypeResource\Pages;

use App\Filament\Resources\AppointmentTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAppointmentType extends EditRecord
{
    protected static string $resource = AppointmentTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
