<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    protected $table = 'contact';
    public $timestamps = false;

    protected $fillable = [
        'banner_title',
        'banner_image',
        'section_title',
        'email',
        'email2',
        'phone',
        'address',
        'url',
        'social_platforms',
        'social_urls',
        'created_at',
        'created_by',
        'modified_at',
        'modified_by',
        'deleted_at',
        'deleted_by',
    ];
}
