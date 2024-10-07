<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyDetails extends Model
{
    use HasFactory;
    protected $table = 'company_details';
    protected $fillable = [
        'company_name',
        'website',
        'email',
        'mobile_number',
        'postalcode',
        'address',
        'logo',
        'invoice_slug',
        'status',
    ];
}
