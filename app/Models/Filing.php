<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Filing extends Model
{
    use HasFactory;

    protected $connection = 'pgsql-xbrl';

    protected $table = 'public.filings';

    public $timestamps = false;
}
