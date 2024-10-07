@extends('layouts.master')
@section('title') {{__('translation.Discount')}} @endsection
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
    @slot('title') {{__('translation.Tax')}} @endslot
    @slot('pagetitle') {{__('translation.Discount List')}} @endslot
    @endcomponent

    <div class="row pb-4 gy-3">
        <div class="col-sm-4">
            <button class="btn btn-primary addtax-modal" data-bs-toggle="modal" data-bs-target="#addtaxModal"><i class="las la-plus me-1"></i> {{__('translation.Add Discount')}}</button>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive table-card">
                        <table class="table table-hover table-nowrap align-middle mb-0" id="discountListTable">
                            <thead>
                                <tr class="text-muted text-uppercase">
                                    <th scope="col">{{__('translation.Sr. No')}}</th>
                                    <th scope="col">{{__('translation.Name')}}</th>
                                    <th scope="col" style="width: 16%;">{{__('translation.Discount')}}(%)</th>
                                    <th scope="col" style="width: 12%;">{{__('translation.Created At')}}</th>
                                    <th scope="col" style="width: 12%;">{{__('translation.Status')}}</th>
                                    <th scope="col" style="width: 12%;">{{__('translation.Action')}}</th>
                                </tr>
                            </thead>

                            <tbody>
                                {{-- Tabel values are getting from Yajra datatable ajax --}}
                            </tbody><!-- end tbody -->
                        </table><!-- end table -->

                        @foreach($discount as $key => $discount)
                        <input type="hidden" id="name_{{$discount->id}}" value="{{@$discount->name}}">
                        <input type="hidden" id="rate_{{$discount->id}}" value="{{@$discount->rate}}">
                        @endforeach
                    </div><!-- end table responsive -->
                </div>
            </div>

        </div>
    </div>

    <!-- Add Modal -->
    <div class="modal fade" id="addtaxModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0">
                <div class="modal-header p-4 pb-0">
                    <h5 class="modal-title" id="createMemberLabel">{{__('translation.Add Discount')}}</h5>
                    <button type="button" class="btn-close" id="createMemberBtn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <form method="post" action="{{url('add-discount')}}" autocomplete="off" id="taxform" class="needs-validation" novalidate>
                        @csrf
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label for="discountName" class="form-label">{{__('translation.Name')}}<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="discountName" id="discountName" placeholder="Enter discount name" required>

                                    @error('discountName')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="discountRate" class="form-label">{{__('translation.Rate')}} (In %)<span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" id="discountRate" name="discountRate" placeholder="Enter discount rate" required>

                                    @error('discountRate')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>


                                <div class="hstack gap-2 justify-content-end">
                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">{{__('translation.Close')}}</button>
                                    <button type="submit" class="btn btn-success" id="addNewTax">{{__('translation.Add Discount')}}</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!--end modal-content-->
        </div>
        <!--end modal-dialog-->
    </div>
    <!--end modal-->

    <!-- Edit Modal -->
    <div class="modal fade" id="editTaxModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0">
                <div class="modal-header p-4 pb-0">
                    <h5 class="modal-title" id="createMemberLabel">{{__('translation.Edit Discount')}}</h5>
                    <button type="button" class="btn-close" id="createMemberBtn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <form method="post" action="{{url('update-discount')}}" autocomplete="off" id="taxform" class="needs-validation" novalidate>
                        @csrf
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label for="editDiscountName" class="form-label">{{__('translation.Name')}}<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="discountName" id="editDiscountName" placeholder="Enter discount name" required>
                                    <input type="hidden" name="discountId" id="discountId">

                                    @error('discountName')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="editDiscountRate" class="form-label">{{__('translation.Rate')}} (In %)<span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" id="editDiscountRate" name="discountRate" placeholder="Enter discount rate" required>

                                    @error('discountRate')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="hstack gap-2 justify-content-end">
                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">{{__('translation.Close')}}</button>
                                    <button type="submit" class="btn btn-success" id="addNewTax">{{__('translation.Update Discount')}}</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!--end modal-content-->
        </div>
        <!--end modal-dialog-->
    </div>
    <!--end modal-->

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
        //Client form validate 
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
                $('#discountListTable').DataTable({
                    processing: true
                    , serverSide: true
                    , ajax: "{{route('discount-list')}}"
                    , columns: [{
                            data: 'DT_RowIndex'
                            , name: 'DT_RowIndex'
                            , orderable: false
                            , searchable: false
                        }
                        , {
                            data: 'name'
                            , name: 'name'
                        }
                        , {
                            data: 'rate'
                            , name: 'rate'
                        }
                        , {
                            data: 'created_at'
                            , name: 'created_at'
                        }
                        , {
                            data: 'status'
                            , name: 'status'
                        }
                        , {
                            data: 'action'
                            , name: 'action'
                            , orderable: false
                            , searchable: false
                        }
                    , ]
                    , pagingType: 'full_numbers'
                    , drawCallback: function() {
                        editTaxData();
                    }
                });
            });

            function editTaxData(taxId) {
                if (taxId) {
                    document.getElementById('editDiscountName').value = document.getElementById('name_' + taxId).value;
                    document.getElementById('editDiscountRate').value = document.getElementById('rate_' + taxId).value;
                    document.getElementById("discountId").value = taxId;
                }
            }

            setTimeout(function() {
                var editButtons = document.getElementsByClassName("edit-button");

                for (var i = 0; i < editButtons.length; i++) {
                    editButtons[i].addEventListener("click", function(e) {
                        if (e.target.hasAttribute("data-edit-id")) {
                            var taxId = e.target.getAttribute("data-edit-id");
                            editTaxData(taxId);
                        } else {
                            var taxId = e.target.parentElement.getAttribute("data-edit-id");
                            editTaxData(taxId);
                        }

                    });
                }

                
                var removeBtn = document.getElementsByClassName("remove-btn");
                for (var i = 0; i < removeBtn.length; i++) {
                    removeBtn[i].addEventListener("click", function(e) {
                        if (e.target.hasAttribute("data-remove-id")) {
                            var discountId = e.target.getAttribute("data-remove-id");
                            callConfirmationModal(discountId);
                        } else {
                            var discountId = e.target.parentElement.getAttribute("data-remove-id");
                            callConfirmationModal(discountId);
                        }

                    });
                }
            }, 500)


            function callConfirmationModal(discountId) {
                event.preventDefault();
                Swal.fire({
                    title: "Are you sure you want to delete this discount?"
                    , text: "Once deleted, you will not be able to recover this record!"
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
                            , text: 'Discount is deleted successfully!'
                            , icon: 'success'
                        }).then(function() {
                            window.location.href = 'delete-discount/' + discountId;
                        });
                    } else {
                        Swal.fire("Cancelled", "Your discount is safe.", "error");
                    }
                });
            }
        })()

    </script>
    @endsection
