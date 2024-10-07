<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;
    protected $table = 'invoice';
    protected $fillable = [
        'client_id',
        'invoice_number',
        'date',
        'payment_status',
        'company_id',
        'billing_full_name',
        'billing_address',
        'billing_mobile_number',
        'billing_tax_number',
        'shippling_full_name',
        'shippling_address',
        'shippling_mobile_number',
        'shippling_tax_number',
        'is_billing_shippling_add_same',
        'sub_total',
        'tax',
        'discount',
        'shipping_charge',
        'total_amount',
        'created_by ',
        'is_deleted',
    ];
    
    function company() {
        return $this->hasOne(CompanyDetails::class,'id','company_id');
    }

    function user() {
        return $this->hasOne(User::class,'id','created_by');
    }

    function client() {
        return $this->hasOne(User::class,'id','client_id');
    }

    function paymentDetails() {
        return $this->hasOne(InvoicePaymentDetails::class, 'invoice_id', 'id');
    }

    function product() {
        return $this->hasMany(InvoiceProducts::class,'invoice_id','id');
    }
}
