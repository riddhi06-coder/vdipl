<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Associates extends Model
{
    use HasFactory;

    protected $table = 'home_associates';
    public $timestamps = false;

    protected $fillable = [
        'heading',
        'section_heading',
        'section_heading2',
        'section_heading3',
        'banner_items',
        'items',
        'items1',
        'created_at',
        'created_by',
        'modified_at',
        'modified_by',
        'deleted_at',
        'deleted_by',
    ];
}
