@extends('layouts.master')
@section('title') {{__('translation.Color')}} @endsection
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
    @slot('title') {{__('translation.Color')}} @endslot
    @slot('pagetitle') {{__('translation.Color List')}} @endslot
    @endcomponent

    <div class="row pb-4 gy-3">
        <div class="col-sm-4">
            <button class="btn btn-primary addcolor-modal" data-bs-toggle="modal" data-bs-target="#addcolorModal"><i class="las la-plus me-1"></i> {{__('translation.Add Color')}}</button>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive table-card">
                        <table class="table table-hover table-nowrap align-middle mb-0" id="colorListTable">
                            <thead>
                                <tr class="text-muted text-uppercase">
                                    <th scope="col">{{__('translation.Sr. No')}}</th>
                                    <th scope="col">{{__('translation.Color Name')}}</th>
                                    <th scope="col" style="width: 20%;">{{__('translation.Created At')}}</th>
                                    <th scope="col" style="width: 20%;">{{__('translation.Action')}}</th>
                                </tr>
                            </thead>

                            <tbody>
                                {{-- Tabel values are getting from Yajra datatable ajax --}}
                            </tbody><!-- end tbody -->
                        </table><!-- end table -->

                        @foreach($colors as $key => $color)
                        <input type="hidden" id="name_{{$color->id}}" value="{{@$color->name}}">
                        @endforeach
                    </div><!-- end table responsive -->
                </div>
            </div>

        </div>
    </div>

    <!-- Add Modal -->
    <div class="modal fade" id="addcolorModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0">
                <div class="modal-header p-4 pb-0">
                    <h5 class="modal-title" id="createMemberLabel">{{__('translation.Add Color')}}</h5>
                    <button type="button" class="btn-close" id="createMemberBtn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <form method="post" action="{{url('add-color')}}" autocomplete="off" id="colorform" class="needs-validation" novalidate>
                        @csrf
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label for="colorName" class="form-label">{{__('translation.Color Name')}}<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('color_name') is-invalid @enderror" name="color_name" id="colorName" placeholder="Enter Color Name" required>

                                    @error('color_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="hstack gap-2 justify-content-end">
                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">{{__('translation.Close')}}</button>
                                    <button type="submit" class="btn btn-success" id="addNewColor">{{__('translation.Add Color')}}</button>
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
    <div class="modal fade" id="editColorModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0">
                <div class="modal-header p-4 pb-0">
                    <h5 class="modal-title" id="createMemberLabel">{{__('translation.Edit Color')}}</h5>
                    <button type="button" class="btn-close" id="createMemberBtn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <form method="post" action="{{url('update-color')}}" autocomplete="off" id="colorform" class="needs-validation" novalidate>
                        @csrf
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label for="editColorName" class="form-label">{{__('translation.Color Name')}}</label>
                                    <input type="text" class="form-control" name="color_name" id="editColorName" placeholder="Enter Color Name" required>
                                    <input type="hidden" name="colorId" id="colorId">
                                </div>
                                @error('color_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror

                                <div class="hstack gap-2 justify-content-end">
                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">{{__('translation.Close')}}</button>
                                    <button type="submit" class="btn btn-success" id="addNewColor">{{__('translation.Update Color')}}</button>
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
                $('#colorListTable').DataTable({
                    processing: true
                    , serverSide: true
                    , ajax: "{{route('color-list')}}"
                    , columns: [{
                            data: 'DT_RowIndex'
                            , name: 'DT_RowIndex'
                            , orderable: false
                            , searchable: false
                        }
                        , {
                            data: 'color_name'
                            , name: 'color_name'
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
                        editColorData();
                    }
                });
            });

            function editColorData(colorId) {
                if (colorId) {
                    document.getElementById('editColorName').value = document.getElementById('name_' + colorId).value;
                    document.getElementById("colorId").value = colorId;
                }
            }

            setTimeout(function() {
                var editButtons = document.getElementsByClassName("edit-button");

                for (var i = 0; i < editButtons.length; i++) {
                    editButtons[i].addEventListener("click", function(e) {
                        if (e.target.hasAttribute("data-edit-id")) {
                            var colorId = e.target.getAttribute("data-edit-id");
                            editColorData(colorId);
                        } else {
                            var colorId = e.target.parentElement.getAttribute("data-edit-id");
                            editColorData(colorId);
                        }

                    });
                }

                var removeBtn = document.getElementsByClassName("remove-btn");
                for (var i = 0; i < removeBtn.length; i++) {
                    removeBtn[i].addEventListener("click", function(e) {
                        if (e.target.hasAttribute("data-remove-id")) {
                            var colorId = e.target.getAttribute("data-remove-id");
                            callConfirmationModal(colorId);
                        } else {
                            var colorId = e.target.parentElement.getAttribute("data-remove-id");
                            callConfirmationModal(colorId);
                        }

                    });
                }
            }, 500)

            function callConfirmationModal(colorId) {
                event.preventDefault();
                Swal.fire({
                    title: "Are you sure you want to delete this category?"
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
                            , text: 'Color is deleted successfully!'
                            , icon: 'success'
                        }).then(function() {
                            window.location.href = 'delete-color/' + colorId;
                        });
                    } else {
                        Swal.fire("Cancelled", "Your color is safe.", "error");
                    }
                });
            }
        })()

    </script>
    @endsection
