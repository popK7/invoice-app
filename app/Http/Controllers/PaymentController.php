<?php

namespace App\Http\Controllers;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Redirect;
use Yajra\DataTables\DataTables;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Invoice;
use App\Models\InvoicePaymentDetails;
use App\Models\Notification;
use Stripe;


class PaymentController extends Controller
{
    public function __construct()
    {
        $this->url = url('/');
    }

    // Detail payments
    public function paymentList(Request $request) {
        $user = Sentinel::getUser();
        if ($user->hasAccess('payment.list')) {
            $user_id = $user->id;
            $role = $user->roles[0]->slug;

            $allInvoice = Invoice::with('paymentDetails')->where('is_deleted',0)->get();
            $pendingInvoice = Invoice::where('payment_status',0)->where('is_deleted',0)->get();
            $paidInvoice = Invoice::where('payment_status',1)->where('is_deleted',0)->get();
            $refundInvoice = Invoice::where('payment_status',2)->where('is_deleted',0)->get();

            // Load Yajra Datatable
            if ($request->ajax()) {
                return Datatables::of($allInvoice)
                    ->addIndexColumn()
                    ->addColumn('client', function($row){
                        $client = $row->client->first_name.' '.$row->client->last_name;
                        return $client;
                    })
                    ->addColumn('date', function($row){
                        $date = $row->date;
                        return $date;
                    })
                    ->addColumn('payment_status', function($row){
                        if($row->payment_status == 0) { $statusValue = 'Unpaid';$statusColor = 'danger';};
                        if($row->payment_status == 1) { $statusValue = 'Paid';$statusColor = 'success';};
                        if($row->payment_status == 2) { $statusValue = 'Refund';$statusColor = 'warning';};
                        if($row->payment_status == 3) { $statusValue = 'Cancel';$statusColor = 'info';};
                        $payment_status = '<span class="badge badge-soft-'.$statusColor.' p-2">'.$statusValue.'</span>';
                        return $payment_status;
                    })
                    ->addColumn('payment_details', function($row){
                        if($row->payment_status == 1) {
                            $payment_details = $row->paymentDetails->payment_method;
                        } if($row->payment_status != 1) {
                            $payment_details = "  -  ";
                        }
                        return $payment_details;
                    })
                    ->addColumn('action', function($row){
                        $action = '
                            <ul class="list-inline hstack gap-1 mb-0">
                                <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="View">
                                    <a href="'.route('view-invoice', $row->id).'" class="btn btn-soft-dark btn-sm d-inline-block"><i class="las la-eye fs-17 align-middle"></i></a>
                                </li>';
                                if($row->payment_status != 1) { 
                                    $action .=
                                    '<li class="list-inline-item edit" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Edit">
                                        <a href="'.route('edit-invoice', $row->id).'" class="btn btn-soft-info btn-sm d-inline-block"><i class="las la-pen fs-17 align-middle"></i></a>
                                    </li>
                                '; } 
                                $action .= '<li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Remove">
                                    <a href="'.route('delete-invoice', $row->id).'" class="btn btn-soft-danger btn-sm d-inline-block"><i class="las la-trash fs-17 align-middle"></i></a>
                                </li>
                            </ul>
                        ';
                        return $action;
                    })
                    ->rawColumns(['client','date','created_by','payment_status','payment_details','action'])->make(true);
            }
            // End

            return view('payments.payment-details',compact('user','role','allInvoice','paidInvoice','pendingInvoice','refundInvoice'));
        } else {
            return view('error.403');
        }
    }

    // Paid payments
    public function paidPayment(Request $request) {
        $user = Sentinel::getUser();
        if ($user->hasAccess('payment.list')) {
            $user_id = $user->id;
            $role = $user->roles[0]->slug;
            $paidInvoice = Invoice::where('payment_status',1)->where('is_deleted',0)->get();

            // Load Yajra Datatable
            if ($request->ajax()) {
                return Datatables::of($paidInvoice)
                    ->addIndexColumn()
                    ->addColumn('client', function($row){
                        $client = $row->client->first_name.' '.$row->client->last_name;
                        return $client;
                    })
                    ->addColumn('date', function($row){
                        $date = $row->date;
                        return $date;
                    })
                    ->addColumn('payment_status', function($row){
                        if($row->payment_status == 0) { $statusValue = 'Unpaid';$statusColor = 'danger';};
                        if($row->payment_status == 1) { $statusValue = 'Paid';$statusColor = 'success';};
                        if($row->payment_status == 2) { $statusValue = 'Refund';$statusColor = 'warning';};
                        if($row->payment_status == 3) { $statusValue = 'Cancel';$statusColor = 'info';};
                        $payment_status = '<span class="badge badge-soft-'.$statusColor.' p-2">'.$statusValue.'</span>';
                        return $payment_status;
                    })
                    ->addColumn('payment_details', function($row){
                        $payment_details = $row->paymentDetails->payment_method;
                        return $payment_details;
                    })
                    ->addColumn('action', function($row){
                        $action = '
                                <ul class="list-inline hstack gap-1 mb-0">
                                    <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="View">
                                        <a href="'.route('view-invoice', $row->id).'" class="btn btn-soft-dark btn-sm d-inline-block"><i class="las la-eye fs-17 align-middle"></i></a>
                                    </li>';
                                    if($row->payment_status != 1) { 
                                        $action .=
                                        '<li class="list-inline-item edit" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Edit">
                                            <a href="'.route('edit-invoice', $row->id).'" class="btn btn-soft-info btn-sm d-inline-block"><i class="las la-pen fs-17 align-middle"></i></a>
                                        </li>
                                    '; } 
                                    $action .= '<li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Remove">
                                        <a href="'.route('delete-invoice', $row->id).'" class="btn btn-soft-danger btn-sm d-inline-block"><i class="las la-trash fs-17 align-middle"></i></a>
                                    </li>
                                </ul>
                        ';
                        return $action;
                    })
                    ->rawColumns(['client','date','created_by','payment_status','payment_details','action'])->make(true);
            }
            // End
            return view('payments.paid-payment-details',compact('user','role','paidInvoice'));
        } else {
            return view('error.403');
        }
    }

    // Pending payments
    public function pendingPayment(Request $request) {
        $user = Sentinel::getUser();
        if ($user->hasAccess('payment.list')) {
            $user_id = $user->id;
            $role = $user->roles[0]->slug;
            $pendingInvoice = Invoice::where('payment_status',0)->where('is_deleted',0)->get();

            // Load Yajra Datatable
            if ($request->ajax()) {
                return Datatables::of($pendingInvoice)
                    ->addIndexColumn()
                    ->addColumn('client', function($row){
                        $client = $row->client->first_name.' '.$row->client->last_name;
                        return $client;
                    })
                    ->addColumn('date', function($row){
                        $date = $row->date;
                        return $date;
                    })
                    ->addColumn('payment_status', function($row){
                        if($row->payment_status == 0) { $statusValue = 'Unpaid';$statusColor = 'danger';};
                        if($row->payment_status == 1) { $statusValue = 'Paid';$statusColor = 'success';};
                        if($row->payment_status == 2) { $statusValue = 'Refund';$statusColor = 'warning';};
                        if($row->payment_status == 3) { $statusValue = 'Cancel';$statusColor = 'info';};
                        $payment_status = '<span class="badge badge-soft-'.$statusColor.' p-2">'.$statusValue.'</span>';
                        return $payment_status;
                    })
                    ->addColumn('payment_details', function($row){
                        if($row->payment_status == 1) {
                            $payment_details = $row->paymentDetails->payment_method;
                        } else {
                            $payment_details = "  -  ";
                        }
                        return $payment_details;
                    })
                    ->addColumn('action', function($row){
                        $action = '
                            <ul class="list-inline hstack gap-1 mb-0">
                                <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="View">
                                    <a href="'.route('view-invoice', $row->id).'" class="btn btn-soft-dark btn-sm d-inline-block"><i class="las la-eye fs-17 align-middle"></i></a>
                                </li>
                                <li class="list-inline-item edit" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Edit">
                                    <a href="'.route('edit-invoice', $row->id).'" class="btn btn-soft-info btn-sm d-inline-block"><i class="las la-pen fs-17 align-middle"></i></a>
                                </li>
                                <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Delete">
                                    <a href="'.url('delete-invoice', $row->id).'" class="btn btn-soft-danger btn-sm d-inline-block"><i class="las la-trash fs-17 align-middle"></i></a>
                                </li>
                            </ul>
                        ';
                        return $action;
                    })
                    ->rawColumns(['client','date','created_by','payment_status','payment_details','action'])->make(true);
            }
            // End
            return view('payments.pending-payment-details',compact('user','role','pendingInvoice'));
        } else {
            return view('error.403');
        }
    }

    // Refunded payments
    public function refundedPayment(Request $request) {
        $user = Sentinel::getUser();
        if ($user->hasAccess('payment.list')) {
            $user_id = $user->id;
            $role = $user->roles[0]->slug;
            $refundedInvoice = Invoice::where('payment_status',2)->where('is_deleted',0)->get();

            // Load Yajra Datatable
            if ($request->ajax()) {
                return Datatables::of($refundedInvoice)
                    ->addIndexColumn()
                    ->addColumn('client', function($row){
                        $client = $row->client->first_name.' '.$row->client->last_name;
                        return $client;
                    })
                    ->addColumn('date', function($row){
                        $date = $row->date;
                        return $date;
                    })
                    ->addColumn('payment_status', function($row){
                        if($row->payment_status == 0) { $statusValue = 'Unpaid';$statusColor = 'danger';};
                        if($row->payment_status == 1) { $statusValue = 'Paid';$statusColor = 'success';};
                        if($row->payment_status == 2) { $statusValue = 'Refund';$statusColor = 'warning';};
                        if($row->payment_status == 3) { $statusValue = 'Cancel';$statusColor = 'info';};
                        $payment_status = '<span class="badge badge-soft-'.$statusColor.' p-2">'.$statusValue.'</span>';
                        return $payment_status;
                    })
                    ->addColumn('payment_details', function($row){
                        $payment_details = $row->paymentDetails->payment_method;
                        return $payment_details;
                    })
                    ->addColumn('action', function($row){
                        $action = '
                            <ul class="list-inline hstack gap-1 mb-0">
                                <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="View">
                                    <a href="'.route('view-invoice', $row->id).'" class="btn btn-soft-dark btn-sm d-inline-block"><i class="las la-eye fs-17 align-middle"></i></a>
                                </li>
                                <li class="list-inline-item edit" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Edit">
                                    <a href="'.route('edit-invoice', $row->id).'" class="btn btn-soft-info btn-sm d-inline-block"><i class="las la-pen fs-17 align-middle"></i></a>
                                </li>
                                <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Delete">
                                    <a href="'.url('delete-invoice', $row->id).'" class="btn btn-soft-danger btn-sm d-inline-block"><i class="las la-trash fs-17 align-middle"></i></a>
                                </li>
                            </ul>
                        ';
                        return $action;
                    })
                    ->rawColumns(['client','date','created_by','payment_status','payment_details','action'])->make(true);
            }
            // End
            return view('payments.refunded-payment-details',compact('user','role','refundedInvoice'));
        } else {
            return view('error.403');
        }
    }

    // Cancelled payments
    public function cancelPayment(Request $request) {
        $user = Sentinel::getUser();
        if ($user->hasAccess('payment.list')) {
            $user_id = $user->id;
            $role = $user->roles[0]->slug;
            $cancelInvoice = Invoice::where('payment_status',3)->where('is_deleted',0)->get();

            // Load Yajra Datatable
            if ($request->ajax()) {
                return Datatables::of($cancelInvoice)
                    ->addIndexColumn()
                    ->addColumn('client', function($row){
                        $client = $row->client->first_name.' '.$row->client->last_name;
                        return $client;
                    })
                    ->addColumn('date', function($row){
                        $date = $row->date;
                        return $date;
                    })
                    ->addColumn('payment_status', function($row){
                        if($row->payment_status == 0) { $statusValue = 'Unpaid';$statusColor = 'danger';};
                        if($row->payment_status == 1) { $statusValue = 'Paid';$statusColor = 'success';};
                        if($row->payment_status == 2) { $statusValue = 'Refund';$statusColor = 'warning';};
                        if($row->payment_status == 3) { $statusValue = 'Cancel';$statusColor = 'info';};
                        $payment_status = '<span class="badge badge-soft-'.$statusColor.' p-2">'.$statusValue.'</span>';
                        return $payment_status;
                    })
                    ->addColumn('payment_details', function($row){
                        $payment_details = $row->paymentDetails->payment_method;
                        return $payment_details;
                    })
                    ->addColumn('action', function($row){
                        $action = '
                            <ul class="list-inline hstack gap-1 mb-0">
                                <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="View">
                                    <a href="'.route('view-invoice', $row->id).'" class="btn btn-soft-dark btn-sm d-inline-block"><i class="las la-eye fs-17 align-middle"></i></a>
                                </li>
                                <li class="list-inline-item edit" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Edit">
                                    <a href="'.route('edit-invoice', $row->id).'" class="btn btn-soft-info btn-sm d-inline-block"><i class="las la-pen fs-17 align-middle"></i></a>
                                </li>
                                <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Delete">
                                    <a href="'.url('delete-invoice', $row->id).'" class="btn btn-soft-danger btn-sm d-inline-block"><i class="las la-trash fs-17 align-middle"></i></a>
                                </li>
                            </ul>
                        ';
                        return $action;
                    })
                    ->rawColumns(['client','date','created_by','payment_status','payment_details','action'])->make(true);
            }
            // End
            return view('payments.cancel-payment-details',compact('user','role','cancelInvoice'));
        } else {
            return view('error.403');
        }
    }

    // Client Invoice Payment (Stripe PaymentGateway)
    public function makeInvoicePayment(Request $request) {
        $user = Sentinel::getUser();
        if ($user->hasAccess('invoice.payment')) {
            $user_id = $user->id;
            $role = $user->roles[0]->slug;
            
            $invoice = Invoice::with('paymentDetails','product','product.product')->find($request->id);
            
            $payment_amount = $invoice->total_amount;
            $user_id = $user->id;

            // Stripe payment gateway
            \Stripe\Stripe::setApiKey(Config::get('app.STRIPE_SECRET'));
            // Create Customer First
            $customer = \Stripe\Customer::create(array(
                'name' => $user->firstname . ' ' . $user->lastname,
                'description' => 'Invoika Invoice Payment',
                'email' => $user->email,
                'source' => $request->stripeToken,
                'address' => [
                    'line1' => "",
                    'postal_code' => "",
                    'city' => "",
                    'state' => "",
                    "line2" => "",
                    'country' => "",
                ],
            ));

            if($user->country == "India") {
                try {
                    
                    $stripe = new \Stripe\StripeClient(Config::get('app.STRIPE_SECRET'));
                    $inrRate = Config::get('app.IND_CURRENCY_RATE');
                    $amount = round($payment_amount * 100);
    
                    if($invoice->discount > 0) {
                        $coupon = $stripe->coupons->create(['percent_off' => ($invoice->discount/$invoice->sub_total)*100, 'duration' => 'once']);
                    } else {
                        $coupon = $stripe->coupons->create(['percent_off' => 0.01, 'duration' => 'once']);
                    }
    
                    $tax = $stripe->taxRates->create(
                        [
                            'display_name' => 'Tax Amount',
                            'inclusive' => false,
                            'percentage' => (($invoice->tax / ($invoice->sub_total - $invoice->discount))) * 100,
                            'country' => 'US',
                            'state' => 'CA',
                            'jurisdiction' => 'US - CA',
                            'description' => 'Tax Amount',
                        ]
                    );
    
                    $items = [];
                    foreach ($invoice['product'] as $key => $value) {
                        $data = [
                            'price_data' => [
                                'currency' => 'inr',
                                'product_data' => [
                                    'name' => $value['product']['product_name'],
                                ],
                                'unit_amount' => round((($value['rate'] * $inrRate) * 100), 0),
                                ],
                                'quantity' => $value['quantity'],
                                'tax_rates' => [$tax->id],
                            ];
                            array_push($items, $data);
                    }
    
                    $checkout_session = $stripe->checkout->sessions->create([
                        'customer' => $customer,
                        'shipping_options' => [
                            [
                            'shipping_rate_data' => [
                                'type' => 'fixed_amount',
                                'fixed_amount' => ['amount' => ($invoice->shipping_charge * $inrRate) * 100, 'currency' => 'inr'],
                                'display_name' => 'Shipping Charge',
                            ],
                            ],
                        ],
                        'line_items' => [ $items ],
                        'discounts' => [[
                            'coupon' => $coupon->id,
                          ]],
                        'mode' => 'payment',
                        'billing_address_collection' => 'auto',
                        'success_url' => $this->url . '/stripe-success?session_id={CHECKOUT_SESSION_ID}&invoice_id='.$invoice->id,
                        'cancel_url' => $this->url . '/stripe-cancel',
                    ]);
    
                    $request->session()->forget('user_id');
                    session()->push('user_id',['user_id'=> $user->id]);
                    return Redirect::to($checkout_session->url);
    
                } catch(Exception $e) {
                    return redirect('client-invoice-list')->with('error', $e->getMessage());
                }
            } else {
                try {
                    $stripe = new \Stripe\StripeClient(Config::get('app.STRIPE_SECRET'));
                    $amount = round($payment_amount * 100);
    
                    if($invoice->discount > 0) {
                        $coupon = $stripe->coupons->create(['percent_off' => ($invoice->discount/$invoice->sub_total)*100, 'duration' => 'once']);
                    } else {
                        $coupon = $stripe->coupons->create(['percent_off' => 0.01, 'duration' => 'once']);
                    }

                    $tax = $stripe->taxRates->create(
                        [
                            'display_name' => 'Tax Amount',
                            'inclusive' => false,
                            'percentage' => (($invoice->tax / ($invoice->sub_total - $invoice->discount))) * 100,
                            'country' => 'US',
                            'state' => 'CA',
                            'jurisdiction' => 'US - CA',
                            'description' => 'Tax Amount',
                        ]
                    );
    
                    $items = [];
                    foreach ($invoice['product'] as $key => $value) {
                        $data = [
                            'price_data' => [
                                'currency' => 'usd',
                                'product_data' => [
                                    'name' => $value['product']['product_name'],
                                ],
                                'unit_amount' => $value['rate'] * 100,
                                ],
                                'quantity' => $value['quantity'],
                                'tax_rates' => [$tax->id],
                            ];
                            array_push($items, $data);
                    }
    
                    $checkout_session = $stripe->checkout->sessions->create([
                        'customer' => $customer,
                        'shipping_options' => [
                            [
                            'shipping_rate_data' => [
                                'type' => 'fixed_amount',
                                'fixed_amount' => ['amount' => $invoice->shipping_charge * 100, 'currency' => 'usd'],
                                'display_name' => 'Shipping Charge',
                            ],
                            ],
                        ],
                        'line_items' => [ $items ],
                        'discounts' => [[
                            'coupon' => $coupon->id,
                          ]],
                        'mode' => 'payment',
                        'billing_address_collection'=> 'auto',
                        'success_url' => $this->url . '/stripe-success?session_id={CHECKOUT_SESSION_ID}&invoice_id='.$invoice->id,
                        'cancel_url' => $this->url . '/stripe-cancel',
                    ]);
    
                    $request->session()->forget('user_id');
                    session()->push('user_id',['user_id'=> $user->id]);
                    return Redirect::to($checkout_session->url);
    
                } catch(Exception $e){
                    return redirect('client-invoice-list')->with('error', $e->getMessage());
                }
            }
        } else {
            return view('error.403');
        }
    }

    // Client Invoice Payment Success (Stripe PaymentGateway)
    public function paymentSuccess(Request $request) {
        $user = Sentinel::getUser();
        $stripe = new \Stripe\StripeClient(Config::get('app.STRIPE_SECRET'));
        $session = $stripe->checkout->sessions->retrieve($_GET['session_id']);

        $payment = $stripe->paymentIntents->retrieve($session->payment_intent);

        if($session->status == "complete") {
            $invoice = Invoice::with('paymentDetails','product','product.product')->find($request->invoice_id);
            $invoice->payment_status = 1;
            if($invoice->save()) {
                $order_id = "#INV-" . $user->id . '-' . rand(10, 999999) . time();
                $transaction_id = $stripe->charges->retrieve($payment->latest_charge);

                $invoicePaymentDetails = new InvoicePaymentDetails;
                $invoicePaymentDetails->invoice_id = $request->invoice_id;
                $invoicePaymentDetails->order_id = $order_id;
                $invoicePaymentDetails->payment_gateway = 1;
                $invoicePaymentDetails->payment_method = "Card";
                $invoicePaymentDetails->card_holder_name = $session->customer_details->name;
                $invoicePaymentDetails->amount = $invoice->total_amount;
                $invoicePaymentDetails->amount_pay_currency = "USD";
                $invoicePaymentDetails->stripe_charge_id = $payment->latest_charge;
                $invoicePaymentDetails->stripe_transaction_id = ($transaction_id->balance_transaction) ? $transaction_id->balance_transaction: '';
                $invoicePaymentDetails->status = 1;
                if($invoicePaymentDetails->save()) {
                    return redirect('client-invoice-list')->with('success', 'Payment success!');
                }
            }
        } else {
            return redirect('client-invoice-list')->with('error', 'Payment failed!');
        }
    }

    // Payment Refund (Stripe PaymentGateway)
    public function refundPayment(Request $request) {
        $user = Sentinel::getUser();
        if ($user->hasAccess('payment.list')) {
            $user_id = $user->id;
            $role = $user->roles[0]->slug;
            
            $invoice = Invoice::with('paymentDetails','product','product.product')->find($request->id);
            
            $payment_amount = $invoice->total_amount;
            $user_id = $user->id;

            try {
                $stripe = new \Stripe\StripeClient(Config::get('app.STRIPE_SECRET'));
                $amount = round($payment_amount * 100);

                $createRefund = $stripe->refunds->create([
                    'charge' => $invoice->paymentDetails->stripe_charge_id,
                ]);

                $refundPayment = $stripe->refunds->update(
                    $createRefund->id,
                    ['metadata' => ['order_id' => $invoice->paymentDetails->order_id]]
                );

                if($refundPayment->status == 'succeeded') {
                    $invoice = Invoice::with('paymentDetails','product','product.product')->find($request->id);
                    $invoice->payment_status = 2;
                    if($invoice->save()) {
                        $invoicePaymentDetails = InvoicePaymentDetails::where('invoice_id', $request->id)->first();
                        $invoicePaymentDetails->refund_amount = $payment_amount;
                        $invoicePaymentDetails->stripe_refund_id = $refundPayment->id;
                        if($invoicePaymentDetails->save()) {
                            return redirect('invoice-list')->with('success', 'Payment refunded!');
                        }
                    }
                }
            } catch(Exception $e){
                return redirect('invoice-list')->with('error', $e->getMessage());
            }
        } else {
            return view('error.403');
        }
    }
  
}
