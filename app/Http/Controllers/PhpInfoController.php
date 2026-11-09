<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PhpInfoController extends Controller
{
   /**
    * Handle the incoming request.
    */
   public function __invoke(Request $request)
   {
      if ($request->user()->id === 1) {
         return phpinfo();
      }

      return to_route('filament.admin.pages.dashboard');
   }
}
