<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientDetails extends Model
{
    use HasFactory;

    protected $table = 'client_details';
    protected $fillable = [
        'user_id',
        'company_name',
        'gst_number',
        'company_code',
        'address',
    ];

    function client(){
        return $this->hasOne(User::class,'id','user_id');
    }
}
