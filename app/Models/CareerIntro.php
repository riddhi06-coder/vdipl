<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CareerIntro extends Model
{
    use HasFactory;

    protected $table = 'career_intro';
    public $timestamps = false;

    protected $fillable = [
        'banner_heading',
        'banner_image',
        'section_heading',
        'banner_image2',
        'description',
        'description2',
        'section_heading2',
        'images',
        'descriptions',
        'created_at',
        'created_by',
        'modified_at',
        'modified_by',
        'deleted_at',
        'deleted_by',
    ];
}
