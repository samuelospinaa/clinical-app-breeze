<?php

namespace App\Filament\Pages\Auth;

use App\Models\User;
use App\Traits\StorageImages;
use Closure;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Pages\Auth\EditProfile as BaseEditProfile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use \Phpsa\FilamentPasswordReveal\Password as PasswordField;

class EditProfile extends BaseEditProfile
{
   use StorageImages;

   public function form(Form $form): Form
   {
      return $form
         ->schema([
            FileUpload::make('image')
               ->optimize('webp')
               ->avatar()
               ->alignCenter()
               ->image()
               ->label('')
               ->disk('local')
               ->directory('public/users')
               ->visibility('private')
               ->multiple(false)
               ->getUploadedFileNameForStorageUsing(
                  fn(TemporaryUploadedFile $file): string => self::parseNameByImage($file, $form->getLivewire()->data['name']),
               ),

            $this->getNameFormComponent(),
            $this->getEmailFormComponent(),

            PasswordField::make('password')
               ->minLength(6)
               ->minValue(6)
               ->revealable()
               ->label(__('filament-panels::pages/auth/edit-profile.form.password.label'))
               ->password()
               ->rule(Password::default())
               ->autocomplete('new-password')
               ->dehydrated(fn ($state): bool => filled($state))
               ->live()
               ->same('passwordConfirmation'),

            PasswordField::make('passwordConfirmation')
               ->revealable()
               ->label(__('filament-panels::pages/auth/edit-profile.form.password_confirmation.label'))
               ->password()
               ->required()
               ->visible(fn (Get $get): bool => filled($get('password')))
               ->dehydrated(false),

            PasswordField::make('current_password')
               ->revealable()
               ->label('Contraseña actual')
               ->password()
               ->visible(fn (Get $get): bool => filled($get('password')))
               ->dehydrated(false)
               ->rules([
                  function () {
                     return function (string $attribute, $value, Closure $fail) {
                        $user = User::find(auth()->user()->id);

                        if (!Hash::check($value, $user->password)) {
                           $fail('The :attribute is incorrect.');
                        }
                     };
                  },
               ])
         ]);
   }
}
