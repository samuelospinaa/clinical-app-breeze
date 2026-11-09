<?php

namespace App\Traits;

use App\Models\Banner;
use Illuminate\Database\Eloquent\Collection;

trait BannersTrait
{
   protected function dashboardBanners(): Collection
   {
      return Banner::orderBy('order', 'ASC')->where('visible', 1)->get();
   }
}
