<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class About extends Model
{
    use HasFactory;

    protected $table = 'about_us';
    public $timestamps = false;

    protected $fillable = [
        'banner_heading',
        'banner_image',
        'section_heading',
        'description',
        'section_heading2',
        'vision_mission_names',
        'vision_mission_images',
        'vision_mission_descriptions',
        'section_heading3',
        'core_values_names',
        'core_values_images',
        'core_values_descriptions',
        'created_at',
        'created_by',
        'modified_at',
        'modified_by',
        'deleted_at',
        'deleted_by',
    ];
}
