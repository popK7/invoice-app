@extends('layouts.master')
@section('title') {{ __('translation.Dashboard') }} @endsection
@section('css')
<!-- flatpicker css -->
<link rel="stylesheet" href="{{URL::asset('assets/libs/flatpickr/flatpickr.min.js')}}">
@endsection

@section('body') 
    <body> 
@endsection

    @section('content')

    @component('components.breadcrumb')
        @slot('title') {{ __('translation.Dashboard') }} @endslot
        @slot('pagetitle') {{ __('translation.Dashboard') }} @endslot
    @endcomponent

    <div class="row">
        <div class="col-xl-5">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center gy-4">
                        <div class="col-sm-8">
                            <div class="box">
                                <h5 class="fs-20 text-truncate">{{__('translation.Professional Invoices Made Easy')}}.</h5>
                                <p class="text-muted fs-15">{{__('translation.Quickly understand who your best customers little and motivation to pay thair bills')}}.</p>
                                <a href="" class="btn btn-primary">{{__('translation.Watch Tutorial')}}</a>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="text-center px-2">
                                <img src="assets/images/invoice-widget.png" class="img-fluid" style="height: 141px;" alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-7">
            <div class="card dash-mini card-height-100">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1" id="overviewText"></h4>
                    <div class="flex-shrink-0">
                        <div class="dropdown card-header-dropdown">
                            <select class="form-control" id="overviewDropdown" aria-label="Default select example">
                                <option selected value="today">{{__('translation.Today')}}</option>
                                <option value="last_week">{{__('translation.Last Week')}}</option>
                                <option value="last_month">{{__('translation.Last Month')}}</option>
                                <option value="current_year">{{__('translation.Current Year')}}</option>
                            </select>
                        </div>
                    </div>
                </div><!-- end card header -->

                <div class="card-body pt-1">
                    <div class="row">
                        <div class="col-lg-3 mini-widget pb-3 pb-lg-0">
                            <div class="d-flex align-items-center">
                                <div class="flex-grow-1">
                                    <h2 class="mb-0 fs-24"><span class="counter-value" data-target="" id="clientsAdded"></span></h2>
                                    <h5 class="text-muted fs-16 mt-2 mb-0">{{__('translation.Clients Added')}}</h5>
                                </div>
                                <div class="flex-shrink-0 me-1">
                                    <div class="avatar flex-shrink-0">
                                        <span class="avatar-title bg-soft-warning rounded fs-3">
                                            <i class="las la-user-circle text-warning"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-3 mini-widget py-3 py-lg-0">
                            <div class="d-flex align-items-end">
                                <div class="flex-grow-1">
                                    <h2 class="mb-0 fs-24"><span class="counter-value" data-target="" id="invoiceSent"></span></h2>
                                    <h5 class="text-muted fs-16 mt-2 mb-0">{{__('translation.Invoice Sent')}}</h5>
                                </div>
                                <div class="flex-shrink-0 me-1">
                                    <div class="avatar flex-shrink-0">
                                        <span class="avatar-title bg-soft-info rounded fs-3">
                                            <i class="las la-file-invoice text-info"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-3 mini-widget py-3 py-lg-0">
                            <div class="d-flex align-items-end">
                                <div class="flex-grow-1">
                                    <h2 class="mb-0 fs-24"><span class="counter-value" data-target="" id="paidInvoice"></span></h2>
                                    <h5 class="text-muted fs-16 mt-2 mb-0">{{__('translation.Paid Invoice')}}</h5>
                                </div>
                                <div class="flex-shrink-0 me-1">
                                    <div class="avatar flex-shrink-0">
                                        <span class="avatar-title bg-soft-success rounded fs-3">
                                            <i class="las la-dollar-sign text-success"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div><!-- end col -->

                        <div class="col-lg-3 mini-widget pt-3 pt-lg-0">
                            <div class="d-flex align-items-end">
                                <div class="flex-grow-1">
                                    <h2 class="mb-0 fs-24"><span class="counter-value" data-target="" id="unpaidInvoice"></span></h2>
                                    <h5 class="text-muted fs-16 mt-2 mb-0">{{__('translation.Unpaid Invoice')}}</h5>
                                </div>
                                <div class="flex-shrink-0 me-1">
                                    <div class="avatar flex-shrink-0">
                                        <span class="avatar-title bg-soft-danger rounded fs-3">
                                            <i class="las la-dollar-sign text-danger"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div><!-- end col -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-8">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">{{__('translation.Payment Activity')}}</h4>
                    <div class="btnGroup">
                        <button type="button" id="BarIndexMonth" class="btn btn-soft-info btn-sm">
                            1M
                        </button>
                        <button type="button" id="BarIndexSixmonth" class="btn btn-soft-info btn-sm">
                            6M
                        </button>
                        <button type="button" id="BarIndexYear" class="btn btn-info btn-sm">
                            1Y
                        </button>
                        {{-- <button type="button" id="BarIndexAll" class="btn btn-soft-info btn-sm">
                            ALL
                        </button> --}}
                    </div>
                </div>
                <div class="card-body py-1">
                    <div class="row gy-2">
                        <div class="col-md-4">
                            <h4 class="fs-22 mb-0"></h4>
                        </div>
                        <div class="col-md-8">
                            <div class="d-flex main-chart justify-content-end">
                                <div class="px-4 border-end">
                                    <h4 class="text-primary fs-22 mb-0" id="paymenActivityPaid"> <span class="text-muted d-inline-block fs-17 align-middle ms-0 ms-sm-2">{{__('translation.Paid')}}</span></h4>
                                </div>
                                <div class="ps-4">
                                    <h4 class="text-primary fs-22 mb-0" id="paymenActivityUnpaid"> <span class="text-muted d-inline-block fs-17 align-middle ms-0 ms-sm-2">{{__('translation.Unpaid')}}</span></h4>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="stacked-column-chart" class="apex-charts" data-colors='["--in-primary", "--in-light-rgb, 1.0"]' dir="ltr"></div>
                </div>
            </div>
        </div>
        <div class="col-xl-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-start">
                        <div class="flex-grow-1 overflow-hidden">
                            <h5 class="card-title mb-2 text-truncate">{{__('translation.Structure')}}</h5>
                        </div>
                        <div class="flex-shrink-0 ms-2">
                            <div class="dropdown">
                                <input type="date" class="form-control" id="structureDatePicker" name="structureDatePicker" placeholder="Select date range">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            </div>
                        </div>
                    </div>

                    <div id="structure-widget" data-colors='["--in-primary", "--in-primary-rgb, 0.7", "--in-danger-rgb, 0.9"]' class="apex-charts" dir="ltr"></div> 

                    <div class="px-2">
                        <div class="structure-list d-flex justify-content-between border-bottom">
                            <p class="mb-0"><i class="las la-dot-circle fs-18 text-primary me-2"></i>{{__('translation.Paid')}}</p>
                            <div>
                                <span class="badge bg-primary" id="paidAmt"> ${{$totalAmountOfPaidInvoices}} </span>
                                <input type="hidden" id="paidAmount" value="{{$totalAmountOfPaidInvoices}}">
                            </div>
                        </div>
                        <div class="structure-list d-flex justify-content-between border-bottom">
                            <p class="mb-0"><i class="las la-dot-circle fs-18 text-primary me-2"></i>{{__('translation.Unpaid')}}</p>
                            <div>
                                <span class="badge bg-primary" id="pendingAmt"> ${{$totalAmountOfPendingInvoices}} </span>
                                <input type="hidden" id="pendingAmount" value="{{$totalAmountOfPendingInvoices}}">
                            </div>
                        </div>
                        <div class="structure-list d-flex justify-content-between pb-0">
                            <p class="mb-0"><i class="las la-dot-circle fs-18 text-primary me-2"></i>{{__('translation.Cancelled')}}</p>
                            <div>
                                <span class="badge bg-primary" id="cancelAmt"> ${{$totalAmountOfCancelInvoices}} </span>
                                <input type="hidden" id="cancelledAmount" value="{{$totalAmountOfCancelInvoices}}">
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-5">
            <div class="card card-height-100">
                <div class="card-header align-items-center d-flex mb-3">
                    <h4 class="card-title mb-0 flex-grow-1">{{__('translation.Latest Client List')}}</h4>
                </div>

                <div class="card-body pt-0">

                    <div class="table-responsive table-card">
                        <table class="table table-striped table-nowrap align-middle mb-0">
                            <thead>
                                <tr class="text-muted text-uppercase">
                                    <th scope="col">{{__('translation.Sr. No')}}</th>
                                    <th scope="col">{{__('translation.Client Name')}}</th>
                                    <th scope="col">{{__('translation.Email')}}</th>
                                    <th scope="col" style="width: 12%;">{{__('translation.Action')}}</th>
                                </tr>
                            </thead>

                            <tbody>
                                @if(count($clients) > 0)
                                    @foreach($clients as $key => $client)
                                        <tr>
                                            <td><p class="mb-0">{{$key+1}}</p></td>
                                            <td><img src="assets/images/users/{{$client->profile_image}}" alt="" class="avatar-xs rounded-circle me-2">
                                                <a href="#javascript: void(0);" class="text-body align-middle">{{$client->first_name.' '.$client->last_name}}</a>
                                            </td>
                                            <td>{{$client->email}}</td>
                                            
                                            <td>
                                                <div class="dropdown">
                                                    <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Make Invoice">
                                                        <a href="{{url('make-invoice', $client->id)}}" class="btn btn-soft-warning btn-sm d-inline-block"><i class="las la-file-invoice"></i></a>
                                                    </li>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr class="text-canter">
                                        <td colspan="6">{{__('translation.No Client Found')}}</td>
                                    </tr>
                                @endif
                            </tbody><!-- end tbody -->
                        </table><!-- end table -->
                    </div><!-- end table responsive -->
                    
                </div>
            </div>
        </div>
        <div class="col-xl-4">
            <div class="card">
                <div class="card-header align-items-center d-flex pb-2">
                    <h4 class="card-title mb-0 flex-grow-1">{{__('translation.Payment Overview')}}</h4>
                    <div class="flex-shrink-0 ms-2">
                        <div class="dropdown">
                            <input type="date" class="form-control" id="overviewYearPicker" name="overviewYearPicker" placeholder="Select year">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        </div>
                    </div>
                </div>

                <div class="card-body pt-0">
                    <div id="payment-overview" data-colors='["--in-primary", "--in-light"]' class="apex-charts" dir="ltr"></div>  
                    <div class="row mt-3 text-center">
                        <div class="col-6 border-end">
                            <div class="my-1">
                                <p class="text-muted text-truncate mb-2">{{__('translation.Paid Amount')}}</p>
                                <h4 class="mt-2 mb-0 fs-20" id="overViewPaidAmt">${{$totalAmountOfPaidInvoices}}</h4>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="my-1">
                                <p class="text-muted text-truncate mb-2">{{__('translation.Unpaid Amount')}}</p>
                                <h4 class="mt-2 mb-0 fs-20" id="overViewUnpaidAmt">${{$totalAmountOfPendingInvoices}}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3">
            <div class="card card-height-100">
                <div class="card-body">
                    <div class="d-flex align-items-start mb-1">
                        <div class="flex-grow-1">
                            <h5 class="card-title">{{__('translation.Recent Transaction')}}</h5>
                        </div>
                    </div>

                    <div class="mx-n3 px-3 recent-transaction" data-simplebar>
                        @if(count($allTransactions) > 0) 
                            @foreach($allTransactions as $key => $transaction)
                                <div class="border-bottom sales-history">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-sm flex-shrink-0">
                                            <span class="avatar-title bg-primary rounded-circle fs-3">
                                                <i class="lab la-paypal fs-22"></i>
                                            </span>
                                        </div>
                                        <div class="flex-grow-1 ms-3 overflow-hidden">
                                            <h5 class="fs-15 mb-1 text-truncate">{{__('translation.Invoice')}}</h5>
                                            <p class="fs-14 text-muted text-truncate mb-0">{{date('d M, Y  h:i:s',strtotime($transaction->created_at))}}</p>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <span class="badge fs-12 badge-soft-success">${{$transaction->amount}}</span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                                <div class="border-bottom sales-history">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1 ms-3 overflow-hidden text-center">
                                            <h5 class="fs-15 mb-1 text-truncate">{{__('translation.No Transaction Found')}}</h5>
                                        </div>
                                    </div>
                                </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="row">
        <input type="hidden" id="latlongArray" value="{{$latLong}}">
        <div class="col-xl-7">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Sales Revenue</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-xl-7">
                            <div class="py-3">
                                <div id="world-map-markers"></div>
                            </div>
                        </div>

                        <div class="col-xl-5">
                            <div class="table-responsive">
                                    <table class="table table-centered align-middle table-nowrap mb-0">
                                        <thead>
                                            <tr class="text-uppercase">
                                                <th style="width: 40%;">{{__('translation.Country')}}</th>
                                                <th style="width: 30%;">{{__('translation.Orders')}}</th>
                                                <th style="width: 30%;">{{__('translation.Earning')}}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(count($invoiceWorldwideData) > 0)
                                                @foreach($invoiceWorldwideData as $key => $value)
                                                    <tr>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <div class="flex-grow-1 ms-3">
                                                                    <p class="mb-0 text-truncate">{{$value['country']}}</p>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>{{$value['orders']}}</td>
                                                        <td>${{$value['earning']}}</td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr colspan="3">
                                                    <td class="d-flex align-items-center">{{__('translation.No Transaction Found')}}</td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-5">
        <div class="card card-height-100">
            <div class="card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1">{{__('translation.Latest Invoice List')}}</h4>
            </div>
            <div class="card-body pt-2">
                <div class="table-responsive table-card">
                    <table class="table table-striped table-nowrap align-middle mb-0">
                        <thead>
                            <tr class="text-muted text-uppercase">
                                <th scope="col">{{__('translation.Invoice ID')}}</th>
                                <th scope="col">{{__('translation.Client')}}</th>
                                <th scope="col">{{__('translation.Amount')}}</th>
                                <th scope="col">{{__('translation.Date')}}</th>
                                <th scope="col" style="width: 16%;">{{__('translation.Status')}}</th>
                                <th scope="col" style="width: 12%;">{{__('translation.Action')}}</th>
                            </tr>
                        </thead>

                        <tbody>
                            @if(count($allInvoices) > 0)
                                @foreach($allInvoices as $key => $invoice)
                                    <tr>
                                        <td><p class="mb-0">{{$invoice->invoice_number}}</p></td>
                                        <td><img src="assets/images/users/{{$invoice->client->profile_image}}" alt="" class="avatar-xs rounded-circle me-2">
                                            <a href="#javascript: void(0);" class="text-body align-middle">{{$invoice->client->first_name.' '.$invoice->client->last_name}}</a>
                                        </td>
                                        <td>{{$invoice->total_amount}}</td>
                                        <td><?php echo date('d M, Y',strtotime($invoice->date));?></td>
                                        <?php 
                                            $statusValue = ""; $statusColor = "";
                                            if($invoice->payment_status == 0) { $statusValue = 'Unpaid';$statusColor = 'danger';};
                                            if($invoice->payment_status == 1) { $statusValue = 'Paid';$statusColor = 'success';};
                                            if($invoice->payment_status == 2) { $statusValue = 'Refund';$statusColor = 'warning';};
                                            if($invoice->payment_status == 3) { $statusValue = 'Cancel';$statusColor = 'info';};
                                        ?>
                                        <td><span class="badge badge-soft-{{$statusColor}} p-2">{{$statusValue}}</span></td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="las la-ellipsis-h align-middle fs-18"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    <li>
                                                        <a class="dropdown-item" href="{{route('view-invoice', $invoice->id)}}"><i class="las la-eye fs-18 align-middle me-2 text-muted"></i>
                                                            View</a>
                                                    </li>
                                                    @if($invoice->payment_status != 1)
                                                        <li>
                                                            <a class="dropdown-item" href="{{route('edit-invoice', $invoice->id)}}"><i class="las la-pen fs-18 align-middle me-2 text-muted"></i>
                                                                Edit</a>
                                                        </li>
                                                    @endif
                                                    <li class="dropdown-divider"></li>
                                                    <li>
                                                        <a class="dropdown-item remove-item-btn" href="{{route('delete-invoice', $invoice->id)}}">
                                                            <i class="las la-trash-alt fs-18 align-middle me-2 text-muted"></i>
                                                            Delete
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr class="text-center">
                                    <td colspan="6">No Invoice Found</td>
                                </tr>
                            @endif
                        </tbody><!-- end tbody -->
                    </table><!-- end table -->
                </div><!-- end table responsive -->

            </div>
        </div>
    </div>

    @endsection
    @section('scripts')
        <!-- apexcharts -->
        <script src="{{URL::asset('assets/libs/apexcharts/apexcharts.min.js')}}"></script>
        <!-- flatpicker -->
        <script src="{{URL::asset('assets/libs/flatpickr/flatpickr.min.js')}}"></script>
        <!-- jquery -->
        <script src="{{URL::asset('assets/js/jquery-3.6.4.min.js')}}" ></script>

        <!-- Vector map-->
        <script src="{{URL::asset('assets/libs/jsvectormap/js/jsvectormap.min.js')}}"></script>
        <script src="{{URL::asset('assets/libs/jsvectormap/maps/world-merc.js')}}"></script>

        <!-- Dashboard init -->
        <script src="{{URL::asset('assets/js/pages/dashboard.init.js')}}"></script>

        <script>

         (function () {
            'use strict';

            flatpickr("#structureDatePicker", {
                mode: "range",
                maxDate:'today'
            });

            flatpickr("#overviewYearPicker", {
                maxDate:'today',
                dateFormat: 'Y',
            });

            /* ------------------------------> Structure Chart Start<------------------------ */

                var paidAmount = Number(document.getElementById("paidAmount").value);
                var pendingAmount = Number(document.getElementById("pendingAmount").value);
                var cancelledAmount = Number(document.getElementById("cancelledAmount").value);
                structureChart(paidAmount,pendingAmount,cancelledAmount)

                // Structure Chart Onchange Event
                $('#structureDatePicker').change(function() {
                    var token = $("input[name='_token']").val();
                    var structureDate = $(this).val();
                    $.ajax({
                        type:"POST",
                        url : "{{route('structure-datevalue')}}",
                        data : { 'structureDate': structureDate, '_token': token },
                        success : function(response) {
                            var paidAmount = Number(response.totalAmountOfPaidInvoices);
                            var pendingAmount = Number(response.totalAmountOfPendingInvoices);
                            var cancelledAmount = Number(response.totalAmountOfCancelInvoices);
                            document.getElementById("paidAmount").value = paidAmount;
                            document.getElementById("pendingAmount").value = pendingAmount;
                            document.getElementById("cancelledAmount").value = cancelledAmount;
                            $('#paidAmt').text(paidAmount);
                            $('#pendingAmt').text(pendingAmount);
                            $('#cancelAmt').text(cancelledAmount);
                            structureChart(paidAmount,pendingAmount,cancelledAmount)
                        },
                        error: function() {
                        }
                    });
                });
            /* ------------------------------> Structure Chart End<------------------------ */


            /* ------------------------------> Overview Chart Start<------------------------ */
                // Overview Chart
                var currentYear = new Date().getFullYear();
                ajaxCallForOverviewChart(currentYear);
                
                // Overview Chart Onchange Event
                $('#overviewYearPicker').change(function() {
                    var overviewDate = $(this).val();
                    ajaxCallForOverviewChart(overviewDate);
                });

                // Overview Chart Ajax Call
                function ajaxCallForOverviewChart(overviewDate) {
                    var token = $("input[name='_token']").val();
                    $.ajax({
                        type:"POST",
                        url : "{{route('payment-overview-chart')}}",
                        data : { 'overviewDate': overviewDate, '_token': token },
                        success : function(response) {
                            $('#overViewPaidAmt').text(response.paidArray.reduce((a, b) => a + b));
                            $('#overViewUnpaidAmt').text(response.unpaidArray.reduce((a, b) => a + b));
                            overViewChart(response.paidArray,response.unpaidArray)
                        },
                        error: function() {
                        }
                    });
                }
            /* ------------------------------> Overview Chart End<------------------------ */


            /* ------------------------------> Overview Filter Start <------------------------ */
                // Overview Filter
                var today = new Date().toISOString().slice(0, 10)
                ajaxCallForOverviewData(today);

                // Overview Filter Onchange Event
                $('#overviewDropdown').change(function() {
                    var overviewDropdownFilter = ($(this).val());
                    ajaxCallForOverviewData(overviewDropdownFilter);
                });

                // Overview Filter Ajax Call
                function ajaxCallForOverviewData(overviewDropdownFilter) {
                    var token = $("input[name='_token']").val();
                    $.ajax({
                        type:"POST",
                        url : "{{route('overview-dropdown-filter')}}",
                        data : { 'overviewDropdownFilter': overviewDropdownFilter, '_token': token },
                        success : function(response) {
                            $('#clientsAdded').text(response.clientAdded);
                            $('#invoiceSent').text(response.invoiceSent);
                            $('#paidInvoice').text(response.paidInvoice);
                            $('#unpaidInvoice').text(response.unpaidInvoice);
                            $('#overviewText').text(response.overviewText);
                        },
                        error: function() {

                        }
                    });
                }
            /* ------------------------------> Overview Filter End <------------------------ */


            /* ------------------------------> Payment Activity Start <------------------------ */
                // Payment Activity
                var currentYear = new Date().getFullYear();
                ajaxCallForPaymentActivityChart(currentYear);

                // Year Onclick Event
                document.getElementById('BarIndexYear').addEventListener('click', function () {
                    var selectedValue = 'current_year';

                    //Change btn class for active
                    parent = document.querySelector('.btnGroup');
                    children = parent.children;
                    Object.entries(children).forEach(([key, value]) => {
                        if(value.classList.contains('btn-info')) {
                            value.classList.remove("btn-info");
                            value.classList.add("btn-soft-info");
                        }
                    })

                    this.classList.add("btn-info");
                    this.classList.remove("btn-soft-info");

                    ajaxCallForPaymentActivityChart(selectedValue);
                });

                // 6 Month Onclick Event
                document.getElementById('BarIndexSixmonth').addEventListener('click', function () {
                    var selectedValue = 'six_months';

                    //Change btn class for active
                    parent = document.querySelector('.btnGroup');
                    children = parent.children;
                    Object.entries(children).forEach(([key, value]) => {
                        if(value.classList.contains('btn-info')) {
                            value.classList.remove("btn-info");
                            value.classList.add("btn-soft-info");
                        }
                    })

                    this.classList.add("btn-info");
                    this.classList.remove("btn-soft-info");
                    ajaxCallForPaymentActivityChart(selectedValue);
                });

                // Single Month Onclick Event
                document.getElementById('BarIndexMonth').addEventListener('click', function () {
                    var selectedValue = 'current_month';

                    //Change btn class for active
                    parent = document.querySelector('.btnGroup');
                    children = parent.children;
                    Object.entries(children).forEach(([key, value]) => {
                        if(value.classList.contains('btn-info')) {
                            value.classList.remove("btn-info");
                            value.classList.add("btn-soft-info");
                        }
                    })

                    this.classList.add("btn-info");
                    this.classList.remove("btn-soft-info");
                    ajaxCallForPaymentActivityChart(selectedValue);
                });
                
                // Payment Activity Ajax Call
                function ajaxCallForPaymentActivityChart(selectedValue) {
                    var token = $("input[name='_token']").val();
                    $.ajax({
                        type:"POST",
                        url : "{{route('payment-activity-chart')}}",
                        data : { 'selectedValue': selectedValue, '_token': token },
                        success : function(response) {
                            $('#paymenActivityPaid').text('Paid: '+'$'+response.paidArray.reduce((a, b) => a + b));
                            $('#paymenActivityUnpaid').text('Unpaid: '+'$'+response.unpaidArray.reduce((a, b) => a + b));
                            paymentActivityChart(response.paidArray,response.unpaidArray)
                        },
                        error: function() {
                        }
                    });
                }
            /* ------------------------------> Payment Activity End <------------------------ */


            /* ------------------------------> World Map Chart Start <------------------------ */

            var latLongArray = document.getElementById('latlongArray').value;
            worldMapChart(latLongArray)

            /* ------------------------------> World Map Chart End <------------------------ */
         })();
        </script>

    @endsection