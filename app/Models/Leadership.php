<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Leadership extends Model
{
    use HasFactory;

    protected $table = 'leadership';
    public $timestamps = false;

    protected $fillable = [
        'banner_title',
        'banner_image',
        'section_title',
        'name',
        'designation',
        'image',
        'description',
        'created_at',
        'created_by',
        'modified_at',
        'modified_by',
        'deleted_at',
        'deleted_by',
    ];
}
