<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InfoPresentation extends Model
{
    use HasFactory;
    public $connection = 'pgsql-xbrl';
}
