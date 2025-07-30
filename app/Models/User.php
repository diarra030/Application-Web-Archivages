<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class User extends Authenticatable
{
    use HasApiTokens;

    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['name', 'email', 'password', 'service_id', 'role_id', 'services_identifications'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = ['password', 'remember_token', 'two_factor_recovery_codes', 'two_factor_secret'];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = ['profile_photo_url'];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function documents()
    {
        return $this->hasMany(Document::class);
    }

    public function document()
    {
        return $this->belongsToMany(Document::class)->withPivot('tagger')->withTimestamps();
    }

    public function identificate()
    {
        return $this->belongsToMany(Service::class, 'service_users_identification', 'user_id', 'services_id')->withTimestamps();
    }

    public function confidentialite()
    {
        return $this->belongsToMany(Document::class, 'document_users_conf', 'user_id', 'doc_id')->withTimestamps();
    }

    public function folder()
    {
        return $this->hasMany(folder::class);
    }

    public function permissions()
    {
        return $this->hasMany(UserPermission::class);
    }


    // ajouter par kevin N'doufou
    public function hasAnyPermission(): bool
    {
        return $this->permissions()
            ->where(function ($query) {
                $query->whereNotNull('folder_id')->orWhereNotNull('document_id');
            })
            ->exists();
    }
}
