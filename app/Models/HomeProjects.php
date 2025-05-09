<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomeProjects extends Model
{
    use HasFactory;

    protected $table = 'home_projects';
    public $timestamps = false;

    protected $fillable = [
        'banner_heading',
        'location',
        'cost',
        'banner_image',
        'description',
        'created_at',
        'created_by',
        'modified_at',
        'modified_by',
        'deleted_at',
        'deleted_by',
    ];
}
