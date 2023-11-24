<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InfoTikrPresentation extends Model
{
    use HasFactory;
    protected $connection = 'pgsql-xbrl';
    protected $table = 'info_tikr_presentations';
    public $timestamps = false;

    protected $casts = [
        'info' => 'array',
    ];
}
