<?php

namespace App\Providers\Filament;

use App\Filament\Pages\Auth\Login;
use App\Filament\Widgets\CreatedHomeCharts;
use App\Filament\Widgets\LatestAppointments;
use BezhanSalleh\FilamentShield\FilamentShieldPlugin;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Joaopaulolndev\FilamentEditEnv\FilamentEditEnvPlugin;
use Joaopaulolndev\FilamentEditProfile\FilamentEditProfilePlugin;
use Saade\FilamentFullCalendar\FilamentFullCalendarPlugin;
use Leandrocfe\FilamentApexCharts\FilamentApexChartsPlugin;

class AdminPanelProvider extends PanelProvider
{
   public function panel(Panel $panel): Panel
   {
      return $panel
         ->default()
         ->id("admin")
         ->path("admin")
         ->brandLogo(fn() => view("filament.admin.logo"))
         ->darkMode(false)
         ->colors(["primary" => Color::Cyan])
         ->discoverResources(
            in: app_path("Filament/Resources"),
            for: "App\\Filament\\Resources"
         )
         ->discoverPages(
            in: app_path("Filament/Pages"),
            for: "App\\Filament\\Pages"
         )
         ->login(Login::class)
         ->widgets([
            CreatedHomeCharts::class,
            LatestAppointments::class
         ])
         ->pages([Pages\Dashboard::class])
         ->navigationGroups([
            "Clínica",
            "Marketing",
            "Administrativo",
            "Reportes",
         ])
         ->plugin(
            FilamentFullCalendarPlugin::make()->selectable()->editable()
         )
         ->plugin(FilamentShieldPlugin::make())
         ->plugins([
            FilamentApexChartsPlugin::make(),

            FilamentEditEnvPlugin::make()
               ->showButton(fn() => auth()->user()->id === 1)
               ->setIcon("heroicon-o-cog"),

            FilamentEditProfilePlugin::make()
               ->slug("my-profile")
               ->setTitle("Mi perfil")
               ->setNavigationLabel("Mi perfil")
               ->setNavigationGroup("Administrativo")
               ->setIcon("heroicon-o-user")
               ->shouldShowAvatarForm(),
         ])
         ->middleware([
            EncryptCookies::class,
            AddQueuedCookiesToResponse::class,
            StartSession::class,
            AuthenticateSession::class,
            ShareErrorsFromSession::class,
            VerifyCsrfToken::class,
            SubstituteBindings::class,
            DisableBladeIconComponents::class,
            DispatchServingFilamentEvent::class,
         ])
         ->authMiddleware([Authenticate::class]);
   }
}
