<?php

namespace App\Presenters;

use AdditionApps\FlexiblePresenter\FlexiblePresenter;
use App\Traits\StorageImages;

class ProfessionalPresenter extends FlexiblePresenter
{
   use StorageImages;

   public function values(): array
   {
      return [
         ...$this->resource->toArray(),
         'image' => $this->getStorageUrl($this->image),
      ];
   }
}
