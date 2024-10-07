<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoicePaymentDetails extends Model
{
    use HasFactory;
    protected $table = 'invoice_payment_details';
    protected $fillable = [
        'invoice_id',
        'order_id',
        'payment_gateway',
        'payment_method',
        'card_holder_name',
        'amount',
        'amount_pay_currency',
        'refund_amount',
        'stripe_charge_id',
        'stripe_refund_id',
        'stripe_transaction_id',
        'status'
    ];
    
    function invoice() {
        return $this->hasOne(Invoice::class,'id','invoice_id ');
    }
}
