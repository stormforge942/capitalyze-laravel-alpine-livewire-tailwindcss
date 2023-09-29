<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanySegmentReportReviewFile extends Model
{
    protected $fillable = [
        'company_segment_report_id',
        'file_id'
    ];

    protected $connection = 'pgsql';
    public $table  = 'company_segment_report_review_files';
}
