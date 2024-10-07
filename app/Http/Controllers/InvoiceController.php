<?php

namespace App\Http\Controllers;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Support\Facades\Mail;
use Yajra\DataTables\DataTables;
Use PDF;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\CompanyDetails;
use App\Models\Products;
use App\Models\Invoice;
use App\Models\InvoicePaymentDetails;
use App\Models\InvoiceProducts;
use App\Models\Tax;
use App\Models\ShippingCharge;
use App\Models\Discount;
use App\Models\Notification;

class InvoiceController extends Controller
{
    // List of invoices
    public function invoiceList(Request $request) {
        $user = Sentinel::getUser();
        if ($user->hasAccess('invoice.list')) {
            $user_id = $user->id;
            $role = $user->roles[0]->slug;
            $invoices = Invoice::with('company','user')->where('is_deleted',0)->get();
            $sentInvoices = Invoice::where('is_deleted',0)->pluck('total_amount')->toArray();
            $paidInvoices = Invoice::where('payment_status',1)->where('is_deleted',0)->pluck('total_amount')->toArray();
            $pendingInvoices = Invoice::where('payment_status',0)->where('is_deleted',0)->pluck('total_amount')->toArray();
            $cancelInvoices = Invoice::where('payment_status',3)->where('is_deleted',0)->pluck('total_amount')->toArray();
            $totalAmountOfSentInvoices = array_sum($sentInvoices);
            $totalAmountOfPaidInvoices = array_sum($paidInvoices);
            $totalAmountOfPendingInvoices = array_sum($pendingInvoices);
            $totalAmountOfCancelInvoices = array_sum($cancelInvoices);
            
            // Load Yajra Datatable
            if ($request->ajax()) {
                return Datatables::of($invoices)
                    ->addIndexColumn()
                    ->addColumn('client_id', function($row) {
                        $client_id = $row->client->first_name.' '.$row->client->last_name;
                        return $client_id;
                    })
                    ->addColumn('created_by', function($row) {
                        $created_by = $row->user->first_name.' '.$row->user->last_name;
                        return $created_by;
                    })
                    ->addColumn('payment_status', function($row) {
                        if($row->payment_status == 0) { $statusValue = 'Unpaid';$statusColor = 'danger';};
                        if($row->payment_status == 1) { $statusValue = 'Paid';$statusColor = 'success';};
                        if($row->payment_status == 2) { $statusValue = 'Refund';$statusColor = 'warning';};
                        if($row->payment_status == 3) { $statusValue = 'Cancel';$statusColor = 'info';};
                        $payment_status = '<span class="badge badge-soft-'.$statusColor.' p-2">'.$statusValue.'</span>';
                        return $payment_status;
                    })
                    ->addColumn('action', function($row) {
                        $action = '
                            <ul class="list-inline hstack gap-1 mb-0">
                                <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="View">
                                    <a href="'.route('view-invoice', $row->id).'" class="btn btn-soft-dark btn-sm d-inline-block"><i class="las la-eye fs-17 align-middle"></i></a>
                                </li>';
                                if($row->payment_status == 0) { 
                                    $action .=
                                    '<li class="list-inline-item edit" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Edit">
                                        <a href="'.route('edit-invoice', $row->id).'" class="btn btn-soft-info btn-sm d-inline-block"><i class="las la-pen fs-17 align-middle"></i></a>
                                    </li>
                                '; } 
                                if($row->payment_status == 1) { 
                                    $action .=
                                    '<li class="list-inline-item refund" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Refund">
                                        <button type="button" class="btn btn-soft-warning btn-sm d-inline-block" onclick="callModal('.$row->id.')"><i class="las la-share fs-17 align-middle"></i>
                                        </button>
                                    </li>
                                '; } 
                                $action .= '
                                <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Remove">
                                    <button type="button" onclick="callConfirmationModal('.$row->id.')" class="btn btn-soft-danger btn-sm d-inline-block"><i class="las la-trash fs-17 align-middle"></i></a>
                                </li>
                            </ul>
                        ';
                        return $action;
                    })
                    ->rawColumns(['client_id','created_by','payment_status','action'])->make(true);
            }
            // End

            return view('invoice.invoice-list',compact('user','role','invoices','totalAmountOfSentInvoices','totalAmountOfPaidInvoices','totalAmountOfPendingInvoices','totalAmountOfCancelInvoices','sentInvoices','paidInvoices','pendingInvoices','cancelInvoices'));
        } else {
            return view('error.403');
        }
    }

    // List of client invoices
    public function clientInvoiceList(Request $request) {
        $user = Sentinel::getUser();
        if ($user->hasAccess('client_invoice.list')) {
            $user_id = $user->id;
            $role = $user->roles[0]->slug;
            $invoices = Invoice::with('company','user')->where('client_id',$user->id)->where('is_deleted',0)->get();
            $sentInvoices = Invoice::where('client_id',$user->id)->where('is_deleted',0)->pluck('total_amount')->toArray();
            $paidInvoices = Invoice::where('payment_status',1)->where('client_id',$user->id)->where('is_deleted',0)->pluck('total_amount')->toArray();
            $pendingInvoices = Invoice::where('payment_status',0)->where('client_id',$user->id)->where('is_deleted',0)->pluck('total_amount')->toArray();
            $cancelInvoices = Invoice::where('payment_status',3)->where('client_id',$user->id)->where('is_deleted',0)->pluck('total_amount')->toArray();
            $totalAmountOfSentInvoices = array_sum($sentInvoices);
            $totalAmountOfPaidInvoices = array_sum($paidInvoices);
            $totalAmountOfPendingInvoices = array_sum($pendingInvoices);
            $totalAmountOfCancelInvoices = array_sum($cancelInvoices);
            
            // Load Yajra Datatable
            if ($request->ajax()) {
                return Datatables::of($invoices)
                    ->addIndexColumn()
                    ->addColumn('client_id', function($row) {
                        $client_id = $row->client->first_name.' '.$row->client->last_name;
                        return $client_id;
                    })
                    ->addColumn('created_by', function($row) {
                        $created_by = $row->user->first_name.' '.$row->user->last_name;
                        return $created_by;
                    })
                    ->addColumn('payment_status', function($row) {
                        if($row->payment_status == 0) { $statusValue = 'Unpaid';$statusColor = 'danger';};
                        if($row->payment_status == 1) { $statusValue = 'Paid';$statusColor = 'success';};
                        if($row->payment_status == 2) { $statusValue = 'Refund';$statusColor = 'warning';};
                        if($row->payment_status == 3) { $statusValue = 'Cancel';$statusColor = 'info';};
                        $payment_status = '<span class="badge badge-soft-'.$statusColor.' p-2">'.$statusValue.'</span>';
                        return $payment_status;
                    })
                    // <script src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                    //     data-key="pk_test_51M1obNSGWeR7PC0R3ztX27pYp058I8oUWWy4luMcI4zTElceDry8sUmeS0pjhfAZsSilzsgbX5hjGPsq6tuXPK6600OMO4Hytk" data-name="Invoika" data-amount="'.($row->total_amount * 100).'"
                    //     data-description="Stripe payment with Invoika" data-label="Pay via Stripe"
                    //     data-image="/assets/images/logo-sm.png" data-locale="auto"
                    //     data-billing-address="false" data-shipping-address="false" data-currency="usd">
                    // </script>
                    ->addColumn('action', function($row) {
                        $htmlVar = "";
                        if($row->payment_status == 0) { 
                            $htmlVar = '<ul class="list-inline hstack gap-1 mb-0">
                                            <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="View">
                                                <a href="'.route('view-invoice', $row->id).'" class="btn btn-soft-dark btn-sm d-inline-block"><i class="las la-eye fs-17 align-middle"></i></a>
                                            </li>

                                            <form action="'.url('make-invoice-payment', $row->id).'" method="post" id="stripePaymentGateway">
                                                <input type="hidden" name="_token" value="'.csrf_token().'">
                                                <button type="submit" class="btn btn-soft-info btn-sm d-inline-block">Pay via stripe</button>
                                            </form>
                                        </ul>';
                        } else {
                            $htmlVar = '<ul class="list-inline hstack gap-1 mb-0">
                                            <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="View">
                                                <a href="'.route('view-invoice', $row->id).'" class="btn btn-soft-dark btn-sm d-inline-block"><i class="las la-eye fs-17 align-middle"></i></a>
                                            </li>
                                        </ul>';
                        }

                        $action = $htmlVar;
                        return $action;
                    })
                    ->rawColumns(['client_id','created_by','payment_status','action'])->make(true);
            }
            // End

            return view('invoice.client-invoice-list',compact('user','role','invoices','totalAmountOfSentInvoices','totalAmountOfPaidInvoices','totalAmountOfPendingInvoices','totalAmountOfCancelInvoices','sentInvoices','paidInvoices','pendingInvoices','cancelInvoices'));
        } else {
            return view('error.403');
        }
    }

    // Add invoice view
    public function addInvoiceView() {
        $user = Sentinel::getUser();
        if ($user->hasAccess('invoice.add')) {
            $user_id = $user->id;
            $role = $user->roles[0]->slug;
            $products = Products::where('is_deleted',0)->get();
            $companyDetails = CompanyDetails::where('status',1)->first();
            $tax = Tax::where('status',1)->first();
            $discount = Discount::where('status',1)->first();
            $shippingCharge = ShippingCharge::where('status',1)->first();

            $client_role = Sentinel::findRoleBySlug('client');
            $clientList = $client_role->users()->with('roles')->get();
            if(is_null($companyDetails)) {
                return redirect('company-list')->with('error', 'First add/active your company details!!!');
            } else {
                return view('invoice.add-invoice',compact('user','role','products','companyDetails','clientList','tax','discount','shippingCharge'));
            }
        } else {
            return view('error.403');
        }
    }

    // Add new invoice
    public function addInvoice(Request $request) {

        $user = Sentinel::getUser();
        if ($user->hasAccess('invoice.add')) {
            $validatedData = $request->validate([
                'date' => 'required',
                'client_id' => 'required',
                'payment_status' => 'required',
                'billing_full_name' => 'required',
                'billing_address' => 'required',
                'billing_mobile_number' => 'required|max:15',
                'shippling_full_name' => 'required',
                'shippling_address' => 'required',
                'shippling_mobile_number' => 'required',
                'currency_type' => 'required',
                "product" => 'required',
                // "quantity" => 'required|numeric|gt:0',
            ]);

            foreach ($request->quantity as $key => $value) {
                if($value == 0) {
                    return back()->with('error', 'Quantity can not be 0');
                }
            }

            // Add invoice
            $invoice = new Invoice();
            $invoice->client_id = $request->client_id;
            $invoice->invoice_number = $request->invoice_number;
            $invoice->date = date('Y-m-d', strtotime($request->date));
            $invoice->payment_status = $request->payment_status;
            $invoice->company_id = $request->company_id;
            $invoice->billing_full_name = $request->billing_full_name;
            $invoice->billing_address = $request->billing_address;
            $invoice->billing_mobile_number = $request->billing_mobile_number;
            $invoice->billing_tax_number = $request->billing_tax_number;
            $invoice->is_billing_shippling_add_same = ($request->is_billing_shippling_add_same == 'on') ? 1 : 0;
            $invoice->shippling_full_name = $request->shippling_full_name;
            $invoice->shippling_address = $request->shippling_address;
            $invoice->shippling_mobile_number = $request->shippling_mobile_number;
            $invoice->shippling_tax_number = $request->shippling_tax_number;

            $sub_total = explode($request->currency_type,$request->sub_total);
            $tax = explode($request->currency_type,$request->tax);
            $discount = explode($request->currency_type,$request->discount);
            $shipping_charge = explode($request->currency_type,$request->shipping_charge);
            $total_amount = explode($request->currency_type,$request->total_amount);

            $invoice->sub_total = $sub_total[1];
            $invoice->tax = $tax[1];
            $invoice->discount = $discount[1];
            $invoice->shipping_charge = $shipping_charge[1];
            $invoice->total_amount = $total_amount[1];

            $invoice->created_by = $user->id;

            if($invoice->save()) {
                // Add payment details
                if($invoice->payment_status == 1) {
                    $invoicePaymentDetails = new InvoicePaymentDetails();
                    $invoicePaymentDetails->invoice_id = $invoice->id;
                    $invoicePaymentDetails->payment_method = $request->payment_method;
                    $invoicePaymentDetails->card_holder_name = $request->card_holder_name;
                    $invoicePaymentDetails->card_number =  str_replace(' ','',$request->card_number);
                    $invoicePaymentDetails->save();
                }

                foreach ($request->product as $key => $value) {
                    // Add product details
                    $invoiceProducts = new InvoiceProducts();
                    $invoiceProducts->invoice_id = $invoice->id;
                    $invoiceProducts->product_id = $value;
                    $invoiceProducts->currency_type = $request->currency_type;
                    $invoiceProducts->rate = $request->rate[$key];
                    $invoiceProducts->quantity = $request->quantity[$key];
                    $amount = explode($request->currency_type,$request->amount[$key]);
                    $invoiceProducts->amount = $amount[1];
                    $invoiceProducts->save();
                }

                if($invoice->id) {
                    // Send Notification
                    $admin_role = Sentinel::findRoleBySlug('admin');
                    $admin_id = $admin_role->users()->with('roles')->pluck('id');
                    $fromId = collect();
                    $fromId->push($admin_id);
                    $from_id =  $fromId->flatten();
                    foreach ($from_id as $item) {
                        if($user->id != $item) {
                            $notification = new Notification();
                            $notification->to_user = $item;
                            $notification->notification_type_id = 2;
                            $notification->title = "New Invoice Created";
                            $notification->data = "has created new invoice";
                            $notification->from_user = $user->id;
                            $notification->save();
                        }
                    }

                    $app_name =  config('app.name');
                    $app_url = config('app.url');
                    $clietEmail = User::where('id', $request->client_id)->first();
                    $clietEmail = $clietEmail->email;
                    
                    Mail::send('emails.new-invoice-created', ['app_url' => $app_url], function ($message) use ($clietEmail,$app_name) {
                        $message->to($clietEmail)->subject('New Invoice Created - '.$app_name);
                    });
                    
                    return redirect('invoice-list')->with('success', 'Invoice created successfully!!!');
                } else {
                    return redirect('invoice-list')->with('error', 'Failed to add!!!');
                }
            }
        } else {
            return view('error.403');
        }
    }

    // View invoices
    public function viewInvoice(Request $request) {
        $user = Sentinel::getUser();
        if ($user->hasAccess('invoice.view')) {
            $user_id = $user->id;
            $role = $user->roles[0]->slug;
            $invoiceDetails = Invoice::with('paymentDetails','product')->find($request->id);
            $tax = Tax::where('status',1)->first();
            $discount = Discount::where('status',1)->first();
            $shippingCharge = ShippingCharge::where('status',1)->first();

            return view('invoice.view-invoice',compact('user','role','invoiceDetails','tax','discount','shippingCharge'));
        } else {
            return view('error.403');
        }
    }

    // Edit invoice view
    public function editInvoice(Request $request) {
        $user = Sentinel::getUser();
        if ($user->hasAccess('invoice.edit')) {
            $user_id = $user->id;
            $role = $user->roles[0]->slug;
            $products = Products::where('is_deleted',0)->get();

            $client_role = Sentinel::findRoleBySlug('client');
            $clientList = $client_role->users()->with('roles')->get();
            $invoiceDetails = Invoice::with('paymentDetails','product')->find($request->id);
            $currencyType = InvoiceProducts::where('invoice_id',$request->id)->first();
            $companyDetails = CompanyDetails::where('id',$invoiceDetails->company_id)->first();

            $tax = Tax::where('status',1)->first();
            $discount = Discount::where('status',1)->first();
            $shippingCharge = ShippingCharge::where('status',1)->first();

            if(is_null($companyDetails)) {
                return redirect('company-list')->with('error', 'First add/active your company details!!!');
            } else {
                return view('invoice.edit-invoice',compact('user','role','products','invoiceDetails','companyDetails','clientList','currencyType','tax','discount','shippingCharge'));
            }
        } else {
            return view('error.403');
        }
    }

    // Update invoice
    public function updateInvoice(Request $request) {
        $user = Sentinel::getUser();
        if ($user->hasAccess('invoice.add')) {
            $validatedData = $request->validate([
                'date' => 'required',
                'client_id' => 'required',
                'payment_status' => 'required',
                'billing_full_name' => 'required',
                'billing_address' => 'required',
                'billing_mobile_number' => 'required',
                'shippling_full_name' => 'required',
                'shippling_address' => 'required',
                'shippling_mobile_number' => 'required',
                'currency_type' => 'required',
                "product" => 'required',
                "quantity" => 'required',
            ]);

            // Update invoice
            $invoice = Invoice::find($request->invoice_id);
            $invoice->client_id = $request->client_id;
            $invoice->date = date('Y-m-d', strtotime($request->date));
            $invoice->payment_status = $request->payment_status;
            $invoice->company_id = $request->company_id;
            $invoice->billing_full_name = $request->billing_full_name;
            $invoice->billing_address = $request->billing_address;
            $invoice->billing_mobile_number = $request->billing_mobile_number;
            $invoice->billing_tax_number = $request->billing_tax_number;
            $invoice->is_billing_shippling_add_same = ($request->is_billing_shippling_add_same == 'on') ? 1 : 0;
            $invoice->shippling_full_name = $request->shippling_full_name;
            $invoice->shippling_address = $request->shippling_address;
            $invoice->shippling_mobile_number = $request->shippling_mobile_number;
            $invoice->shippling_tax_number = $request->shippling_tax_number;
            
            $sub_total = explode($request->currency_type,$request->sub_total);
            $tax = explode($request->currency_type,$request->tax);
            $discount = explode($request->currency_type,$request->discount);
            $shipping_charge = explode($request->currency_type,$request->shipping_charge);
            $total_amount = explode($request->currency_type,$request->total_amount);
            
            $invoice->sub_total = $sub_total[1];
            $invoice->tax = $tax[1];
            $invoice->discount = $discount[1];
            $invoice->shipping_charge = $shipping_charge[1];
            $invoice->total_amount = $total_amount[1];

            if($invoice->save()) {
                // Add payment details
                if($invoice->payment_status == 1) {
                    $invoicePaymentDetails = new InvoicePaymentDetails();
                    $invoicePaymentDetails->invoice_id = $invoice->id;
                    $invoicePaymentDetails->payment_method = $request->payment_method;
                    $invoicePaymentDetails->card_holder_name = $request->card_holder_name;
                    $invoicePaymentDetails->card_number =  str_replace(' ','',$request->card_number);
                    $invoicePaymentDetails->save();
                }

                //Delete product details
                InvoiceProducts::where('invoice_id',$request->invoice_id)->delete();
                foreach ($request->product as $key => $value) {
                    // Add product details
                    $invoiceProducts = new InvoiceProducts();
                    $invoiceProducts->invoice_id = $invoice->id;
                    $invoiceProducts->product_id = $value;
                    $invoiceProducts->currency_type = $request->currency_type;
                    $invoiceProducts->rate = $request->rate[$key];
                    $invoiceProducts->quantity = $request->quantity[$key];
                    $invoiceProducts->amount = $request->amount[$key];
                    $invoiceProducts->save();
                }

                if($invoice->id) {
                    // Send Notification
                    $admin_role = Sentinel::findRoleBySlug('admin');
                    $admin_id = $admin_role->users()->with('roles')->pluck('id');
                    $fromId = collect();
                    $fromId->push($admin_id);
                    $from_id =  $fromId->flatten();
                    foreach ($from_id as $item) {
                        if($user->id != $item) {
                            $notification = new Notification();
                            $notification->to_user = $item;
                            $notification->notification_type_id = 2;
                            $notification->title = "Invoice Updated";
                            $notification->data = "has updated invoice";
                            $notification->from_user = $user->id;
                            $notification->save();
                        }
                    }
                    return redirect('invoice-list')->with('success', 'Invoice updated successfully!!!');
                } else {
                    return redirect('invoice-list')->with('error', 'Failed to add!!!');
                }
            }
        } else {
            return view('error.403');
        }
    }

    // Delete invoice
    public function deleteInvoice(Request $request) {
        $user = Sentinel::getUser();
        if ($user->hasAccess('invoice.delete')) {
            try {
                $id = $request->id;
                $invoice = Invoice::find($id);
                ($invoice->is_deleted == 0) ? $is_deleted = 1 : $is_deleted = 0;
                $invoice->is_deleted = $is_deleted;
                if($invoice->save()) {
                    return redirect('invoice-list')->with('success','Invoice deleted successfully');
                }
            } catch (Exception $e) {
                return redirect('invoice-list')->with('error', 'Something went wrong!!! ' . $e->getMessage());
            }
        } else {
            return view('error.403');
        }
    }

    // Get Product description
    public function getDescription(Request $request) {
        $user = Sentinel::getUser();
        if ($user->hasAccess('invoice.add')) {
            $user_id = $user->id;
            $role = $user->roles[0]->slug;
            $productDescription = Products::where('id',$request->productId)->first();
            return $productDescription;
        } else {
            return view('error.403');
        }
    }

    // Download invoice
    public function downloadInvoice(Request $request) {
        $user = Sentinel::getUser();
        $userData = User::where('id',$user->id)->first();
        if ($user->hasAccess('invoice.view')) {
            $user_id = $user->id;
            $role = $user->roles[0]->slug;
            $invoiceDetails = Invoice::with('paymentDetails','product','company')->where('id',$request->id)->first()->toArray();
            $pdf = PDF::loadView('invoice.download-invoice',['user' => $userData, 'role' => $role, 'invoiceDetails' => $invoiceDetails])->setOptions(['defaultFont' => 'sans-serif', 'isRemoteEnabled' => true])->setBasePath(public_path());
            
            return $pdf->stream('invoice.pdf');
        } else {
            return view('error.403');
        }
    }
}
