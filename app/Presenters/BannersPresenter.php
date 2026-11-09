<?php

namespace App\Presenters;

use AdditionApps\FlexiblePresenter\FlexiblePresenter;
use App\Traits\StorageImages;
use Illuminate\Support\Facades\Cache;

class BannersPresenter extends FlexiblePresenter
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
