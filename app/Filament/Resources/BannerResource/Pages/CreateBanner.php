<?php

namespace App\Filament\Resources\BannerResource\Pages;

use App\Filament\Resources\BannerResource;
use App\Models\Banner;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateBanner extends CreateRecord
{
    protected static string $resource = BannerResource::class;

   protected function mutateFormDataBeforeCreate(array $data): array
   {
      $data['order'] = Banner::count() + 1;
      return $data;
   }

   protected function getRedirectUrl(): string
   {
      $resource = static::getResource();
      return $resource::getUrl('index');
   }
}
