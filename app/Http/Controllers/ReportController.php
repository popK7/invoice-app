<?php

namespace App\Http\Controllers;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Yajra\DataTables\DataTables;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Invoice;
use App\Models\InvoicePaymentDetails;
use App\Models\Notification;

class ReportController extends Controller
{
    // Sale report summary 
    public function saleReports(Request $request) {
        $user = Sentinel::getUser();
        if ($user->hasAccess('report.list')) {
            $user_id = $user->id;
            $role = $user->roles[0]->slug;
            $invoiceProducts = Invoice::with('product','product.product','product.product.category','product.product.brand',)->where('payment_status',1)->get();
            return view('reports.sale-report',compact('user','role','invoiceProducts'));
        } else {
            return view('error.403');
        }
    }
}
