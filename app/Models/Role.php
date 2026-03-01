<?php

namespace App\Models;

/** @property int $id */

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Role extends Model
{
    use HasFactory;

    /** The role_id value that identifies an administrator. */
    public const ADMIN_ID = 1;

    public function users()
    {
        return $this->hasMany(User::class, 'role_id');
    }

}
