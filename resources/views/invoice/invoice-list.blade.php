@extends('layouts.master')
@section('title') {{__('translation.Invoice List')}} @endsection
@section('css')
<!--datatable css-->
<link href="{{URL::asset('assets/libs/datatable/dataTables.bootstrap5.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{URL::asset('assets/libs/datatable/buttons.dataTables.min.css')}}" rel="stylesheet" type="text/css" />
<!-- Sweet Alert css-->
<link href="{{URL::asset('assets/libs/sweetalert2/sweetalert2.min.css')}}" rel="stylesheet" type="text/css" />

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
    @slot('title') {{__('translation.Invoice')}} @endslot
    @slot('pagetitle') {{__('translation.Invoice List')}} @endslot
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
                            <p class="text-uppercase fw-medium fs-14 text-muted mb-0">{{__('translation.Invoice Sent')}}
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
                            <span class="badge bg-primary me-1">{{count($sentInvoices)}}</span> <span class="text-muted">{{__('translation.Invoice Sent')}}</span>
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
                            <p class="text-uppercase fw-medium fs-14 text-muted mb-0">{{__('translation.Paid Invoice')}}
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
                            <span class="badge bg-primary me-1">{{count($paidInvoices)}}</span> <span class="text-muted">{{__('translation.Paid by clients')}}</span>
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
                            <p class="text-uppercase fw-medium fs-14 text-white-50 mb-0"> {{__('translation.Unpaid Invoice')}}
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
                            <span class="badge bg-danger me-1">{{count($pendingInvoices)}}</span> <span class="text-white">{{__('translation.Unpaid by clients')}}</span>
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
                            <p class="text-uppercase fw-medium fs-14 text-muted mb-0"> {{__('translation.Cancelled Invoices')}}
                                <span class="text-success fs-14 mb-0 ms-1">
                                    <i class="fs-13 align-middle"></i> {{$cancelInvPercent}} %
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
                            <span class="badge bg-primary me-1">{{count($cancelInvoices)}}</span> <span class="text-muted">{{__('translation.Cancelled by clients')}} </span>
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
                                    <th scope="col">{{__('translation.Sr. No')}}</th>
                                    <th scope="col">{{__('translation.Invoice Number')}}</th>
                                    <th scope="col">{{__('translation.Client Name')}}</th>
                                    <th scope="col">{{__('translation.Date')}}</th>
                                    <th scope="col">{{__('translation.Amount')}}</th>
                                    <th scope="col">{{__('translation.Create By')}}</th>
                                    <th scope="col" style="width: 16%;">{{__('translation.Payment Status')}}</th>
                                    <th scope="col" style="width: 12%;">{{__('translation.Action')}}</th>
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
    <!-- Sweet Alerts js -->
    <script src="{{URL::asset('assets/libs/sweetalert2/sweetalert2.min.js')}}"></script>

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
                    , ajax: "{{route('invoice-list')}}"
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

            function callModal(invoiceId) {
                var invoiceId = invoiceId;
                if (confirm("Are you sure you want to refund this invoice?")) {
                    window.location.replace('/refund-payment/' + invoiceId);
                } else {
                    return false;
                }
            };

            function callModal(invoiceId) {
                event.preventDefault();
                Swal.fire({
                    title: "Are you sure you want to refund this invoice?"
                    , text: "Once refunded, you will not be able to recover!"
                    , icon: "warning"
                    , showCancelButton: true
                    , confirmButtonColor: '#DD6B55'
                    , confirmButtonText: 'Yes, I am sure!'
                    , cancelButtonText: "No, cancel it!"
                    , closeOnConfirm: false
                    , closeOnCancel: false
                    , dangerMode: true
                , }).then(function(isConfirm) {
                    if (isConfirm.value) {
                        Swal.fire({
                            title: 'Refunded!'
                            , text: 'Invoice refunded successfully!'
                            , icon: 'success'
                        }).then(function() {
                            window.location.replace('/refund-payment/' + invoiceId);
                        });
                    } else {
                        Swal.fire("Cancelled", "Not refunded.", "error");
                    }
                });
            }

            function callConfirmationModal(invoiceId) {
                event.preventDefault();
                Swal.fire({
                    title: "Are you sure you want to delete this invoice?"
                    , text: "Once deleted, you will not be able to recover!"
                    , icon: "warning"
                    , showCancelButton: true
                    , confirmButtonColor: '#DD6B55'
                    , confirmButtonText: 'Yes, I am sure!'
                    , cancelButtonText: "No, cancel it!"
                    , closeOnConfirm: false
                    , closeOnCancel: false
                    , dangerMode: true
                , }).then(function(isConfirm) {
                    if (isConfirm.value) {
                        Swal.fire({
                            title: 'Deleted!'
                            , text: 'Invoice deleted successfully!'
                            , icon: 'success'
                        }).then(function() {
                            window.location.replace('/delete-invoice/' + invoiceId);
                        });
                    } else {
                        Swal.fire("Cancelled", "Not refunded.", "error");
                    }
                });
            }
        })()

    </script>
    @endsection
