<?php

namespace App\Traits;

use App\Models\Professional;
use Illuminate\Database\Eloquent\Collection;

trait ProfessionalTrait
{
   protected function dashboardProfessionals(): Collection
   {
      return Professional::orderByDesc('created_at')->inRandomOrder()->get();
   }
}
