<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;
    protected $fillable = [
        'notification_type_id',
        'title', 
        'data', 
        'from_user', 
        'to_user', 
        'is_read', 
        'is_deleted'
    ];

    public function user(){
        return $this->hasOne(User::class,'id','from_user');
    }
}
