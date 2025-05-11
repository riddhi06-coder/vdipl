<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Projects extends Model
{
    use HasFactory;

    protected $table = 'projects_details';
    public $timestamps = false;

    protected $fillable = [
        'service_id',
        'banner_heading',
        'banner_image',
        'section_heading',
        'project_name',
        'location',
        'cost',
        'image',
        'created_at',
        'created_by',
        'modified_at',
        'modified_by',
        'deleted_at',
        'deleted_by',
    ];

    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id');
    }

}
