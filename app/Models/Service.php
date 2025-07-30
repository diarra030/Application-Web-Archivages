<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Service extends Model
{
    use HasFactory;

    protected $fillable = ['nom'];

public function users()
    {
        return $this->hasmany(User::class);
    }

    public function documents()
    {
        return $this->belongsToMany(Document::class)->withTimestamps();
    }

    public function identificate(){
        return $this->belongsToMany(User::class, 'service_users_identification', 'services_id', 'user_id')->withTimestamps();
    }
    public function folder_service(){   
        return $this->hasMany(Folder::class);
    }
}
