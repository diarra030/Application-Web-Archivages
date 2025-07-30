<?php
namespace App\Helpers;

use Illuminate\Support\Facades\Auth;
use App\Models\UserPermission;
use App\Models\User;

class AccessHelper
{
    // gestion des acces par role

    public static function superAdmin(User $user): bool
    {
        return $user->role_id === 1;
    }

    public static function admin(User $user): bool
    {
        return $user->role_id === 2;
    }

    public static function user(User $user): bool
    {
        return $user->role_id === 3;
    }

    public static function getPermissionFor($userId, $folderId = null, $documentId = null): ?string
    {
        $query = \App\Models\UserPermission::where('user_id', $userId);

        if ($folderId !== null) {
            $query->where('folder_id', $folderId);
        }

        if ($documentId !== null) {
            $query->where('document_id', $documentId);
        }

        return $query->value('permission'); // 'L', 'E', 'LE' ou null
    }
}
