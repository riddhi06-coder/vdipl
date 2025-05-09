<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomeBanner extends Model
{
    use HasFactory;

    protected $table = 'banner';
    public $timestamps = false;

    protected $fillable = [
        'banner_heading',
        'banner_video',
        'section_heading',
        'banner_image',
        'banner_image2',
        'description',
        'banner_items',
        'created_at',
        'created_by',
        'modified_at',
        'modified_by',
        'deleted_at',
        'deleted_by',
    ];
}
