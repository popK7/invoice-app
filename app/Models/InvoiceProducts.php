<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceProducts extends Model
{
    use HasFactory;
    protected $table = 'invoice_products';
    protected $fillable = [
        'invoice_id',
        'product_id',
        'currency_type',
        'rate',
        'quantity',
        'amount',
    ];
    
    function invoice() {
        return $this->hasOne(Invoice::class,'id','invoice_id');
    }

    function product() {
        return $this->hasOne(Products::class,'id','product_id');
    }
}
