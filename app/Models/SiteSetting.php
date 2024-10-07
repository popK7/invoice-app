<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    use HasFactory;
    protected $table = "site_settings";
    protected $fillable = [
        'id',
        'app_title', 
        'light_logo',
        'dark_logo',
        'favicon',
        'logo_sm',
        'copyright_first',
        'copyright_last',
    ];
}
