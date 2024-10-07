@extends('layouts.master')
@section('title') {{__('translation.Invoice List')}} @endsection
@section('css')

@endsection

@section('body')
<body>
    @endsection

    @section('content')

    @component('components.breadcrumb')
    @slot('title') {{__('translation.Invoice')}} @endslot
    @slot('pagetitle') {{__('translation.Add Invoice')}} @endslot
    @endcomponent

    <div class="row justify-content-center">
        <div class="col-xxl-9">
            <div class="card">
                <form method="POST" action="{{url('add-invoice')}}" class="needs-validation" novalidate id="invoice_form">
                    @csrf
                    <div class="card-body border-bottom border-bottom-dashed p-4">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="row g-3">
                                    <div class="col-lg-8 col-sm-6">
                                        <label for="invoicenoInput">{{__('translation.Invoice Number')}}</label>
                                        <input type="text" class="form-control bg-light border-0" id="invoicenoInput" placeholder="Invoice No" name="invoice_number" value="#VL25000355" readonly="readonly">
                                        <input type="hidden" id="invoice_slug" value="{{$companyDetails->invoice_slug}}">
                                    </div>
                                    <!--end col-->
                                    <div class="col-lg-8 col-sm-6">
                                        <label for="choices-client">{{__('translation.Select Client')}}</label>
                                        <div class="input-light">
                                            <?php $clientId = request()->route('id'); ?>
                                            <select class="form-select bg-light border-0 @error('client_id') is-invalid @enderror" name="client_id" id="choices-client" required>
                                                <option value="">Select Client</option>
                                                @foreach($clientList as $key => $value)
                                                <option value="{{$value->id}}" @if($clientId==$value->id) {{'selected'}} @endif>{{$value->first_name.' '.$value->last_name}}</option>
                                                @endforeach
                                            </select>

                                            @error('client_id')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <!--end col-->
                                    <div class="col-lg-8 col-sm-6">
                                        <div>
                                            <label for="date-field">{{__('translation.Date')}}</label>
                                            <input type="text" class="form-control bg-light border-0 flatpickr-input @error('date') is-invalid @enderror" id="date-field" name="date" data-provider="flatpickr" data-time="true" placeholder="Select Date-time" readonly required>

                                            @error('date')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <!--end col-->
                                    <div class="col-lg-8 col-sm-6">
                                        <label for="choices-payment-status">{{__('translation.Payment Status')}}</label>
                                        <div class="input-light">
                                            <select class="form-select bg-light border-0 @error('payment_status') is-invalid @enderror" name="payment_status" id="choices-payment-status" required>
                                                <option value="">Select Payment Status</option>
                                                {{-- <option value="1">Paid</option> --}}
                                                <option value="0" selected>Unpaid</option>
                                                {{-- <option value="2">Refund</option>
                                                <option value="3">Cancel</option> --}}
                                            </select>

                                            @error('payment_status')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <!--end col-->
                                    <div class="col-lg-8 col-sm-6">
                                        <div>
                                            <label for="totalamountInput">{{__('translation.Total Amount')}}</label>
                                            <input type="text" class="form-control bg-light border-0" id="totalamountInput" placeholder="$0.00" readonly="">
                                        </div>
                                    </div>
                                    <!--end col-->
                                </div>

                            </div>
                            <!--end col-->
                            <div class="col-lg-4 ms-auto">
                                <div class="profile-user mx-auto  mb-3">
                                    <input id="profile-img-file-input" type="text" class="profile-img-file-input" />
                                    <label for="profile-img-file-input" class="d-block" tabindex="0">
                                        <span class="overflow-hidden border border-dashed d-flex align-items-center justify-content-center rounded" style="height: 60px; width: 256px;">
                                            <img src="{{URL::asset('/assets/images/logo/'.$companyDetails->logo)}}" class="card-logo card-logo-dark user-profile-image img-fluid" alt="logo dark">
                                            <img src="{{URL::asset('/assets/images/logo/'.$companyDetails->logo)}}" class="card-logo card-logo-light user-profile-image img-fluid" alt="logo light">
                                        </span>
                                    </label>
                                </div>


                                <div>
                                    <label for="companyAddress">{{__('translation.Address')}}</label>
                                </div>
                                <div class="mb-2">
                                    <input type="hidden" name="company_id" value="{{$companyDetails->id}}">
                                    <textarea class="form-control bg-light border-0" id="companyAddress" rows="3" placeholder="Company Address" required="" readonly>{{$companyDetails->address}}</textarea>
                                    <div class="invalid-feedback">
                                        Please enter a address
                                    </div>
                                </div>
                                <div class="mb-2">
                                    <label for="companyaddpostalcode">{{__('translation.Postalcode')}}</label>
                                    <input type="text" class="form-control bg-light border-0" id="companyaddpostalcode" minlength="5" maxlength="6" placeholder="Enter Postal Code" required="" readonly value="{{$companyDetails->postalcode}}">
                                    <div class="invalid-feedback">
                                        The US zip code must contain 5 digits, Ex. 45678
                                    </div>
                                </div>

                                <div class="mb-2">
                                    <label for="companyEmail">{{__('translation.Email')}}</label>
                                    <input type="email" class="form-control bg-light border-0" id="companyEmail" placeholder="Email Address" required readonly value="{{$companyDetails->email}}" />
                                    <div class="invalid-feedback">
                                        Please enter a valid email, Ex., example@gamil.com
                                    </div>
                                </div>
                                <div class="mb-2">
                                    <label for="companyWebsite">{{__('translation.Website')}}</label>
                                    <input type="text" class="form-control bg-light border-0" id="companyWebsite" placeholder="Website" required readonly value="{{$companyDetails->website}}" />
                                    <div class="invalid-feedback">
                                        Please enter a website, Ex., www.example.com
                                    </div>
                                </div>
                                <div>
                                    <label for="compnayContactno">{{__('translation.Contact No')}}</label>
                                    <input type="text" class="form-control bg-light border-0" id="compnayContactno" placeholder="Contact No" required readonly value="{{$companyDetails->mobile_number}}" autocomplete="off" />
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
                                    <label for="billingName" class="text-muted text-uppercase fw-semibold">{{__('translation.Billing Address')}}</label>
                                </div>
                                <div class="mb-2">
                                    <input type="text" class="form-control bg-light border-0 @error('billing_full_name') is-invalid @enderror" name="billing_full_name" id="billingName" placeholder="Full Name" required />

                                    @error('billing_full_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="mb-2">
                                    <textarea class="form-control bg-light border-0 @error('billing_address') is-invalid @enderror" id="billingAddress" name="billing_address" rows="3" placeholder="Address" required></textarea>

                                    @error('billing_address')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="mb-2">
                                    <input type="text" class="form-control bg-light border-0 @error('billing_mobile_number') is-invalid @enderror" id="billingPhoneno" placeholder="12345-67890" required name="billing_mobile_number" />

                                    @error('billing_mobile_number')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <input type="text" class="form-control bg-light border-0 @error('billing_tax_number') is-invalid @enderror" id="billingTaxno" placeholder="Tax Number" required name="billing_tax_number" autocomplete="off" />

                                    @error('billing_tax_number')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="same" name="is_billing_shippling_add_same" onchange="billingFunction()" />
                                    <label class="form-check-label" for="same">
                                        {{__('translation.Will your Billing and Shipping address same?')}}
                                    </label>
                                </div>
                            </div>
                            <!--end col-->
                            <div class="col-sm-6 ms-auto">
                                <div class="row">
                                    <div class="col-lg-8">
                                        <div>
                                            <label for="shippingName" class="text-muted text-uppercase fw-semibold">{{__('translation.Shipping Address')}}</label>
                                        </div>
                                        <div class="mb-2">
                                            <input type="text" class="form-control bg-light border-0 @error('shippling_full_name') is-invalid @enderror" id="shippingName" placeholder="Full Name" required name="shippling_full_name" />

                                            @error('shippling_full_name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                        <div class="mb-2">
                                            <textarea class="form-control bg-light border-0 @error('shippling_address') is-invalid @enderror" id="shippingAddress" rows="3" placeholder="Address" required name="shippling_address"></textarea>

                                            @error('shippling_address')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                        <div class="mb-2">
                                            <input type="text" class="form-control bg-light border-0 @error('shippling_mobile_number') is-invalid @enderror" id="shippingPhoneno" placeholder="12345-67890" required name="shippling_mobile_number" />

                                            @error('shippling_mobile_number')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                        <div>
                                            <input type="text" class="form-control bg-light border-0 @error('shippling_tax_number') is-invalid @enderror" id="shippingTaxno" placeholder="Tax Number" required name="shippling_tax_number" autocomplete="off" />

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
                                            {{__('translation.Product Details')}}
                                        </th>
                                        <th scope="col" style="width: 120px;">
                                            <div class="d-flex currency-select input-light align-items-center">
                                                Rate
                                                <select class="form-selectborder-0 bg-light" id="choices-payment-currency" onchange="otherPayment()" name="currency_type">
                                                    <option value="$">($)</option>
                                                    {{-- <option value="£">(£)</option>
                                                    <option value="₹">(₹)</option>
                                                    <option value="€">(€)</option> --}}
                                                </select>
                                            </div>
                                        </th>
                                        <th scope="col" style="width: 120px;">{{__('translation.Quantity')}}</th>
                                        <th scope="col" class="text-end" style="width: 150px;">{{__('translation.Amount')}}</th>
                                        <th scope="col" class="text-end" style="width: 105px;"></th>
                                    </tr>
                                </thead>
                                <tbody id="newlink">
                                    <tr id="1" class="product">
                                        <th scope="row" class="product-id">1</th>
                                        <td class="text-start">
                                            <div class="mb-2">
                                                <select class="form-select border-0 bg-light @error('product') is-invalid @enderror" onchange="getProductDescription(this.value , this.id)" id="productName-1" name="product[]" required>
                                                    <option value="">Select Product</option>
                                                    @foreach($products as $key => $value)
                                                    <option value="{{$value->id}}">{{$value->product_name}}</option>
                                                    @endforeach
                                                </select>

                                                @error('product')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                            <textarea class="form-control bg-light border-0" id="productDetails-1" rows="2" placeholder="Product Details" readonly required></textarea>
                                        </td>
                                        <td>
                                            <input type="number" class="form-control product-price bg-light border-0" name="rate[]" id="productRate-1" step="0.01" placeholder="0.00" required />
                                        </td>
                                        <td>
                                            <div class="input-step">
                                                <button type="button" class='minus'>–</button>
                                                <input type="number" class="product-quantity @error('quantity') is-invalid @enderror" name="quantity[]" id="product-qty-1" value="0" min="1" readonly>
                                                <button type="button" class='plus'>+</button>

                                                @error('quantity')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </td>
                                        <td class="text-end">
                                            <div>
                                                <input type="text" class="form-control bg-light border-0 product-line-price" name="amount[]" id="productPrice-1" placeholder="$0.00" readonly />
                                            </div>
                                        </td>
                                        <td class="product-removal">
                                            <a href="javascript:void(0)" class="btn btn-success">Delete</a>
                                        </td>
                                    </tr>
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
                                                        <th scope="row">{{__('translation.Sub Total')}}</th>
                                                        <td style="width:150px;">
                                                            <input type="text" class="form-control bg-light border-0" name="sub_total" id="cart-subtotal" placeholder="$0.00" readonly />
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">{{__('translation.Discount')}} ({{@$discount->rate}}%)<small class="text-muted"></small></th>
                                                        <td>
                                                            <input type="text" class="form-control bg-light border-0" name="discount" id="cart-discount" placeholder="$0.00" readonly />
                                                            <input type="hidden" id="discount" value="{{@$discount->rate}}">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">{{__('translation.Tax')}} ({{@$tax->rate}}%)</th>
                                                        <td>
                                                            <input type="text" class="form-control bg-light border-0" name="tax" id="cart-tax" placeholder="$0.00" readonly />
                                                            <input type="hidden" id="tax" value="{{@$tax->rate}}">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">{{__('translation.Shipping Charge')}}</th>
                                                        <td>
                                                            <input type="text" class="form-control bg-light border-0" name="shipping_charge" id="cart-shipping" placeholder="$0.00" readonly />
                                                            <input type="hidden" id="shippingCharge" value="{{@$shippingCharge->rate}}">
                                                        </td>
                                                    </tr>
                                                    <tr class="border-top border-top-dashed">
                                                        <th scope="row">{{__('translation.Total Amount')}}</th>
                                                        <td>
                                                            <input type="text" class="form-control bg-light border-0" name="total_amount" id="cart-total" placeholder="$0.00" readonly />
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
                                    <label for="choices-payment-type" class="form-label text-muted text-uppercase fw-semibold">{{__('translation.Payment Details')}}</label>
                                    <div class="input-light">
                                        <select class="form-control bg-light border-0 @error('payment_method') is-invalid @enderror" data-choices-removeItem id="choices-payment-type" name="payment_method">
                                            <option value="">Payment Method</option>
                                            <option value="Card">Card</option>
                                            <option value="Paypal">Paypal</option>
                                            <option value="Stripe">Stripe</option>
                                        </select>
                                    </div>

                                    @error('payment_method')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="mb-2">
                                    <input class="form-control bg-light border-0 @error('payment_method') is-invalid @enderror" type="text" id="cardholderName" placeholder="Card Holder Name" name="card_holder_name">

                                    @error('card_holder_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="mb-2">
                                    <input class="form-control bg-light border-0 @error('card_number') is-invalid @enderror" type="text" id="cardNumber" placeholder="xxxx xxxx xxxx xxxx" name="card_number">

                                    @error('card_number')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div>
                                    <input class="form-control  bg-light border-0" type="text" id="amountTotalPay" placeholder="$0.00" readonly />
                                </div>
                            </div>
                            <!--end col-->
                        </div>
                        <!--end row-->
                        <div class="mt-4">
                            <label for="exampleFormControlTextarea1" class="form-label text-muted text-uppercase fw-semibold">NOTES</label>
                            <textarea class="form-control alert alert-info" id="exampleFormControlTextarea1" placeholder="Notes" rows="2">All accounts are to be paid within 7 days from receipt of invoice. To be paid by cheque or credit card or direct payment online. If account is not paid within 7 days the credits details supplied as confirmation of work undertaken will be charged the agreed quoted fee noted above.</textarea>
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
    <script src="{{URL::asset('assets/js/jquery-3.6.4.min.js')}}"></script>
    <!-- cleave.js -->
    <script src="{{URL::asset('assets/libs/cleave.js/cleave.min.js')}}"></script>
    <script>
        var data = @json($products);

    </script>
    <!--Invoice create init js-->
    <script src="{{URL::asset('assets/js/pages/invoicecreate.init.js')}}"></script>

    <script>
        //Form validate 
        (function() {
            'use strict';
            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            var forms = document.querySelectorAll('.needs-validation')
            // Loop over them and prevent submission
            Array.prototype.slice.call(forms)
                .forEach(function(form) {
                    form.addEventListener('submit', function(event) {
                        if (!form.checkValidity()) {
                            event.preventDefault()
                            event.stopPropagation()
                        }

                        form.classList.add('was-validated')
                    }, false)
                })


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
            }

            document.getElementById("paymentDetail").style.display = 'none';
            $('#choices-payment-status').on('change', function() {
                if (this.value == 1) {
                    document.getElementById("paymentDetail").style.display = 'block';
                } else {
                    document.getElementById("paymentDetail").style.display = 'none';
                }
            });
        })()

    </script>
    @endsection
