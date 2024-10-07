@extends('layouts.master')
@section('title') Dashboard @endsection
@section('css')
<!-- flatpicker css -->
<link rel="stylesheet" href="{{URL::asset('assets/libs/flatpickr/flatpickr.min.js')}}">
@endsection

@section('body') 
    <body> 
@endsection

    @section('content')

    @component('components.breadcrumb')
        @slot('title') Dashboard @endslot
        @slot('pagetitle') Dashboard @endslot
    @endcomponent

    <div class="row">
        <div class="col-xl-5">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center gy-4">
                        <div class="col-sm-8">
                            <div class="box">
                                <h5 class="fs-20 text-truncate">Professional Invoices Made Easy.</h5>
                                <p class="text-muted fs-15">Quickly understand who your best customers little and motivation to pay thair bills.</p>
                                <a href="" class="btn btn-primary">Warch Tutorial</a>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="text-center px-2">
                                <img src="assets/images/invoice-widget.png" class="img-fluid invoice-widget" alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-7">
            <div class="card dash-mini">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">This Week's Overview</h4>
                    <div class="flex-shrink-0">
                        <div class="dropdown card-header-dropdown">
                            <a class="text-reset" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="fw-semibold text-uppercase fs-14">Sort by: </span><span class="text-muted">Current Week<i class="las la-angle-down fs-12 ms-2"></i></span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a class="dropdown-item" href="#">Today</a>
                                <a class="dropdown-item" href="#">Last Week</a>
                                <a class="dropdown-item" href="#">Last Month</a>
                                <a class="dropdown-item" href="#">Current Year</a>
                            </div>
                        </div>
                    </div>
                </div><!-- end card header -->

                <div class="card-body pt-1">
                    <div class="row">
                        <div class="col-lg-4 mini-widget pb-3 pb-lg-0">
                            <div class="d-flex align-items-end">
                                <div class="flex-grow-1">
                                    <h2 class="mb-0 fs-24"><span class="counter-value" data-target="197">54</span></h2>
                                    <h5 class="text-muted fs-16 mt-2 mb-0">Clients Added</h5>
                                    <p class="text-muted mt-3 pt-1 mb-0 text-truncate"> <span class="badge bg-info me-1">1.15%</span>  since last week</p>
                                </div>
                                <div class="flex-shrink-0 text-end dash-widget">
                                    <div id="mini-chart1" data-colors='["--in-primary", "--in-light"]' class="apex-charts"></div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 mini-widget py-3 py-lg-0">
                            <div class="d-flex align-items-end">
                                <div class="flex-grow-1">
                                    <h2 class="mb-0 fs-24"><span class="counter-value" data-target="634">124</span></h2>
                                    <h5 class="text-muted fs-16 mt-2 mb-0">Contracts Signed</h5>
                                    <p class="text-muted mt-3 pt-1 mb-0 text-truncate"> <span class="badge bg-danger me-1">1.15%</span>  since last week</p>
                                </div>
                                <div class="flex-shrink-0 text-end dash-widget">
                                    <div id="mini-chart2" data-colors='["--in-primary", "--in-light"]' class="apex-charts"></div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 mini-widget pt-3 pt-lg-0">
                            <div class="d-flex align-items-end">
                                <div class="flex-grow-1">
                                    <h2 class="mb-0 fs-24"><span class="counter-value" data-target="512">214</span></h2>
                                    <h5 class="text-muted fs-16 mt-2 mb-0">Invoice Sent</h5>
                                    <p class="text-muted mt-3 pt-1 mb-0 text-truncate"> <span class="badge bg-info me-1">3.14%</span>  since last week</p>
                                </div>
                                <div class="flex-shrink-0 text-end dash-widget">
                                    <div id="mini-chart3" data-colors='["--in-primary", "--in-light"]' class="apex-charts"></div>
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
                    <h4 class="card-title mb-0 flex-grow-1">Payment Activity</h4>
                    <div>
                        <button type="button" class="btn btn-soft-info btn-sm">
                            ALL
                        </button>
                        <button type="button" class="btn btn-soft-info btn-sm">
                            1M
                        </button>
                        <button type="button" class="btn btn-soft-info btn-sm">
                            6M
                        </button>
                        <button type="button" class="btn btn-info btn-sm">
                            1Y
                        </button>
                    </div>
                </div>
                <div class="card-body py-1">
                    <div class="row gy-2">
                        <div class="col-md-4">
                            <h4 class="fs-22 mb-0">$23,590.00</h4>
                        </div>
                        <div class="col-md-8">
                            <div class="d-flex main-chart justify-content-end">
                                <div class="px-4 border-end">
                                    <h4 class="text-primary fs-22 mb-0">$584k <span class="text-muted d-inline-block fs-17 align-middle ms-0 ms-sm-2">Incomes</span></h4>
                                </div>
                                <div class="ps-4">
                                    <h4 class="text-primary fs-22 mb-0">$324k <span class="text-muted d-inline-block fs-17 align-middle ms-0 ms-sm-2">Expenses</span></h4>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="stacked-column-chart" class="apex-charts" data-colors='["--in-primary", "--in-light"]' dir="ltr"></div>
                </div>
            </div>
        </div>
        <div class="col-xl-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-start">
                        <div class="flex-grow-1 overflow-hidden">
                            <h5 class="card-title mb-2 text-truncate">Structure</h5>
                        </div>
                        <div class="flex-shrink-0 ms-2">
                            <div class="dropdown">
                                <input type="date" class="form-control" id="structureDatePicker" name="structureDatePicker" placeholder="Select date range">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            </div>
                        </div>
                    </div>

                    <div id="structure-widget" data-colors='["--in-primary", "--in-primary-rgb, 0.7", "--in-light"]' class="apex-charts" dir="ltr"></div> 

                    <div class="px-2">
                        <div class="structure-list d-flex justify-content-between border-bottom">
                            <p class="mb-0"><i class="las la-dot-circle fs-18 text-primary me-2"></i>Paid</p>
                            <div>
                                <span class="badge bg-primary" id="paidAmt"> ${{$totalAmountOfPaidInvoices}} </span>
                                <input type="hidden" id="paidAmount" value="{{$totalAmountOfPaidInvoices}}">
                            </div>
                        </div>
                        <div class="structure-list d-flex justify-content-between border-bottom">
                            <p class="mb-0"><i class="las la-dot-circle fs-18 text-primary me-2"></i>Unpaid</p>
                            <div>
                                <span class="badge bg-primary" id="pendingAmt"> ${{$totalAmountOfPendingInvoices}} </span>
                                <input type="hidden" id="pendingAmount" value="{{$totalAmountOfPendingInvoices}}">
                            </div>
                        </div>
                        <div class="structure-list d-flex justify-content-between pb-0">
                            <p class="mb-0"><i class="las la-dot-circle fs-18 text-primary me-2"></i>Cancelled</p>
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
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Quick Invoice</h4>
                    <div>
                        <button type="button" class="btn btn-soft-secondary btn-sm">
                        <i class="las la-plus fs-18 align-middle"></i>
                        </button>
                        
                    </div>
                </div>

                <div class="card-body pt-0">
                    <form>
                        <div class="row">
                            <div class="col-xl-6">
                                <div class="mb-3">
                                    <label>Customer Name</label>
                                    <input type="text" placeholder="Enter name" class="form-control">
                                </div>
                            </div>

                            <div class="col-xl-6">
                                <div class="mb-3">
                                    <label>Customer Email</label>
                                    <input type="text" placeholder="Enter email" class="form-control">
                                </div>
                            </div>

                            <div class="col-xl-12">
                                <div class="mb-3">
                                    <label for="companyAddress">Customer Address</label>
                                    <textarea class="form-control" id="companyAddress" rows="2" placeholder="Company Address" required=""></textarea>
                                </div>
                            </div>
                        </div>

                        <table class="table table-sm table-borderless table-nowrap align-middle mb-0">
                            <tbody>
                                <tr>
                                    <td>Sub Total</td>
                                    <td class="text-end">$0.00</td>
                                </tr>
                                <tr>
                                    <td>Estimated Tax (12.5%)</td>
                                    <td class="text-end">$0.00</td>
                                </tr>
                                <tr>
                                    <td>Discount <small class="text-muted">(Invoika15)</small></td>
                                    <td class="text-end">- $0.00</td>
                                </tr>
                                <tr>
                                    <td>Shipping Charge</td>
                                    <td class="text-end">$0.00</td>
                                </tr>
                                <tr class="border-top border-top-dashed fs-15">
                                    <th scope="row">Total Amount</th>
                                    <th class="text-end">$0.00</th>
                                </tr>
                            </tbody>
                        </table>

                        <div class="row mt-2">
                            <div class="col-6">
                                <a href="" class="btn btn-light w-100">Add More Details</a>
                            </div>
                            <div class="col-6">
                                <a href="" class="btn btn-primary w-100">Send Money</a>
                            </div>
                        </div>

                        
                    </form>
                </div>
            </div>
        </div>
        <div class="col-xl-4">
            <div class="card">
                <div class="card-header align-items-center d-flex pb-2">
                    <h4 class="card-title mb-0 flex-grow-1">Payment Overview</h4>
                </div>
                <div class="card-body pt-0">
                    <div id="payment-overview" data-colors='["--in-primary", "--in-light"]' class="apex-charts" dir="ltr"></div>  
                    <div class="row mt-3 text-center">
                        <div class="col-6 border-end">
                            <div class="my-1">
                                <p class="text-muted text-truncate mb-2">Paid Amount</p>
                                <h4 class="mt-2 mb-0 fs-20">$45,070.00</h4>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="my-1">
                                <p class="text-muted text-truncate mb-2">Unpaid Amount</p>
                                <h4 class="mt-2 mb-0 fs-20">$32,400.00</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-start mb-1">
                        <div class="flex-grow-1">
                            <h5 class="card-title">Recent Transaction</h5>
                        </div>
                        <div class="flex-shrink-0">
                            <div class="dropdown">
                                <a class="text-muted" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="las la-ellipsis-h fs-20"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <a class="dropdown-item" href="#">Yearly</a>
                                    <a class="dropdown-item" href="#">Monthly</a>
                                    <a class="dropdown-item" href="#">Weekly</a>
                                    <a class="dropdown-item" href="#">Today</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mx-n3 px-3 recent-transaction" data-simplebar>
                    
                            <p class="text-muted mb-0">Recent</p>
                            <div class="border-bottom sales-history">
                                <div class="d-flex align-items-center">
                                    <div class="avatar-sm flex-shrink-0">
                                        <span class="avatar-title bg-primary rounded-circle fs-3">
                                            <i class="lab la-paypal fs-22"></i>
                                        </span>
                                    </div>
                                    <div class="flex-grow-1 ms-3 overflow-hidden">
                                        <h5 class="fs-15 mb-1 text-truncate">Salary Payment</h5>
                                        <p class="fs-14 text-muted text-truncate mb-0">20 Sep, 2022</p>
                                    </div>
                                    <div class="flex-shrink-0">
                                        <span class="badge fs-12 badge-soft-danger">- $62.45</span>
                                    </div>
                                </div>
                            </div>

                            <div class="border-bottom sales-history">
                                <div class="d-flex align-items-center">
                                    <div class="avatar-sm flex-shrink-0">
                                        <span class="avatar-title bg-primary rounded-circle fs-3">
                                            <i class="lab la-buffer fs-22"></i>
                                        </span>
                                    </div>
                                    <div class="flex-grow-1 ms-3 overflow-hidden">
                                        <h5 class="fs-15 mb-1 text-truncate">Online Product</h5>
                                        <p class="fs-14 text-muted text-truncate mb-0">28 Mar, 2022</p>
                                    </div>
                                    <div class="flex-shrink-0">
                                        <span class="badge fs-12 badge-soft-success">+ $45.84</span>
                                    </div>
                                </div>
                            </div>

                            <p class="text-muted mt-3 mb-0">Yesterday</p>

                            <div class="border-bottom sales-history">
                                <div class="d-flex align-items-center">
                                    <div class="avatar-sm flex-shrink-0">
                                        <span class="avatar-title bg-primary rounded-circle fs-3">
                                            <i class="las la-file-image fs-22"></i>
                                        </span>
                                    </div>
                                    <div class="flex-grow-1 ms-3 overflow-hidden">
                                        <h5 class="fs-15 mb-1 text-truncate">Maintenance</h5>
                                        <p class="fs-14 text-muted text-truncate mb-0">18 Sep, 2022</p>
                                    </div>
                                    <div class="flex-shrink-0">
                                        <span class="badge fs-12 badge-soft-success">+ $25.52</span>
                                    </div>
                                </div>
                            </div>

                            <div class="border-bottom sales-history">
                                <div class="d-flex align-items-center">
                                    <div class="avatar-sm flex-shrink-0">
                                        <span class="avatar-title bg-primary rounded-circle fs-3">
                                            <i class="las la-bus fs-22"></i>
                                        </span>
                                    </div>
                                    <div class="flex-grow-1 ms-3 overflow-hidden">
                                        <h5 class="fs-15 mb-1 text-truncate">Bus Booking</h5>
                                        <p class="fs-14 text-muted text-truncate mb-0">30 Nov, 2022</p>
                                    </div>
                                    <div class="flex-shrink-0">
                                        <span class="badge fs-12 badge-soft-danger">- $84.45</span>
                                    </div>
                                </div>
                            </div>

                            <div class="border-bottom sales-history">
                                <div class="d-flex align-items-center">
                                    <div class="avatar-sm flex-shrink-0">
                                        <span class="avatar-title bg-primary rounded-circle fs-3">
                                            <i class="lab la-telegram-plane fs-22"></i>
                                        </span>
                                    </div>
                                    <div class="flex-grow-1 ms-3 overflow-hidden">
                                        <h5 class="fs-15 mb-1 text-truncate">Flight Booking</h5>
                                        <p class="fs-14 text-muted text-truncate mb-0">12 Feb, 2022</p>
                                    </div>
                                    <div class="flex-shrink-0">
                                        <span class="badge fs-12 badge-soft-success">+ $53.23</span>
                                    </div>
                                </div>
                            </div>

                            <div class="pb-0 sales-history">
                                <div class="d-flex align-items-center">
                                    <div class="avatar-sm flex-shrink-0">
                                        <span class="avatar-title bg-primary rounded-circle fs-3">
                                            <i class="las la-store-alt fs-22"></i>
                                        </span>
                                    </div>
                                    <div class="flex-grow-1 ms-3 overflow-hidden">
                                        <h5 class="fs-15 mb-1 text-truncate">Office Rent</h5>
                                        <p class="fs-14 text-muted text-truncate mb-0">12 Arl, 2022</p>
                                    </div>
                                    <div class="flex-shrink-0">
                                        <span class="badge fs-12 badge-soft-success">+ $42.63</span>
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
        </div>

        
    </div>

    <div class="row">
        <div class="col-xl-7">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Sales Revenue</h4>
                    <div class="dropdown">
                        <a class="text-reset" href="#" id="dropdownMenuYear" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="fw-semibold text-uppercase fs-14">Sort By: </span> <span class="text-muted">Years<i class="las la-angle-down fs-12 ms-2"></i></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuYear">
                            <a class="dropdown-item" href="#">Monthly</a>
                            <a class="dropdown-item" href="#">Yearly</a>
                        </div>
                    </div>
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
                                                <th style="width: 500px;">Countrie</th>
                                                <th style="width: 30%;">Order</th>
                                                <th style="width: 15%;">Earning</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <img src="assets/images/flags/us.svg" class="rounded" alt="user-image" height="22">
                                                        <div class="flex-grow-1 ms-3">
                                                            <p class="mb-0 text-truncate">US</p>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>6253</td>
                                                <td>$26,524</td>
                                            </tr>

                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <img src="assets/images/flags/italy.svg" class="rounded" alt="user-image" height="22">
                                                        <div class="flex-grow-1 ms-3">
                                                            <p class="mb-0 text-truncate">Italy</p>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>5563</td>
                                                <td>$32,562</td>
                                            </tr>

                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <img src="assets/images/flags/spain.svg" class="rounded" alt="user-image" height="22">
                                                        <div class="flex-grow-1 ms-3">
                                                            <p class="mb-0 text-truncate">Spain</p>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>3258</td>
                                                <td>$65,214</td>
                                            </tr>

                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <img src="assets/images/flags/french.svg" class="rounded" alt="user-image" height="22">
                                                        <div class="flex-grow-1 ms-3">
                                                            <p class="mb-0 text-truncate">French</p>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>6325</td>
                                                <td>$63,254</td>
                                            </tr>

                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <img src="assets/images/flags/russia.svg" class="rounded" alt="user-image" height="22">
                                                        <div class="flex-grow-1 ms-3">
                                                            <p class="mb-0 text-truncate">Russia</p>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>8652</td>
                                                <td>$53,621</td>
                                            </tr>

                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <img src="assets/images/flags/ae.svg" class="rounded" alt="user-image" height="22">
                                                        <div class="flex-grow-1 ms-3">
                                                            <p class="mb-0 text-truncate">Arabic</p>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>4256</td>
                                                <td>$86,526</td>
                                            </tr>
                                        
                                        </tbody>
                                    </table>
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-5">
        <div class="card">
            <div class="card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1">Invoice List</h4>
                <div class="dropdown">
                    <a class="text-reset" href="#" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="fw-semibold text-uppercase fs-14">Sort By: </span>  <span class="text-muted">Weekly<i class="las la-angle-down fs-12 ms-2"></i></span>
                        
                    </a>
                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton1">
                        <a class="dropdown-item" href="#">Monthly</a>
                        <a class="dropdown-item" href="#">Yearly</a>
                    </div>
                </div>
            </div>
            <div class="card-body pt-2">
                <div class="table-responsive table-card">
                    <table class="table table-striped table-nowrap align-middle mb-0">
                        <thead>
                            <tr class="text-muted text-uppercase">
                                <th style="width: 50px;">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="checkAll" value="option">
                                    </div>
                                </th>
                                <th scope="col">Invoice ID</th>
                                <th scope="col">Client</th>
                                <th scope="col">Date</th>
                                <th scope="col" style="width: 16%;">Status</th>
                                <th scope="col" style="width: 12%;">Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="check1" value="option">
                                    </div>
                                </td>
                                <td><p class="mb-0">Lec-2152</p></td>
                                <td><img src="assets/images/users/avatar-1.jpg" alt="" class="avatar-xs rounded-circle me-2">
                                    <a href="#javascript: void(0);" class="text-body align-middle">Donald Risher</a>
                                </td>
                                <td>20 Sep, 2022</td>
                                <td><span class="badge badge-soft-success p-2">Paid</span></td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="las la-ellipsis-h align-middle fs-18"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            <li>
                                                <button class="dropdown-item" href="javascript:void(0);"><i class="las la-eye fs-18 align-middle me-2 text-muted"></i>
                                                    View</button>
                                            </li>
                                            <li>
                                                <button class="dropdown-item" href="javascript:void(0);"><i class="las la-pen fs-18 align-middle me-2 text-muted"></i>
                                                    Edit</button>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" href="javascript:void(0);"><i class="las la-file-download fs-18 align-middle me-2 text-muted"></i>
                                                    Download</a>
                                            </li>
                                            <li class="dropdown-divider"></li>
                                            <li>
                                                <a class="dropdown-item remove-item-btn" href="#">
                                                    <i class="las la-trash-alt fs-18 align-middle me-2 text-muted"></i>
                                                    Delete
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="check2" value="option">
                                    </div>
                                </td>
                                <td><p class="mb-0">Lec-2153</p></td>
                                <td><img src="assets/images/users/avatar-2.jpg" alt="" class="avatar-xs rounded-circle me-2">
                                    <a href="#javascript: void(0);" class="text-body align-middle">Brody Holman</a>
                                </td>
                                <td>12 Arl, 2022</td>
                                <td><span class="badge badge-soft-warning p-2">Unpaid</span></td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="las la-ellipsis-h align-middle fs-18"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            <li>
                                                <button class="dropdown-item" href="javascript:void(0);"><i class="las la-eye fs-18 align-middle me-2 text-muted"></i>
                                                    View</button>
                                            </li>
                                            <li>
                                                <button class="dropdown-item" href="javascript:void(0);"><i class="las la-pen fs-18 align-middle me-2 text-muted"></i>
                                                    Edit</button>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" href="javascript:void(0);"><i class="las la-file-download fs-18 align-middle me-2 text-muted"></i>
                                                    Download</a>
                                            </li>
                                            <li class="dropdown-divider"></li>
                                            <li>
                                                <a class="dropdown-item remove-item-btn" href="#">
                                                    <i class="las la-trash-alt fs-18 align-middle me-2 text-muted"></i>
                                                    Delete
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="check3" value="option">
                                    </div>
                                </td>
                                <td><p class="mb-0">Lec-2154</p></td>
                                <td><img src="assets/images/users/avatar-3.jpg" alt="" class="avatar-xs rounded-circle me-2">
                                    <a href="#javascript: void(0);" class="text-body align-middle">Jolie Hood</a>
                                </td>
                                <td>28 Mar, 2022</td>
                                <td><span class="badge badge-soft-success p-2">Paid</span></td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="las la-ellipsis-h align-middle fs-18"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            <li>
                                                <button class="dropdown-item" href="javascript:void(0);"><i class="las la-eye fs-18 align-middle me-2 text-muted"></i>
                                                    View</button>
                                            </li>
                                            <li>
                                                <button class="dropdown-item" href="javascript:void(0);"><i class="las la-pen fs-18 align-middle me-2 text-muted"></i>
                                                    Edit</button>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" href="javascript:void(0);"><i class="las la-file-download fs-18 align-middle me-2 text-muted"></i>
                                                    Download</a>
                                            </li>
                                            <li class="dropdown-divider"></li>
                                            <li>
                                                <a class="dropdown-item remove-item-btn" href="#">
                                                    <i class="las la-trash-alt fs-18 align-middle me-2 text-muted"></i>
                                                    Delete
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="check5" value="option">
                                    </div>
                                </td>
                                <td><p class="mb-0">Lec-2156</p></td>
                                <td><img src="assets/images/users/avatar-5.jpg" alt="" class="avatar-xs rounded-circle me-2">
                                    <a href="#javascript: void(0);" class="text-body align-middle">Howard Lyons</a>
                                </td>
                                <td>18 Sep, 2022</td>
                                <td><span class="badge badge-soft-info p-2">Refund</span></td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="las la-ellipsis-h align-middle fs-18"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            <li>
                                                <button class="dropdown-item" href="javascript:void(0);"><i class="las la-eye fs-18 align-middle me-2 text-muted"></i>
                                                    View</button>
                                            </li>
                                            <li>
                                                <button class="dropdown-item" href="javascript:void(0);"><i class="las la-pen fs-18 align-middle me-2 text-muted"></i>
                                                    Edit</button>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" href="javascript:void(0);"><i class="las la-file-download fs-18 align-middle me-2 text-muted"></i>
                                                    Download</a>
                                            </li>
                                            <li class="dropdown-divider"></li>
                                            <li>
                                                <a class="dropdown-item remove-item-btn" href="#">
                                                    <i class="las la-trash-alt fs-18 align-middle me-2 text-muted"></i>
                                                    Delete
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="check6" value="option">
                                    </div>
                                </td>
                                <td><p class="mb-0">Lec-2157</p></td>
                                <td><img src="assets/images/users/avatar-6.jpg" alt="" class="avatar-xs rounded-circle me-2">
                                    <a href="#javascript: void(0);" class="text-body align-middle">Howard Oneal</a>
                                </td>
                                <td>12 Feb, 2022</td>
                                <td><span class="badge badge-soft-success p-2">Paid</span></td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="las la-ellipsis-h align-middle fs-18"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            <li>
                                                <button class="dropdown-item" href="javascript:void(0);"><i class="las la-eye fs-18 align-middle me-2 text-muted"></i>
                                                    View</button>
                                            </li>
                                            <li>
                                                <button class="dropdown-item" href="javascript:void(0);"><i class="las la-pen fs-18 align-middle me-2 text-muted"></i>
                                                    Edit</button>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" href="javascript:void(0);"><i class="las la-file-download fs-18 align-middle me-2 text-muted"></i>
                                                    Download</a>
                                            </li>
                                            <li class="dropdown-divider"></li>
                                            <li>
                                                <a class="dropdown-item remove-item-btn" href="#">
                                                    <i class="las la-trash-alt fs-18 align-middle me-2 text-muted"></i>
                                                    Delete
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="check7" value="option">
                                    </div>
                                </td>
                                <td><p class="mb-0">Lec-2158</p></td>
                                <td><img src="assets/images/users/avatar-7.jpg" alt="" class="avatar-xs rounded-circle me-2">
                                    <a href="#javascript: void(0);" class="text-body align-middle">Jena Hall</a>
                                </td>
                                <td>30 Nov, 2022</td>
                                <td><span class="badge badge-soft-danger p-2">Cancel</span></td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="las la-ellipsis-h align-middle fs-18"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            <li>
                                                <button class="dropdown-item" href="javascript:void(0);"><i class="las la-eye fs-18 align-middle me-2 text-muted"></i>
                                                    View</button>
                                            </li>
                                            <li>
                                                <button class="dropdown-item" href="javascript:void(0);"><i class="las la-pen fs-18 align-middle me-2 text-muted"></i>
                                                    Edit</button>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" href="javascript:void(0);"><i class="las la-file-download fs-18 align-middle me-2 text-muted"></i>
                                                    Download</a>
                                            </li>
                                            <li class="dropdown-divider"></li>
                                            <li>
                                                <a class="dropdown-item remove-item-btn" href="#">
                                                    <i class="las la-trash-alt fs-18 align-middle me-2 text-muted"></i>
                                                    Delete
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        </tbody><!-- end tbody -->
                    </table><!-- end table -->
                </div><!-- end table responsive -->

            </div>
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
            var paidAmount = Number(document.getElementById("paidAmount").value);
            var pendingAmount = Number(document.getElementById("pendingAmount").value);
            var cancelledAmount = Number(document.getElementById("cancelledAmount").value);
            structureChart(paidAmount,pendingAmount,cancelledAmount)

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

        })();
        </script>

    @endsection