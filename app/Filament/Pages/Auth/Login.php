<?php

namespace App\Filament\Pages\Auth;

use Filament\Forms\Form;
use Filament\Pages\Auth\Login as BaseLogin;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\HtmlString;
use Phpsa\FilamentPasswordReveal\Password;

class Login extends BaseLogin
{
   protected static ?string $title = 'Hola';

   public function form(Form $form): Form
   {
      return $form->schema([
         $this->getEmailFormComponent(),

         Password::make('password')
            ->revealable()
            ->label(__('filament-panels::pages/auth/login.form.password.label'))
            ->hint(filament()->hasPasswordReset() ? new HtmlString(Blade::render('<x-filament::link :href="filament()->getRequestPasswordResetUrl()"> {{ __(\'filament-panels::pages/auth/login.actions.request_password_reset.label\') }}</x-filament::link>')) : null)
            ->password()
            ->autocomplete('current-password')
            ->required()
            ->extraInputAttributes(['tabindex' => 2]),

         $this->getRememberFormComponent(),
      ]);
   }
}
