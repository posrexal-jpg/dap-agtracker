<?php

namespace App\Models;

/** @property int $id */

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Role extends Model
{
    use HasFactory;

<<<<<<< HEAD
=======
    protected $fillable = ['role_name'];

>>>>>>> cfe5925bbedd2b2a05f4d904b6d23f3665016d7a
    /** The role_id value that identifies an administrator. */
    public const ADMIN_ID = 1;

    public function users()
    {
        return $this->hasMany(User::class, 'role_id');
    }

}
