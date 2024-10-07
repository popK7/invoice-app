@extends('layouts.master')
@section('title') {{__('translation.Brand')}} @endsection
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
    @slot('title') {{__('translation.Brand')}} @endslot
    @slot('pagetitle') {{__('translation.Brand List')}} @endslot
    @endcomponent

    <div class="row pb-4 gy-3">
        <div class="col-sm-4">
            <button class="btn btn-primary addbrand-modal" data-bs-toggle="modal" data-bs-target="#addbrandModal"><i class="las la-plus me-1"></i> {{__('translation.Add Brand')}}</button>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive table-card">
                        <table class="table table-hover table-nowrap align-middle mb-0" id="brandListTable">
                            <thead>
                                <tr class="text-muted text-uppercase">
                                    <th scope="col">{{__('translation.Sr. No')}}</th>
                                    <th scope="col">{{__('translation.Brand Name')}}</th>
                                    <th scope="col" style="width: 20%;">{{__('translation.Created At')}}</th>
                                    <th scope="col" style="width: 20%;">{{__('translation.Action')}}</th>
                                </tr>
                            </thead>

                            <tbody>
                                {{-- Tabel values are getting from Yajra datatable ajax --}}
                            </tbody><!-- end tbody -->
                        </table><!-- end table -->

                        @foreach($brands as $key => $brand)
                        <input type="hidden" id="name_{{$brand->id}}" value="{{@$brand->name}}">
                        @endforeach
                    </div><!-- end table responsive -->
                </div>
            </div>

        </div>
    </div>

    <!-- Add Modal -->
    <div class="modal fade" id="addbrandModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0">
                <div class="modal-header p-4 pb-0">
                    <h5 class="modal-title" id="createMemberLabel">{{__('translation.Add Brand')}}</h5>
                    <button type="button" class="btn-close" id="createMemberBtn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <form method="post" action="{{url('add-brand')}}" autocomplete="off" id="brandform" class="needs-validation" novalidate>
                        @csrf
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label for="brandName" class="form-label">{{__('translation.Brand Name')}}<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('brand_name') is-invalid @enderror" name="brand_name" id="brandName" placeholder="Enter Brand Name" required>

                                    @error('brand_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="hstack gap-2 justify-content-end">
                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">{{__('translation.Close')}}</button>
                                    <button type="submit" class="btn btn-success" id="addNewBrnad">{{__('translation.Add Brand')}}</button>
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
    <div class="modal fade" id="editBrandModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0">
                <div class="modal-header p-4 pb-0">
                    <h5 class="modal-title" id="createMemberLabel">{{__('translation.Edit Brand')}}</h5>
                    <button type="button" class="btn-close" id="createMemberBtn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <form method="post" action="{{url('update-brand')}}" autocomplete="off" id="brandform" class="needs-validation" novalidate>
                        @csrf
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label for="editBrandName" class="form-label">{{__('translation.Brand Name')}}<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="brand_name" id="editBrandName" placeholder="Enter Brand Name" required>
                                    <input type="hidden" name="brandId" id="brandId">
                                </div>
                                @error('brand_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror

                                <div class="hstack gap-2 justify-content-end">
                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">{{__('translation.Close')}}</button>
                                    <button type="submit" class="btn btn-success" id="addNewBrand">{{__('translation.Update Brand')}}</button>
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
                $('#brandListTable').DataTable({
                    processing: true
                    , serverSide: true
                    , ajax: "{{route('brand-list')}}"
                    , columns: [{
                            data: 'DT_RowIndex'
                            , name: 'DT_RowIndex'
                            , orderable: false
                            , searchable: false
                        }
                        , {
                            data: 'brand_name'
                            , name: 'brand_name'
                        }
                        , {
                            data: 'created_at'
                            , name: 'created_at'
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
                        editBrandData();
                    }
                });
            });

            function editBrandData(brandId) {
                if (brandId) {
                    document.getElementById('editBrandName').value = document.getElementById('name_' + brandId).value;
                    document.getElementById("brandId").value = brandId;
                }
            }

             setTimeout(function() {
                var editButtons = document.getElementsByClassName("edit-button");
                
                for (var i = 0; i < editButtons.length; i++) {
                    editButtons[i].addEventListener("click", function(e) {
                        if (e.target.hasAttribute("data-edit-id")) {
                            var brandId = e.target.getAttribute("data-edit-id");
                            editBrandData(brandId);
                        } else {
                            var brandId = e.target.parentElement.getAttribute("data-edit-id");
                            editBrandData(brandId);
                        }

                    });
                }

                var removeBtn = document.getElementsByClassName("remove-btn");
                for (var i = 0; i < removeBtn.length; i++) {
                    removeBtn[i].addEventListener("click", function(e) {
                        if (e.target.hasAttribute("data-remove-id")) {
                            var brandId = e.target.getAttribute("data-remove-id");
                            callConfirmationModal(brandId);
                        } else {
                            var brandId = e.target.parentElement.getAttribute("data-remove-id");
                            callConfirmationModal(brandId);
                        }

                    });
                }
            }, 500)

            function callConfirmationModal(brandId) {
                event.preventDefault();
                Swal.fire({
                    title: "Are you sure you want to delete this brand?"
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
                            , text: 'Brand is deleted successfully!'
                            , icon: 'success'
                        }).then(function() {
                            window.location.href = 'delete-brand/' + brandId;
                        });
                    } else {
                        Swal.fire("Cancelled", "Your brand is safe.", "error");
                    }
                });
            }
        })();
    </script>
    @endsection
