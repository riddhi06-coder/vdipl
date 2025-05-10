<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assets extends Model
{
    use HasFactory;

    protected $table = 'assets';
    public $timestamps = false;

    protected $fillable = [
        'banner_title',
        'banner_image',
        'section_title',
        'header_data',
        'assets_types',
        'no_assets_list',
        'created_at',
        'created_by',
        'modified_at',
        'modified_by',
        'deleted_at',
        'deleted_by',
    ];
}
