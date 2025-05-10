<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceIntro extends Model
{
    use HasFactory;

    protected $table = 'service_intro';
    public $timestamps = false;

    protected $fillable = [
        'service_id',
        'banner_image',
        'section_heading',
        'image',
        'description',
        'section_heading2',
        'banner_titles',
        'banner_images',
        'banner_descriptions',
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
