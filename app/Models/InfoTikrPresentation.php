<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InfoTikrPresentation extends Model
{
    use HasFactory;
    public $connection = 'pgsql-xbrl';
}
