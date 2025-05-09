<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clientele extends Model
{
    use HasFactory;

    protected $table = 'home_clientele';
    public $timestamps = false;

    protected $fillable = [
        'heading',
        'section_heading',
        'section_heading2',
        'banner_items',
        'items',
        'created_at',
        'created_by',
        'modified_at',
        'modified_by',
        'deleted_at',
        'deleted_by',
    ];
}
