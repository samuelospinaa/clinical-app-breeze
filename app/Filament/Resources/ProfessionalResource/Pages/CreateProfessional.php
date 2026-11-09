<?php

namespace App\Filament\Resources\ProfessionalResource\Pages;

use App\Filament\Resources\ProfessionalResource;
use App\Models\User;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateProfessional extends CreateRecord
{
   protected static string $resource = ProfessionalResource::class;

   protected function afterCreate(): void
   {
      $data = $this->data;
      $record = $this->record;

      $user = User::create([
         "name" => $data['name'],
         "email" => $data['email'],
         "password" => $data['password'],
         "image" => count($data['image']) > 0 ? array_pop($data['image']) : null,
      ]);

      $user->assignRole('professional');

      $record->update([
         "user_id" => $user->id
      ]);
   }
}
