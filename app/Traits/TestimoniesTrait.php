<?php

namespace App\Traits;

use App\Models\Testimony;
use Illuminate\Database\Eloquent\Collection;

trait TestimoniesTrait
{
   protected function dashboardTestimonies(): Collection
   {
      return Testimony::orderByDesc('created_at')->inRandomOrder()->get();
   }
}
