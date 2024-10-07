@extends('layouts.master')
@section('title') Invoice List @endsection
@section('css')
<script src="{{URL::asset('assets/js/jquery-3.6.4.min.js')}}"></script>
<script>
    function getProductDescription(productId, rowId) {
        var token = $("input[name='_token']").val();
        var splitRowId = rowId.split("-");
        $.ajax({
            type: 'post'
            , url: '{{url("get-description")}}'
            , dataType: 'json'
            , data: {
                'productId': productId
                , '_token': token
            }
            , success: function(data) {
                $('#productDetails-' + splitRowId[1]).val(data.description);
                $('#productRate-' + splitRowId[1]).val(data.price);
            }
            , error: function(data) {
                $('#productDetails-' + splitRowId[1]).val('');
                $('#productRate-' + splitRowId[1]).val(0);
                alert('oops! Something Went Wrong!!!');
            }
        });
    };

</script>
@endsection

@section('body')
<body>
    @endsection

    @section('content')

    @component('components.breadcrumb')
    @slot('title') Invoice @endslot
    @slot('pagetitle') Edit Invoice @endslot
    @endcomponent

    <div class="row justify-content-center">
        <div class="col-xxl-9">
            <div class="card">
                <form method="POST" action="{{url('update-invoice')}}" class="needs-validation" novalidate id="invoice_form">
                    @csrf
                    <div class="card-body border-bottom border-bottom-dashed p-4">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="row g-3">
                                    <div class="col-lg-8 col-sm-6">
                                        <label for="editInvoicenoInput">Invoice No</label>
                                        <input type="text" class="form-control bg-light border-0" id="editInvoicenoInput" placeholder="Invoice No" name="invoice_number" value="{{$invoiceDetails->invoice_number}}" readonly="readonly">
                                        <input type="hidden" id="invoice_slug" value="{{$companyDetails->invoice_slug}}">
                                        <input type="hidden" id="invoice_id" name="invoice_id" value="{{request()->route('id')}}">
                                    </div>
                                    <!--end col-->
                                    <div class="col-lg-8 col-sm-6">
                                        <label for="choices-client">Select Client</label>
                                        <div class="input-light">
                                            <select class="form-control bg-light border-0 @error('client_id') is-invalid @enderror" name="client_id" data-choices data-choices-search-false id="choices-client" required>
                                                <option value="">Select Client</option>
                                                @foreach($clientList as $key => $value)
                                                <option value="{{$value->id}}" @if($invoiceDetails->client_id) {{'selected'}} @endif>{{$value->first_name.' '.$value->last_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        @error('client_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <!--end col-->
                                    <div class="col-lg-8 col-sm-6">
                                        <div>
                                            <label for="date">Date</label>
                                            <input type="text" class="form-control bg-light border-0 flatpickr-input @error('date') is-invalid @enderror" id="date" name="date" data-provider="flatpickr" value="{{$invoiceDetails->date}}" data-time="true" placeholder="Select Date-time" readonly="readonly">
                                        </div>

                                        @error('date')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <!--end col-->
                                    <div class="col-lg-8 col-sm-6">
                                        <label for="choices-payment-status">Payment Status</label>
                                        <input type="hidden" id="payment_status" value="{{$invoiceDetails->payment_status}}">
                                        <div class="input-light">
                                            <select class="form-control bg-light border-0 @error('payment_status') is-invalid @enderror" name="payment_status" data-choices data-choices-search-false id="choices-payment-status" required>
                                                <option value="">Select Payment Status</option>
                                                <option value="0" @if($invoiceDetails->payment_status == 0) {{'selected'}} @endif>Unpaid</option>
                                                <option value="3" @if($invoiceDetails->payment_status == 3) {{'selected'}} @endif>Cancel</option>
                                            </select>
                                        </div>

                                        @error('payment_status')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <!--end col-->
                                    <div class="col-lg-8 col-sm-6">
                                        <div>
                                            <label for="totalamountInput">Total Amount</label>
                                            <input type="text" class="form-control bg-light border-0" id="totalamountInput" placeholder="$0.00" readonly="" value="{{$invoiceDetails->product[0]->currency_type}}{{$invoiceDetails->total_amount}}">
                                        </div>
                                    </div>
                                    <!--end col-->
                                </div>

                            </div>
                            <!--end col-->
                            <div class="col-lg-4 ms-auto">
                                <div class="profile-user mx-auto  mb-3">
                                    <input id="profile-img-file-input" type="" class="profile-img-file-input" />
                                    <label for="profile-img-file-input" class="d-block" tabindex="0">
                                        <span class="overflow-hidden border border-dashed d-flex align-items-center justify-content-center rounded" style="height: 60px; width: 256px;">
                                            <img src="{{URL::asset('/assets/images/logo/'.$companyDetails->logo)}}" class="card-logo card-logo-dark user-profile-image img-fluid" alt="logo dark">
                                            <img src="{{URL::asset('/assets/images/logo/'.$companyDetails->logo)}}" class="card-logo card-logo-light user-profile-image img-fluid" alt="logo light">
                                        </span>
                                    </label>
                                </div>


                                <div>
                                    <label for="companyAddress">Address</label>
                                </div>
                                <div class="mb-2">
                                    <input type="hidden" name="company_id" value="{{$companyDetails->id}}">
                                    <textarea class="form-control bg-light border-0" id="companyAddress" rows="3" placeholder="Company Address" required="" readonly>{{$companyDetails->address}}</textarea>
                                    <div class="invalid-feedback">
                                        Please enter a address
                                    </div>
                                </div>
                                <div class="mb-2">
                                    <label for="companyaddpostalcode">Postal Code</label>
                                    <input type="text" class="form-control bg-light border-0" id="companyaddpostalcode" minlength="5" maxlength="6" placeholder="Enter Postal Code" required="" readonly value="{{$companyDetails->postalcode}}">
                                    <div class="invalid-feedback">
                                        The US zip code must contain 5 digits, Ex. 45678
                                    </div>
                                </div>

                                <div class="mb-2">
                                    <label for="companyEmail">Email</label>
                                    <input type="email" class="form-control bg-light border-0" id="companyEmail" placeholder="Email Address" required readonly value="{{$companyDetails->email}}" />
                                    <div class="invalid-feedback">
                                        Please enter a valid email, Ex., example@gamil.com
                                    </div>
                                </div>
                                <div class="mb-2">
                                    <label for="companyWebsite">Website</label>
                                    <input type="text" class="form-control bg-light border-0" id="companyWebsite" placeholder="Website" required readonly value="{{$companyDetails->website}}" />
                                    <div class="invalid-feedback">
                                        Please enter a website, Ex., www.example.com
                                    </div>
                                </div>
                                <div>
                                    <label for="compnayContactno">Contact No</label>
                                    <input type="text" class="form-control bg-light border-0" data-plugin="cleave-phone" id="compnayContactno" placeholder="Contact No" required readonly value="{{$companyDetails->mobile_number}}" />
                                    <div class="invalid-feedback">
                                        Please enter a contact number
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--end row-->
                    </div>
                    <div class="card-body p-4 border-top border-top-dashed">
                        <div class="row">
                            <div class="col-lg-4 col-sm-6">
                                <div>
                                    <label for="billingName" class="text-muted text-uppercase fw-semibold">Billing Address</label>
                                </div>
                                <div class="mb-2">
                                    <input type="text" class="form-control bg-light border-0 @error('billing_full_name') is-invalid @enderror" name="billing_full_name" id="billingName" placeholder="Full Name" required value="{{$invoiceDetails->billing_full_name}}" />
                                    <div class="invalid-feedback">
                                        Please enter a full name
                                    </div>

                                    @error('billing_full_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="mb-2">
                                    <textarea class="form-control bg-light border-0 @error('billing_address') is-invalid @enderror" id="billingAddress" name="billing_address" rows="3" placeholder="Address" required>{{$invoiceDetails->billing_address}}</textarea>
                                    <div class="invalid-feedback">
                                        Please enter a address
                                    </div>

                                    @error('billing_address')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="mb-2">
                                    <input type="text" class="form-control bg-light border-0 @error('billing_mobile_number') is-invalid @enderror" data-plugin="cleave-phone" id="billingPhoneno" placeholder="(123)456-7890" required name="billing_mobile_number" value="{{$invoiceDetails->billing_mobile_number}}" />
                                    <div class="invalid-feedback">
                                        Please enter a phone number
                                    </div>

                                    @error('billing_mobile_number')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <input type="text" class="form-control bg-light border-0 @error('billing_tax_number') is-invalid @enderror" id="billingTaxno" placeholder="Tax Number" required name="billing_tax_number" value="{{$invoiceDetails->billing_tax_number}}" />
                                    <div class="invalid-feedback">
                                        Please enter a tax number
                                    </div>

                                    @error('billing_tax_number')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="same" name="is_billing_shippling_add_same" onchange="billingFunction()" @if($invoiceDetails->is_billing_shippling_add_same == 1) {{'checked'}} @endif/>
                                    <label class="form-check-label" for="same">
                                        Will your Billing and Shipping address same?
                                    </label>
                                </div>
                            </div>
                            <!--end col-->
                            <div class="col-sm-6 ms-auto">
                                <div class="row">
                                    <div class="col-lg-8">
                                        <div>
                                            <label for="shippingName" class="text-muted text-uppercase fw-semibold">Shipping Address</label>
                                        </div>
                                        <div class="mb-2">
                                            <input type="text" class="form-control bg-light border-0 @error('billing_tax_number') is-invalid @enderror" id="shippingName" placeholder="Full Name" required name="shippling_full_name" value="{{$invoiceDetails->billing_tax_number}}" />
                                            <div class="invalid-feedback">
                                                Please enter a full name
                                            </div>

                                            @error('shippling_full_name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                        <div class="mb-2">
                                            <textarea class="form-control bg-light border-0 @error('shippling_address') is-invalid @enderror" id="shippingAddress" rows="3" placeholder="Address" required name="shippling_address">{{$invoiceDetails->shippling_address}}</textarea>
                                            <div class="invalid-feedback">
                                                Please enter a address
                                            </div>

                                            @error('shippling_address')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                        <div class="mb-2">
                                            <input type="text" class="form-control bg-light border-0 @error('shippling_mobile_number') is-invalid @enderror" data-plugin="cleave-phone" id="shippingPhoneno" placeholder="(123)456-7890" required name="shippling_mobile_number" value="{{$invoiceDetails->shippling_mobile_number}}" />
                                            <div class="invalid-feedback">
                                                Please enter a phone number
                                            </div>

                                            @error('shippling_mobile_number')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                        <div>
                                            <input type="text" class="form-control bg-light border-0 @error('shippling_tax_number') is-invalid @enderror" id="shippingTaxno" placeholder="Tax Number" name="shippling_tax_number" value="{{$invoiceDetails->shippling_tax_number}}" />
                                            <div class="invalid-feedback">
                                                Please enter a tax number
                                            </div>

                                            @error('shippling_tax_number')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--end col-->
                        </div>
                        <!--end row-->
                    </div>
                    <div class="card-body p-4">
                        <div class="table-responsive">
                            <table class="invoice-table table table-borderless table-nowrap mb-0">
                                <thead class="align-middle">
                                    <tr class="table-active">
                                        <th scope="col" style="width: 50px;">#</th>
                                        <th scope="col">
                                            Product Details
                                        </th>
                                        <th scope="col" style="width: 120px;">
                                            <div class="d-flex currency-select input-light align-items-center">
                                                Rate
                                                <select class="form-selectborder-0 bg-light" data-choices data-choices-search-false id="choices-payment-currency" onchange="otherPayment()" name="currency_type">
                                                    <option value="$" @if($currencyType->currency_type == '$') {{'selected'}} @endif>($)</option>
                                                    {{-- <option value="£" @if($currencyType->currency_type == '£') {{'selected'}} @endif>(£)</option>
                                                    <option value="₹" @if($currencyType->currency_type == '₹') {{'selected'}} @endif>(₹)</option>
                                                    <option value="€" @if($currencyType->currency_type == '€') {{'selected'}} @endif>(€)</option> --}}
                                                </select>
                                            </div>
                                        </th>
                                        <th scope="col" style="width: 120px;">Quantity</th>
                                        <th scope="col" class="text-end" style="width: 150px;">Amount</th>
                                        <th scope="col" class="text-end" style="width: 105px;"></th>
                                    </tr>
                                </thead>
                                <tbody id="newlink">
                                    <input type="hidden" id="counter_value" value="{{count($invoiceDetails->product)}}">
                                    @foreach($invoiceDetails->product as $key => $product)
                                    <script>
                                        getProductDescription("{{$product->product_id}}", "productName-{{$key+1}}");

                                    </script>
                                    <tr id="{{$key+1}}" class="product" onload="">
                                        <th scope="row" class="product-id">{{$key+1}}</th>
                                        <td class="text-start">
                                            <div class="mb-2">
                                                <select class="form-selectborder-0 bg-light @error('product') is-invalid @enderror" data-choices data-choices-search-false onchange="getProductDescription(this.value , this.id)" id="productName-{{$key+1}}" required name="product[]">
                                                    <option value="">Select Product</option>
                                                    @foreach($products as $key1 => $value)
                                                    <option value="{{$value->id}}" @if($product->product_id == $value->id) {{'selected'}} @endif>{{$value->product_name}}</option>
                                                    @endforeach
                                                </select>

                                                <div class="invalid-feedback">
                                                    Please select a product
                                                </div>

                                                @error('product')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                            <textarea class="form-control bg-light border-0" id="productDetails-{{$key+1}}" rows="2" placeholder="Product Details" readonly required></textarea>
                                        </td>
                                        <td>
                                            <input type="number" class="form-control product-price bg-light border-0" name="rate[]" id="productRate-{{$key+1}}" step="0.01" placeholder="0.00" required value="{{$product->rate}}" />
                                            <div class="invalid-feedback">
                                                Please enter a rate
                                            </div>
                                        </td>
                                        <td>
                                            <div class="input-step">
                                                <button type="button" class='minus'>–</button>
                                                <input type="number" class="product-quantity" name="quantity[]" id="product-qty-{{$key+1}}" value="{{$product->quantity}}" readonly>
                                                <button type="button" class='plus'>+</button>
                                            </div>
                                        </td>
                                        <td class="text-end">
                                            <div>
                                                <input type="text" class="form-control bg-light border-0 product-line-price" name="amount[]" id="productPrice-{{$key+1}}" placeholder="$0.00" readonly value="{{$product->amount}}" />
                                            </div>
                                        </td>
                                        <td class="product-removal">
                                            <a href="javascript:void(0)" class="btn btn-success">Delete</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tbody>
                                    <tr id="newForm" style="display: none;">
                                        <td class="d-none" colspan="5">
                                            <p>Add New Form</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="5">
                                            <a href="javascript:new_link()" id="add-item" class="btn btn-soft-secondary fw-medium"><i class="ri-add-fill me-1 align-bottom"></i> Add Item</a>
                                        </td>
                                    </tr>
                                    <tr class="border-top border-top-dashed mt-2">
                                        <td colspan="3"></td>
                                        <td colspan="2" class="p-0">
                                            <table class="table table-borderless table-sm table-nowrap align-middle mb-0">
                                                <tbody>
                                                    <tr>
                                                        <th scope="row">Sub Total</th>
                                                        <td style="width:150px;">
                                                            <input type="text" class="form-control bg-light border-0" name="sub_total" id="cart-subtotal" placeholder="$0.00" readonly value="{{$invoiceDetails->product[0]->currency_type}}{{$invoiceDetails->sub_total}}" />
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">Discount - ({{@$discount->rate}})%<small class="text-muted"></small></th>
                                                        <td>
                                                            <input type="text" class="form-control bg-light border-0" name="discount" id="cart-discount" placeholder="$0.00" readonly value="{{$invoiceDetails->product[0]->currency_type}}{{$invoiceDetails->discount}}" />
                                                            <input type="hidden" id="discount" value="{{@$discount->rate}}">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">Tax ({{@$tax->rate}})%</th>
                                                        <td>
                                                            <input type="text" class="form-control bg-light border-0" name="tax" id="cart-tax" placeholder="$0.00" readonly value="{{$invoiceDetails->product[0]->currency_type}}{{$invoiceDetails->tax}}" />
                                                            <input type="hidden" id="tax" value="{{@$tax->rate}}">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">Shipping Charge</th>
                                                        <td>
                                                            <input type="text" class="form-control bg-light border-0" name="shipping_charge" id="cart-shipping" placeholder="$0.00" readonly value="{{$invoiceDetails->product[0]->currency_type}}{{$invoiceDetails->shipping_charge}}" />
                                                            <input type="hidden" id="shippingCharge" value="{{@$shippingCharge->rate}}">
                                                        </td>
                                                    </tr>
                                                    <tr class="border-top border-top-dashed">
                                                        <th scope="row">Total Amount</th>
                                                        <td>
                                                            <input type="text" class="form-control bg-light border-0" name="total_amount" id="cart-total" placeholder="$0.00" readonly value="{{$invoiceDetails->product[0]->currency_type}}{{$invoiceDetails->total_amount}}" />
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <!--end table-->
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <!--end table-->
                        </div>
                        <div class="row mt-3" id="paymentDetail">
                            <div class="col-lg-4">
                                <div class="mb-2">
                                    <label for="choices-payment-type" class="form-label text-muted text-uppercase fw-semibold">Payment Details</label>
                                    <div class="input-light">
                                        <select class="form-control bg-light border-0 @error('payment_method') is-invalid @enderror" data-choices data-choices-search-false data-choices-removeItem id="choices-payment-type" name="payment_method" required>
                                            <option value="">Payment Method</option>
                                            <option value="Card" @if(@$invoiceDetails->paymentDetails->payment_method == 'Card') {{'selected'}} @endif>Card</option>
                                            <option value="Paypal" @if(@$invoiceDetails->paymentDetails->payment_method == 'Paypal') {{'selected'}} @endif>Paypal</option>
                                            <option value="Stripe" @if(@$invoiceDetails->paymentDetails->payment_method == 'Stripe') {{'selected'}} @endif>Stripe</option>
                                        </select>
                                    </div>

                                    @error('payment_method')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="mb-2">
                                    <input class="form-control bg-light border-0 @error('payment_method') is-invalid @enderror" type="text" id="cardholderName" placeholder="Card Holder Name" name="card_holder_name" value="{{@$invoiceDetails->paymentDetails->card_holder_name}}">

                                    @error('card_holder_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="mb-2">
                                    <input class="form-control bg-light border-0 @error('card_number') is-invalid @enderror" type="text" id="cardNumber" placeholder="xxxx xxxx xxxx xxxx" name="card_number" value="{{@$invoiceDetails->paymentDetails->card_number}}">

                                    @error('card_number')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div>
                                    <input class="form-control  bg-light border-0" type="text" id="amountTotalPay" placeholder="$0.00" readonly value="{{@$invoiceDetails->product[0]->currency_type.''.@$invoiceDetails->total_amount}}" />
                                </div>
                            </div>
                            <!--end col-->
                        </div>
                        <!--end row-->
                        <div class="mt-4">
                            <label for="exampleFormControlTextarea1" class="form-label text-muted text-uppercase fw-semibold">NOTES</label>
                            <textarea class="form-control alert alert-info" id="exampleFormControlTextarea1" placeholder="Notes" rows="2" required>All accounts are to be paid within 7 days from receipt of invoice. To be paid by cheque or credit card or direct payment online. If account is not paid within 7 days the credits details supplied as confirmation of work undertaken will be charged the agreed quoted fee noted above.</textarea>
                        </div>
                        <div class="hstack gap-2 justify-content-end d-print-none mt-4">
                            <button type="submit" class="btn btn-info"><i class="ri-printer-line align-bottom me-1"></i> Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!--end col-->
    </div>

    @endsection
    @section('scripts')
    <!-- Choices js -->
    <script src="{{URL::asset('assets/libs/choices.js/public/assets/scripts/choices.min.js')}}"></script>
    <!-- jquery -->

    <!-- cleave.js -->
    <script src="{{URL::asset('assets/libs/cleave.js/cleave.min.js')}}"></script>
    <script>
        var data = @json($products);

    </script>
    <!--Invoice create init js-->
    <script src="{{URL::asset('assets/js/pages/editinvoicecreate.init.js')}}"></script>

    <script>
        (function() {
            'use strict';

            var payment_status = document.getElementById("payment_status").value;
            if (payment_status == 0 || payment_status == 2 | payment_status == 3) {
                document.getElementById("paymentDetail").style.display = 'none';
            }
            if (payment_status == 1) {
                document.getElementById("paymentDetail").style.display = 'block';
            }
            $('#choices-payment-status').on('change', function() {
                if (this.value == 1) {
                    document.getElementById("paymentDetail").style.display = 'block';
                } else {
                    document.getElementById("paymentDetail").style.display = 'none';
                }
            });
        })();

    </script>
    @endsection
