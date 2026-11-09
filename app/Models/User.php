<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Traits\StorageImages;
use BezhanSalleh\FilamentShield\Traits\HasPanelShield;
use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasAvatar;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements FilamentUser, HasAvatar
{
   use HasApiTokens, HasFactory, Notifiable, HasRoles, SoftDeletes, StorageImages, HasPanelShield;

   protected $with = ['roles'];

   /**
    * The attributes that are mass assignable.
    *
    * @var array<int, string>
    */
   protected $fillable = [
      'name',
      'email',
      'image',
      'password',
      'deleted_at',
      'avatar_url',
   ];

   /**
    * The attributes that should be hidden for serialization.
    *
    * @var array<int, string>
    */
   protected $hidden = [
      'password',
      'remember_token',
   ];

   /**
    * The attributes that should be cast.
    *
    * @var array<string, string>
    */
   protected $casts = [
      'email_verified_at' => 'datetime',
      'password' => 'hashed',
   ];

   protected static function boot()
   {
      parent::boot();

      static::updating(function ($user) {
         if ($user->isDirty('avatar_url')) {
            $user->image = $user->avatar_url;
         } elseif ($user->isDirty('image')) {
            $user->avatar_url = $user->image;
         }
      });

      static::deleting(function ($model) {
         if($model->isProfessional) {
            $model->isProfessional->delete();
         }
      });
   }

   public function canAccessPanel(Panel $panel): bool
   {
      //return str_ends_with($this->email, '@yourdomain.com') && $this->hasVerifiedEmail();
      return true;
   }

   public function isAdmin()
   {
      return auth()->user()->hasRole('admin');
   }

   public function isSuperAdmin()
   {
      return auth()->user()->hasRole('super_admin');
   }

   public function isProfessional(): HasOne
   {
      return $this->hasOne(Professional::class);
   }

   public function scopeWithoutProfessional()
   {
      return $this->doesntHave('isProfessional')->get();
   }

   public function getFilamentAvatarUrl(): ?string
   {
      return $this->getStorageUrl($this->image);
   }
}
