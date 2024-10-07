@extends('layouts.master')
@section('title') Invoice List @endsection
@section('css')
<!--datatable css-->
<link href="{{URL::asset('assets/libs/datatable/dataTables.bootstrap5.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{URL::asset('assets/libs/datatable/buttons.dataTables.min.css')}}" rel="stylesheet" type="text/css" />
<style>
    .dataTables_filter {
        width: calc(25% - 52px);
        float: right;
    }

</style>
@endsection

@section('body')
<body>
    @endsection

    @section('content')

    @component('components.breadcrumb')
    @slot('title') Invoice @endslot
    @slot('pagetitle') Invoice List @endslot
    @endcomponent

    <?php 
        $paidColor = '';
        $paidArrow = '';
        $paidSign = '';
        $unpaidColor = '';
        $unpaidArrow = '';
        $unpaidSign = '';
        $paidInvPercent = '';
        $unpaidInvPercent = '';
        $cancelInvPercent = '';
        if(count($sentInvoices) > 0) {
            $paidInvPercent = round((count($paidInvoices) * 100 / count($sentInvoices)),2);
            $unpaidInvPercent = round((count($pendingInvoices) * 100 / count($sentInvoices)),2);
            $cancelInvPercent = round((count($cancelInvoices) * 100 / count($sentInvoices)),2);

            if($unpaidInvPercent > $paidInvPercent) { $paidSign = '-'; $paidArrow = 'ri-arrow-right-down-line'; $paidColor = 'danger';}else{ $paidSign = '+'; $paidArrow = 'ri-arrow-right-up-line'; $paidColor = 'success'; }

            if($unpaidInvPercent < $paidInvPercent) { $unpaidSign = '-'; $unpaidArrow = 'ri-arrow-right-down-line'; $unpaidColor = 'danger';}else{ $unpaidSign = '+'; $unpaidArrow = 'ri-arrow-right-up-line'; $unpaidColor = 'success'; }
        }
    ?>

    <div class="row">
        <div class="col-xl-3 col-md-6">
            <!-- card -->
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h4 class="fs-22 fw-semibold ff-secondary mb-2">$<span class="counter-value" data-target="{{$totalAmountOfSentInvoices}}">0</span></h4>
                            <p class="text-uppercase fw-medium fs-14 text-muted mb-0">Invoices Sent
                            </p>
                        </div>
                        <div class="avatar-sm flex-shrink-0">
                            <span class="avatar-title bg-light rounded-circle fs-3">
                                <i class="las la-file-alt fs-24 text-primary"></i>
                            </span>
                        </div>
                    </div>
                    <div class="d-flex align-items-end justify-content-between mt-4">
                        <div>
                            <span class="badge bg-primary me-1">{{count($sentInvoices)}}</span> <span class="text-muted">Invoices sent</span>
                        </div>
                    </div>
                </div><!-- end card body -->
            </div><!-- end card -->
        </div><!-- end col -->

        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h4 class="fs-22 fw-semibold ff-secondary mb-2">$<span class="counter-value" data-target="{{$totalAmountOfPaidInvoices}}">0</span></h4>
                            <p class="text-uppercase fw-medium fs-14 text-muted mb-0">Paid Invoices
                                <span class="text-{{$paidColor}} fs-14 mb-0 ms-1">
                                    <i class="{{$paidArrow}} fs-13 align-middle"></i> {{$paidSign}}{{$paidInvPercent}} %
                                </span>
                            </p>
                        </div>
                        <div class="avatar-sm flex-shrink-0">
                            <span class="avatar-title bg-light rounded-circle fs-3">
                                <i class="las la-check-square fs-24 text-primary"></i>
                            </span>
                        </div>
                    </div>
                    <div class="d-flex align-items-end justify-content-between mt-4">
                        <div>
                            <span class="badge bg-primary me-1">{{count($paidInvoices)}}</span> <span class="text-muted">Paid by clients</span>
                        </div>
                    </div>
                </div><!-- end card body -->
            </div><!-- end card -->
        </div><!-- end col -->

        <div class="col-xl-3 col-md-6">
            <div class="card bg-primary">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h4 class="fs-22 fw-semibold ff-secondary mb-2 text-white">$<span class="counter-value" data-target="{{$totalAmountOfPendingInvoices}}">0</span></h4>
                            <p class="text-uppercase fw-medium fs-14 text-white-50 mb-0"> Unpaid Invoices
                                <span class="text-{{$unpaidColor}} fs-14 mb-0 ms-1">
                                    <i class="{{$unpaidArrow}} fs-13 align-middle"></i> {{$unpaidSign}}{{$unpaidInvPercent}} %
                                </span>
                            </p>
                        </div>
                        <div class="avatar-sm flex-shrink-0">
                            <span class="avatar-title bg-soft-light rounded-circle fs-3">
                                <i class="las la-clock fs-24 text-white"></i>
                            </span>
                        </div>
                    </div>
                    <div class="d-flex align-items-end justify-content-between mt-4">
                        <div>
                            <span class="badge bg-danger me-1">{{count($pendingInvoices)}}</span> <span class="text-white">Unpaid by clients</span>
                        </div>
                    </div>
                </div><!-- end card body -->
            </div><!-- end card -->
        </div><!-- end col -->

        <div class="col-xl-3 col-md-6">
            <!-- card -->
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h4 class="fs-22 fw-semibold ff-secondary mb-2">$<span class="counter-value" data-target="{{$totalAmountOfCancelInvoices}}">0</span></h4>
                            <p class="text-uppercase fw-medium fs-14 text-muted mb-0"> Cancelled Invoices
                                <span class="text-success fs-14 mb-0 ms-1">
                                    <i class="ri-arrow-right-up-line fs-13 align-middle"></i> +{{$cancelInvPercent}} %
                                </span>
                            </p>
                        </div>
                        <div class="avatar-sm flex-shrink-0">
                            <span class="avatar-title bg-light rounded-circle fs-3">
                                <i class="las la-times-circle fs-24 text-primary"></i>
                            </span>
                        </div>
                    </div>
                    <div class="d-flex align-items-end justify-content-between mt-4">
                        <div>
                            <span class="badge bg-primary me-1">{{count($cancelInvoices)}}</span> <span class="text-muted">Cancelled by clients</span>
                        </div>
                    </div>
                </div><!-- end card body -->
            </div><!-- end card -->
        </div><!-- end col -->
    </div>

    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive table-card">
                        <table class="table table-hover table-nowrap align-middle mb-0" id="invoiceListTable">
                            <thead>
                                <tr class="text-muted text-uppercase">
                                    <th scope="col">Sr. No</th>
                                    <th scope="col">Invoice Number</th>
                                    <th scope="col">Client Name</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Amount</th>
                                    <th scope="col">Create By</th>
                                    <th scope="col" style="width: 16%;">Payment Status</th>
                                    <th scope="col" style="width: 12%;">Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                {{-- Tabel values are getting from Yajra datatable ajax --}}
                            </tbody><!-- end tbody -->
                        </table><!-- end table -->
                    </div><!-- end table responsive -->
                </div>
            </div>
        </div>
    </div>

    @endsection
    @section('scripts')
    <!-- jquery -->
    <script src="{{URL::asset('assets/js/jquery-3.6.4.min.js')}}"></script>
    <!--datatable js-->
    <script src="{{URL::asset('assets/libs/datatable/jquery.dataTables.min.js')}}"></script>
    <script src="{{URL::asset('assets/libs/datatable/dataTables.bootstrap5.min.js')}}"></script>

    <script>
        //form validate 
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


            $(document).ready(function() {
                $('#invoiceListTable').DataTable({
                    processing: true
                    , serverSide: true
                    , ajax: "{{route('client-invoice-list')}}"
                    , columns: [{
                            data: 'DT_RowIndex'
                            , name: 'DT_RowIndex'
                            , orderable: false
                            , searchable: false
                        }
                        , {
                            data: 'invoice_number'
                            , name: 'invoice_number'
                        }
                        , {
                            data: 'client_id'
                            , name: 'client_id'
                        }
                        , {
                            data: 'date'
                            , name: 'date'
                        }
                        , {
                            data: 'total_amount'
                            , name: 'total_amount'
                        }
                        , {
                            data: 'created_by'
                            , name: 'created_by'
                        }
                        , {
                            data: 'payment_status'
                            , name: 'payment_status'
                        }
                        , {
                            data: 'action'
                            , name: 'action'
                            , orderable: false
                            , searchable: false
                        }
                    , ]
                    , pagingType: 'full_numbers'
                    , drawCallback: function() {}
                });
            });
        })()
    </script>
    @endsection
