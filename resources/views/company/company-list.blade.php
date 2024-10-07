@extends('layouts.master')
@section('title') {{__('translation.Company')}} @endsection
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

    table.dataTable th:nth-child(7) {
        width: 150px;
        max-width: 150px;
        word-break: break-all;
        white-space: pre-line;
    }

    table.dataTable td:nth-child(7) {
        width: 150px;
        max-width: 150px;
        word-break: break-all;
        white-space: pre-line;
    }

</style>
@endsection

@section('body')
<body>
    @endsection

    @section('content')

    @component('components.breadcrumb')
    @slot('title') {{__('translation.Company')}} @endslot
    @slot('pagetitle') {{__('translation.Company List')}} @endslot
    @endcomponent

    <div class="row pb-4 gy-3">
        <div class="col-sm-4">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCompanyModal"><i class="las la-plus me-1"></i> {{__('translation.Add Company')}}</button>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive table-card">
                        <table class="table table-hover table-nowrap align-middle mb-0" id="companyListTable">
                            <thead>
                                <tr class="text-muted text-uppercase">
                                    <th scope="col">{{__('translation.Sr. No')}}</th>
                                    <th scope="col">{{__('translation.Company Name')}}</th>
                                    <th scope="col">{{__('translation.Email')}}</th>
                                    <th scope="col">{{__('translation.Website')}}</th>
                                    <th scope="col">{{__('translation.Invoice Slug')}}</th>
                                    <th scope="col">{{__('translation.Contact No')}}</th>
                                    <th scope="col">{{__('translation.Address')}}</th>
                                    <th scope="col">{{__('translation.Postalcode')}}</th>
                                    <th scope="col">{{__('translation.Status')}}</th>
                                    <th scope="col">{{__('translation.Action')}}</th>
                                </tr>
                            </thead>

                            <tbody>
                                {{-- Tabel values are getting from Yajra datatable ajax --}}
                            </tbody><!-- end tbody -->
                        </table><!-- end table -->

                        @foreach($companies as $key => $company)
                        <input type="hidden" id="company_name_{{$company->id}}" value="{{@$company->company_name}}">
                        <input type="hidden" id="website_{{$company->id}}" value="{{@$company->website}}">
                        <input type="hidden" id="email_{{$company->id}}" value="{{@$company->email}}">
                        <input type="hidden" id="mobile_number_{{$company->id}}" value="{{@$company->mobile_number}}">
                        <input type="hidden" id="address_{{$company->id}}" value="{{@$company->address}}">
                        <input type="hidden" id="postalcode_{{$company->id}}" value="{{@$company->postalcode}}">
                        <input type="hidden" id="invoice_slug_{{$company->id}}" value="{{@$company->invoice_slug}}">
                        <input type="hidden" id="logo_{{$company->id}}" value="{{ URL::asset('assets/images/logo/' . $company->logo) }}">
                        @endforeach

                    </div><!-- end table responsive -->
                </div>
            </div>
        </div>
    </div>

    <!-- Add Modal -->
    <div class="modal fade" id="addCompanyModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content border-0">
                <div class="modal-header p-4 pb-0">
                    <h5 class="modal-title" id="createMemberLabel">{{__('translation.Add Company')}}</h5>
                    <button type="button" class="btn-close" id="createMemberBtn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <form method="POST" action="{{url('add-company')}}" autocomplete="off" id="companyform" class="needs-validation" enctype="multipart/form-data" novalidate>
                        @csrf
                        <div class="row">
                            <div class="col-lg-12">
                                <input type="hidden" id="memberid-input" class="form-control" value="">
                                <div class="text-center mb-2">
                                    <div class="position-relative d-inline-block">
                                        <div class="position-absolute bottom-0 end-0">
                                            <label for="member-image-input" class="mb-0" data-bs-toggle="tooltip" data-bs-placement="right" title="Select Company Logo">
                                                <div class="avatar-xs">
                                                    <div class="avatar-title bg-light border rounded-circle text-muted cursor-pointer">
                                                        <i class="ri-image-fill"></i>
                                                    </div>
                                                </div>
                                            </label>
                                            <input class="form-control d-none @error('logo') is-invalid @enderror" value="" id="member-image-input" type="file" name="logo" accept="image/png, image/gif, image/jpeg" onchange="displayLogo(this)" required>
                                            <div class="invalid-feedback">Please select logo.</div>

                                            @error('logo')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                        <div class="avatar-lg">
                                            <div class="avatar-title bg-light rounded-circle">
                                                <img src="{{URL::asset('/assets/images/users/user-dummy-img.jpg')}}" id="member-img" class="avatar-md rounded-circle h-auto" />
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-6 mb-2 mt-2">
                                        <label for="companyName" class="form-label">{{__('translation.Company Name')}}<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('company_name') is-invalid @enderror" id="companyName" name="company_name" placeholder="Enter company name" required>

                                        @error('company_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="col-lg-6 mb-2 mt-2">
                                        <label for="website" class="form-label">{{__('translation.Website Url')}}<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('website') is-invalid @enderror" id="website" name="website" placeholder="Enter website" required>

                                        @error('website')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-6 mb-2 mt-2">
                                        <label for="email" class="form-label">{{__('translation.Email')}}<span class="text-danger">*</span></label>
                                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="Enter email" required>

                                        @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="col-lg-6 mb-2 mt-2">
                                        <label for="mobile_number" class="form-label">{{__('translation.Contact No')}}<span class="text-danger">*</span></label>
                                        <input type="number" class="form-control @error('mobile_number') is-invalid @enderror" id="mobile_number" name="mobile_number" placeholder="Enter contact number" required>

                                        @error('mobile_number')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-6 mb-2 mt-2">
                                        <label for="postalcode" class="form-label">{{__('translation.Postalcode')}}<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('postalcode') is-invalid @enderror" id="postalcode" name="postalcode" placeholder="Enter postalcode" required>

                                        @error('postalcode')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="col-lg-6 mb-2 mt-2">
                                        <label for="invoiceSlug" class="form-label">{{__('translation.Invoice Number Slug')}}<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('invoice_slug') is-invalid @enderror" id="invoiceSlug" name="invoice_slug" placeholder="Enter invoice slug" required>

                                        @error('invoice_slug')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-2">
                                    <label class="form-label" for="address">{{__('translation.Address')}}<span class="text-danger">*</span></label>
                                    <textarea class="form-control" id="address" name="address" placeholder="Enter address" rows="4" required></textarea>

                                    @error('address')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="hstack gap-2 justify-content-end">
                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">{{__('translation.Close')}}</button>
                                    <button type="submit" class="btn btn-success" id="addNewCompany">{{__('translation.Add Company')}}</button>
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
    <!-- END Add Modal -->

    <!-- Edit Modal -->
    <div class="modal fade" id="editCompanyModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content border-0">
                <div class="modal-header p-4 pb-0">
                    <h5 class="modal-title" id="createMemberLabel">{{__('translation.Edit Company')}}</h5>
                    <button type="button" class="btn-close" id="createMemberBtn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <form method="POST" action="{{url('update-company')}}" autocomplete="off" id="editCompanyform" class="needs-validation" enctype="multipart/form-data" novalidate>
                        @csrf
                        <div class="row">
                            <div class="col-lg-12">
                                <input type="hidden" id="memberid-input" class="form-control" value="">
                                <input type="hidden" id="companyId" name="companyId" value="">
                                <div class="text-center mb-2">
                                    <div class="position-relative d-inline-block">
                                        <div class="position-absolute bottom-0 end-0">
                                            <label for="editCompanyLogo" class="mb-0" data-bs-toggle="tooltip" data-bs-placement="right" title="Select Company Logo">
                                                <div class="avatar-xs">
                                                    <div class="avatar-title bg-light border rounded-circle text-muted cursor-pointer">
                                                        <i class="ri-image-fill"></i>
                                                    </div>
                                                </div>
                                            </label>
                                            <input class="form-control d-none @error('logo') is-invalid @enderror" value="" id="editCompanyLogo" type="file" name="logo" accept="image/png, image/gif, image/jpeg" onchange="editCompnyLogo(this)">

                                            <div class="invalid-feedback">Please select logo.</div>
                                            @error('logo')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                        <div class="avatar-lg">
                                            <div class="avatar-title bg-light rounded-circle">
                                                <img src="{{URL::asset('/assets/images/users/user-dummy-img.jpg')}}" id="editLogo" class="avatar-md rounded-circle h-auto" />
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-6 mb-2 mt-2">
                                        <label for="editCompanyName" class="form-label">{{__('translation.Company Name')}}<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('company_name') is-invalid @enderror" id="editCompanyName" name="company_name" placeholder="Enter company name" required>

                                        @error('company_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="col-lg-6 mb-2 mt-2">
                                        <label for="editWebsite" class="form-label">{{__('translation.Website')}}<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('website') is-invalid @enderror" id="editWebsite" name="website" placeholder="Enter website" required>

                                        @error('website')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-6 mb-2 mt-2">
                                        <label for="editEmail" class="form-label">{{__('translation.Email')}}<span class="text-danger">*</span></label>
                                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="editEmail" name="email" placeholder="Enter email" required>

                                        @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="col-lg-6 mb-2 mt-2">
                                        <label for="editMobileNumber" class="form-label">{{__('translation.Contact No')}}<span class="text-danger">*</span></label>
                                        <input type="number" class="form-control @error('mobile_number') is-invalid @enderror" id="editMobileNumber" name="mobile_number" placeholder="Enter contact number" required>

                                        @error('mobile_number')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-6 mb-2 mt-2">
                                        <label for="editPostalcode" class="form-label">{{__('translation.Postalcode')}}<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('postalcode') is-invalid @enderror" id="editPostalcode" name="postalcode" placeholder="Enter postalcode" required>

                                        @error('postalcode')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="col-lg-6 mb-2 mt-2">
                                        <label for="editInvoiceSlug" class="form-label">{{__('translation.Invoice Number Slug')}}<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('invoice_slug') is-invalid @enderror" id="editInvoiceSlug" name="invoice_slug" placeholder="Enter invoice slug" required>

                                        @error('invoice_slug')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-2">
                                    <label class="form-label" for="address">{{__('translation.Address')}}<span class="text-danger">*</span></label>
                                    <textarea class="form-control" id="editAddress" name="address" placeholder="Enter address" rows="4" required></textarea>

                                    @error('address')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="hstack gap-2 justify-content-end">
                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">{{__('translation.Close')}}</button>
                                    <button type="submit" class="btn btn-success" id="addNewClient">{{__('translation.Update Company')}}</button>
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
    <!-- END Edit Modal-->

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
                $('#companyListTable').DataTable({
                    processing: true
                    , serverSide: true
                    , ajax: "{{route('company-list')}}"
                    , columns: [{
                            data: 'DT_RowIndex'
                            , name: 'DT_RowIndex'
                            , orderable: false
                            , searchable: false
                        }
                        , {
                            data: 'company_name'
                            , name: 'company_name'
                        }
                        , {
                            data: 'email'
                            , name: 'email'
                        }
                        , {
                            data: 'website'
                            , name: 'website'
                        }
                        , {
                            data: 'invoice_slug'
                            , name: 'invoice_slug'
                        }
                        , {
                            data: 'mobile_number'
                            , name: 'mobile_number'
                        }
                        , {
                            data: 'address'
                            , name: 'address'
                            , width: "15%"
                        }
                        , {
                            data: 'postalcode'
                            , name: 'postalcode'
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
                        editCompanyData();
                    }
                });
            });

            function editCompanyData(companyId) {
                if (companyId) {
                    document.getElementById('editCompanyName').value = document.getElementById('company_name_' + companyId).value;
                    document.getElementById('editWebsite').value = document.getElementById('website_' + companyId).value;
                    document.getElementById('editEmail').value = document.getElementById('email_' + companyId).value;
                    document.getElementById('editMobileNumber').value = document.getElementById('mobile_number_' + companyId).value;
                    document.getElementById('editAddress').value = document.getElementById('address_' + companyId).value;
                    document.getElementById('editPostalcode').value = document.getElementById('postalcode_' + companyId).value;
                    document.getElementById('editInvoiceSlug').value = document.getElementById('invoice_slug_' + companyId).value;
                    document.getElementById("editLogo").src = document.getElementById('logo_' + companyId).value;
                    document.getElementById("companyId").value = companyId;
                }
            }

            function editCompnyLogo(e) {
                if (e.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        document.querySelector('#editLogo').setAttribute('src', e.target.result);
                    }
                    reader.readAsDataURL(e.files[0]);
                }
            }

            function displayLogo(e) {
                if (e.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        document.querySelector('#member-img').setAttribute('src', e.target.result);
                    }
                    reader.readAsDataURL(e.files[0]);
                }
            }

            setTimeout(function() {
                var editButtons = document.getElementsByClassName("edit-button");

                for (var i = 0; i < editButtons.length; i++) {
                    editButtons[i].addEventListener("click", function(e) {
                        if (e.target.hasAttribute("data-remove-id")) {
                            var companyId = e.target.getAttribute("data-edit-id");
                            editCompanyData(companyId);
                        } else {
                            var companyId = e.target.parentElement.getAttribute("data-edit-id");
                            editCompanyData(companyId);
                        }

                    });
                }

                var removeBtn = document.getElementsByClassName("remove-btn");
                for (var i = 0; i < removeBtn.length; i++) {
                    removeBtn[i].addEventListener("click", function(e) {
                        if (e.target.hasAttribute("data-remove-id")) {
                            var companyId = e.target.getAttribute("data-remove-id");
                            callConfirmationModal(companyId);
                        } else {
                            var companyId = e.target.parentElement.getAttribute("data-remove-id");
                            callConfirmationModal(companyId);
                        }

                    });
                }

            }, 500)

            function callConfirmationModal(companyId) {
                event.preventDefault();
                Swal.fire({
                    title: "Are you sure you want to delete this company?"
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
                            , text: 'Tax is deleted successfully!'
                            , icon: 'success'
                        }).then(function() {
                            window.location.href = 'delete-company/' + companyId;
                        });
                    } else {
                        Swal.fire("Cancelled", "Your company details are safe.", "error");
                    }
                });
            }
        })()

    </script>
    @endsection
