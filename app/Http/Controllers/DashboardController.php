<?php

namespace App\Http\Controllers;

use App\Presenters\BannersPresenter;
use App\Presenters\ProfessionalPresenter;
use App\Traits\BannersTrait;
use App\Traits\ProfessionalTrait;
use App\Traits\TestimoniesTrait;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
   use BannersTrait, TestimoniesTrait, ProfessionalTrait;

   /**
    * Handle the incoming request.
    */
   public function __invoke(Request $request)
   {
      return redirect()->route('filament.admin.pages.dashboard');
   }
}
