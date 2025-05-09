<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomeService extends Model
{
    use HasFactory;

    protected $table = 'home_services';
    public $timestamps = false;

    protected $fillable = [
        'banner_heading',
        'service_id',
        'banner_image',
        'banner_image2',
        'created_at',
        'created_by',
        'modified_at',
        'modified_by',
        'deleted_at',
        'deleted_by',
    ];

    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id');
    }

}
