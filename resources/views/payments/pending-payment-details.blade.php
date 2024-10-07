@extends('layouts.master')
@section('title') {{__('translation.Payments')}} @endsection
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
        @slot('title') {{__('translation.Payments')}} @endslot
        @slot('pagetitle') {{__('translation.Payment List')}} @endslot
    @endcomponent

    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs nav-tabs-custom nav-success mb-3" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link" href="{{url('payment-list')}}" role="tab" aria-selected="true">
                                {{__('translation.All')}}
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{url('paid-payment')}}" role="tab" aria-selected="false">
                                {{__('translation.Paid')}}
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="{{url('pending-payment')}}" role="tab" aria-selected="false">
                                {{__('translation.Pending')}}
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{url('cancel-payment')}}" role="tab" aria-selected="false">
                                {{__('translation.Cancelled')}}
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{url('refunded-payment')}}" role="tab" aria-selected="false">
                                {{__('translation.Refunded')}}
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content text-muted pt-2">
                        <div class="tab-pane active" id="nav-border-top-all" role="tabpanel">
                            <div class="card">
                                <div class="card-body">
                                    <div class="table-responsive table-card">
                                        <table class="table table-hover table-nowrap align-middle mb-0" id="paymentListTable">
                                            <thead class="table-light">
                                                <tr class="text-muted text-uppercase">
                                                    <th scope="col">{{__('translation.Sr. No')}}</th>
                                                    <th scope="col">{{__('translation.Client')}}</th>
                                                    <th scope="col">{{__('translation.Date')}}</th>
                                                    <th scope="col" style="width: 16%;">{{__('translation.Payment Type')}}</th>
                                                    <th scope="col" style="width: 12%;">{{__('translation.Amount')}}</th>
                                                    <th scope="col" style="width: 12%;">{{__('translation.Status')}}</th>
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
                </div><!-- end card-body -->
            </div>
        </div>
    </div>

    @endsection
    @section('scripts')
        <!-- jquery -->
        <script src="{{URL::asset('assets/js/jquery-3.6.4.min.js')}}" ></script>
        <!--datatable js-->
        <script src="{{URL::asset('assets/libs/datatable/jquery.dataTables.min.js')}}"></script>
        <script src="{{URL::asset('assets/libs/datatable/dataTables.bootstrap5.min.js')}}"></script>
        <script>
            //Client form validate 
            (function () {
            'use strict';
            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            var forms = document.querySelectorAll('.needs-validation')
            // Loop over them and prevent submission
            Array.prototype.slice.call(forms)
                .forEach(function (form) {
                form.addEventListener('submit', function (event) {
                    if (!form.checkValidity()) {
                    event.preventDefault()
                    event.stopPropagation()
                    }
                    form.classList.add('was-validated')
                }, false)
                })
            })()

            $(document).ready(function() {
                $('#paymentListTable').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "{{route('pending-payment')}}",
                    columns: [
                        { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                        { data: 'client', name: 'client' },
                        { data: 'date', name: 'date' },
                        { data: 'payment_details', name: 'payment_details' },
                        { data: 'total_amount', name: 'total_amount' },
                        { data: 'payment_status', name: 'payment_status' },
                        { data: 'action', name: 'action', orderable: false, searchable: false },
                    ],
                    pagingType: 'full_numbers',
                    drawCallback: function() {
                        
                    }
                });
            })();
        </script>
    @endsection
