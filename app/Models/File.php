<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class File extends Model
{
    protected $fillable = [
        'path',
        'url',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function deleteFromBucket()
    {
        Storage::disk('s3')->delete($this->path);
    }

    protected $connection = 'pgsql';
    public $table  = 'files';
}
