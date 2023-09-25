<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanySegmentReport extends Model
{
    protected $fillable = [
        'previous_amount',
        'date',
        'company_url',
        'amount',
        'link',
        'explanations',
        'user_id',
        'fixed',
        'support_engineer',
        'support_engineer_comments'
    ];

    public function files()
    {
        return $this->belongsToMany(
            File::class,
            CompanySegmentReportFile::class,
            'company_segment_report_id',
            'file_id'
        );
    }

    public function reviewFiles()
    {
        return $this->belongsToMany(
            File::class,
            CompanySegmentReportReviewFile::class,
            'company_segment_report_id',
            'file_id'
        );
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected $connection = 'pgsql';
    public $table  = 'company_segment_reports';
}
