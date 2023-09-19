<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanySegmentReport extends Model
{
    protected $fillable = [
        'amount',
        'link',
        'image_path',
        'explanations',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected $connection = 'pgsql';
    public $table  = 'company_segment_reports';
}
