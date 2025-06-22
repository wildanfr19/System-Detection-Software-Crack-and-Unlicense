<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetectionLog extends Model
{
    use HasFactory;
    protected $fillable = [
    'pc_name',
    'user_name',
    'app_name',
    'detected_at',
    'ip_address',
    'mac_address',
    'path',
    'source'
];

}
