<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceChoose extends Model
{
    use HasFactory;

    protected $table = 'service_whychoose';
    public $timestamps = false;

    protected $fillable = [
        'service_id',
        'section_heading',
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
}
