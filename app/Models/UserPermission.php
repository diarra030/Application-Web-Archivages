<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPermission extends Model
{
    use HasFactory;

    protected $fillable = [
        'user',         // nom lisible de l'utilisateur
        'user_id',      // clé étrangère vers users
        'folder',       // nom lisible du dossier
        'folder_id',    // clé étrangère vers folders
        'document',     // nom lisible du document
        'document_id',  // clé étrangère vers documents
        'permission',   // L, E ou LE
    ];

    protected $casts = [
        'folder_id' => 'integer',
        'document_id' => 'integer',
    ];

    /**
     * Relation avec le modèle User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relation avec le modèle Folder
     */
    public function folder()
    {
        return $this->belongsTo(Folder::class);
    }

    /**
     * Relation avec le modèle Document
     */
    public function document()
    {
        return $this->belongsTo(Document::class);
    }
}

