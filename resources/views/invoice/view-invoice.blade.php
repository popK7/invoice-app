@extends('layouts.master')
@section('title') View Invoice @endsection
@section('css')

@endsection

@section('body') 
    <body> 
@endsection

    @section('content')

    @component('components.breadcrumb')
        @slot('title') Invoice @endslot
        @slot('pagetitle') View Invoice @endslot
    @endcomponent

    <div class="row justify-content-center">
        <div class="col-xxl-9">
            <div class="card" id="demo">
                    <div class="card-body">
                    <div class="row p-4">
                        <div class="col-lg-9">
                            <h3 class="fw-bold mb-4">Invoice: {{$invoiceDetails->invoice_number}} </h3>
                            <div class="row g-4">
                                <div class="col-lg-6 col-6">
                                    <p class="text-muted mb-1 text-uppercase fw-medium fs-14">Invoice No</p>
                                    <h5 class="fs-16 mb-0"><span id="invoice-no">{{$invoiceDetails->invoice_number}}</span></h5>
                                </div>
                                <!--end col-->
                                <div class="col-lg-6 col-6">
                                    <p class="text-muted mb-1 text-uppercase fw-medium fs-14">Invoice Date</p>
                                    <h5 class="fs-16 mb-0"><span id="invoice-date"><?php echo date('d M, Y',strtotime($invoiceDetails->date));?></span> </h5>
                                </div>
                                <!--end col-->
                                <?php 
                                    $statusValue = ""; $statusColor = "";
                                    if($invoiceDetails->payment_status == 0) { $statusValue = 'Unpaid';$statusColor = 'danger';};
                                    if($invoiceDetails->payment_status == 1) { $statusValue = 'Paid';$statusColor = 'success';};
                                    if($invoiceDetails->payment_status == 2) { $statusValue = 'Refund';$statusColor = 'warning';};
                                    if($invoiceDetails->payment_status == 3) { $statusValue = 'Cancel';$statusColor = 'info';};
                                ?>
                                <div class="col-lg-6 col-6">
                                    <p class="text-muted mb-1 text-uppercase fw-medium fs-14">Payment Status</p>
                                    <span class="badge badge-soft-{{$statusColor}} fs-11" id="payment-status">{{$statusValue}}</span>
                                </div>
                                <!--end col-->
                                <div class="col-lg-6 col-6">
                                    <p class="text-muted mb-1 text-uppercase fw-medium fs-14">Total Amount</p>
                                    <h5 class="fs-16 mb-0"><span id="total-amount">{{$invoiceDetails->product[0]->currency_type}}{{$invoiceDetails->total_amount}}</span></h5>
                                </div>
                                <!--end col-->

                                <?php if($invoiceDetails->payment_status == 1) { ?>
                                    <div class="col-lg-6 col-6">
                                        <p class="text-muted mb-1 text-uppercase fw-medium fs-14">Payment Date</p>
                                        <h5 class="fs-16 mb-0"><span><?php echo date('d M, Y',strtotime($invoiceDetails->paymentDetails->created_at));?></span> </h5>
                                    </div>
                                    <!--end col-->
                                    <div class="col-lg-6 col-6">
                                        <p class="text-muted mb-1 text-uppercase fw-medium fs-14">Transaction Id</p>
                                        <h5 class="fs-16 mb-0"><span></span> {{$invoiceDetails->paymentDetails->stripe_transaction_id}} </h5>
                                    </div>
                                    <!--end col-->
                                <?php } ?>

                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="mt-sm-0 mt-3">
                                <div class="">
                                    <img src="{{URL::asset('/assets/images/logo/'.$invoiceDetails->company->logo)}}" class="card-logo card-logo-dark" alt="logo dark" height="100">
                                    <img src="{{URL::asset('/assets/images/logo/'.$invoiceDetails->company->logo)}}" class="card-logo card-logo-light" alt="logo light" height="100">
                                </div>
                                <h6 class="text-muted text-uppercase fw-semibold">Address</h6>
                                <p class="text-muted mb-1" id="address-details">{{$invoiceDetails->company->address}}</p>
                                <p class="text-muted mb-1" id="zip-code"><span>Zip-code:</span> {{$invoiceDetails->company->postalcode}}</p>
                                <h6><span class="text-muted fw-normal">Email:</span><span id="email">{{$invoiceDetails->company->email}}</span></h6>
                                <h6><span class="text-muted fw-normal">Website:</span> <a href="{{$invoiceDetails->company->website}}" class="link-primary" target="_blank" id="website">{{$invoiceDetails->company->website}}</a></h6>
                                <h6 class="mb-0"><span class="text-muted fw-normal">Contact No: </span><span id="contact-no"> {{$invoiceDetails->company->mobile_number}}</span></h6>
                            </div>
                        </div>
                    </div><!--end col-->

                    <div class="row p-4 border-top border-top-dashed">
                        <div class="col-lg-9">
                            <div class="row g-3">
                                <div class="col-6">
                                    <h6 class="text-muted text-uppercase fw-semibold mb-3">Billing Address</h6>
                                    <p class="fw-medium mb-2" id="billing-name">{{$invoiceDetails->shippling_full_name}}</p>
                                    <p class="text-muted mb-1" id="billing-address-line-1">{{$invoiceDetails->shippling_address}}</p>
                                    <p class="text-muted mb-1"><span>Phone: +</span><span id="billing-phone-no">{{$invoiceDetails->shippling_mobile_number}}</span></p>
                                    <p class="text-muted mb-0"><span>Tax: </span><span id="billing-tax-no">{{$invoiceDetails->shippling_tax_number}}</span> </p>
                                </div>
                                <!--end col-->
                                <div class="col-6">
                                    <h6 class="text-muted text-uppercase fw-semibold mb-3">Shipping Address</h6>
                                    <p class="fw-medium mb-2" id="shipping-name">{{$invoiceDetails->billing_full_name}}</p>
                                    <p class="text-muted mb-1" id="shipping-address-line-1">{{$invoiceDetails->billing_address}}</p>
                                    <p class="text-muted mb-1"><span>Phone: +</span><span id="shipping-phone-no">{{$invoiceDetails->billing_mobile_number}}</span></p>
                                </div>
                                <!--end col-->
                            </div>
                            <!--end row-->
                        </div><!--end col-->

                        <div class="col-lg-3">
                            <h6 class="text-muted text-uppercase fw-semibold mb-3">Total Amount</h6>
                            <h3 class="fw-bold mb-2">{{$invoiceDetails->product[0]->currency_type}}{{$invoiceDetails->total_amount}}</h3>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card-body p-4">
                                <div class="table-responsive">
                                    <table class="table table-borderless text-center table-nowrap align-middle mb-0">
                                        <thead>
                                            <tr class="table-active">
                                                <th scope="col" style="width: 50px;">#</th>
                                                <th scope="col">Product Details</th>
                                                <th scope="col">Rate</th>
                                                <th scope="col">Quantity</th>
                                                <th scope="col" class="text-end">Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody id="products-list">
                                            <?php $i = 0; ?>
                                            @foreach($invoiceDetails->product as $key => $product)
                                                <?php $i++; ?>
                                                <tr>
                                                    <th scope="row">{{$i}}</th>
                                                    <td class="text-start">
                                                        <span class="fw-medium">{{$product->product->product_name}}</span>
                                                        <p class="text-muted mb-0">{{$product->product->description}}</p>
                                                    </td>
                                                    <td>{{$product->currency_type}}{{$product->rate}}</td>
                                                    <td>{{$product->quantity}}</td>
                                                    <td class="text-end">{{$product->currency_type}}{{$product->amount}}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table><!--end table-->
                                </div>
                                <div class="border-top border-top-dashed mt-2">
                                    <table class="table table-borderless table-nowrap align-middle mb-0 ms-auto" style="width:250px">
                                        <tbody>
                                            <tr>
                                                <td>Sub Total</td>
                                                <td class="text-end">{{$invoiceDetails->product[0]->currency_type}}{{$invoiceDetails->sub_total}}</td>
                                            </tr>
                                            <?php if($invoiceDetails->discount == 0) { $discount = 1;} else { $discount = $invoiceDetails->discount; } ?>
                                            <tr>
                                                <td>Discount ({{$invoiceDetails->sub_total / $discount}})%</td>
                                                <td class="text-end">- {{$invoiceDetails->product[0]->currency_type}}{{$invoiceDetails->discount}}</td>
                                            </tr>
                                            <tr>
                                                <td>Tax ({{((($invoiceDetails->tax) / ($invoiceDetails->sub_total - $invoiceDetails->discount))) * 100}})%</td>
                                                <td class="text-end">{{$invoiceDetails->product[0]->currency_type}}{{$invoiceDetails->tax}}</td>
                                            </tr>
                                            <tr>
                                                <td>Shipping Charge</td>
                                                <td class="text-end">{{$invoiceDetails->product[0]->currency_type}}{{$invoiceDetails->shipping_charge}}</td>
                                            </tr>
                                            <tr class="border-top border-top-dashed fs-15">
                                                <th scope="row">Total Amount</th>
                                                <th class="text-end">{{$invoiceDetails->product[0]->currency_type}}{{$invoiceDetails->total_amount}}</th>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <!--end table-->
                                </div>
                                <div class="mt-3">
                                    <h6 class="text-muted text-uppercase fw-semibold mb-3">Payment Details:</h6>
                                    <p class="text-muted mb-1">Payment Method: <span class="fw-medium" id="payment-method">{{@$invoiceDetails->paymentDetails->payment_method}}</span></p>
                                    <p class="text-muted mb-1">Card Holder: <span class="fw-medium" id="card-holder-name">{{@$invoiceDetails->paymentDetails->card_holder_name}}</span></p>
                                    {{-- <p class="text-muted mb-1">Card Number: <span class="fw-medium" id="card-number">xxx xxxx xxxx 1234</span></p> --}}
                                    <p class="text-muted">Total Amount: <span class="fw-medium" id=""></span><span id="card-total-amount">{{$invoiceDetails->product[0]->currency_type}}{{$invoiceDetails->total_amount}}</span></p>
                                </div>
                                <div class="mt-4">
                                    <div class="alert alert-info">
                                        <p class="mb-0"><span class="fw-semibold">NOTES:</span>
                                            <span id="note">All accounts are to be paid within 7 days from receipt of invoice. To be paid by cheque or
                                                credit card or direct payment online. If account is not paid within 7
                                                days the credits details supplied as confirmation of work undertaken
                                                will be charged the agreed quoted fee noted above.
                                            </span>
                                        </p>
                                    </div>
                                </div>
                                <div class="hstack gap-2 justify-content-end d-print-none mt-4">
                                    <a href="javascript:window.print()" class="btn btn-info"><i class="ri-printer-line align-bottom me-1"></i> Print</a>
                                </div>
                            </div>
                            <!--end card-body-->
                        </div><!--end col-->
                    </div>
                    </div>
            </div>
        </div>
        <!--end col-->
    </div>

    @endsection
    @section('scripts')
    
    @endsection