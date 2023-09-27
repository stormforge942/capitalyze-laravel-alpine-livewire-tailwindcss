<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JoinedUser extends Model
{
    use HasFactory;

    protected $fillable = [
        'email',
        'name',
        'likedin_link',
    ];

    protected $table = 'joined_users';
}
