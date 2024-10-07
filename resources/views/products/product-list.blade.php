@extends('layouts.master')
@section('title') {{__('translation.Products')}} @endsection
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
    @slot('title') {{__('translation.Products')}} @endslot
    @slot('pagetitle') {{__('translation.Product List')}} @endslot
    @endcomponent

    <div class="row pb-4 gy-3">
        <div class="col-sm-4">
            <a href="{{ url('add-product-view') }}" class="btn btn-primary addtax-modal"><i class="las la-plus me-1"></i> {{__('translation.Add Product')}}</a>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive table-card">
                        <table class="table table-nowrap align-middle mb-0" id="productListTable">
                            <thead>
                                <tr class="text-muted text-uppercase">
                                    <th scope="col">{{__('translation.Sr. No')}}</th>
                                    <th scope="col">{{__('translation.Product Name')}}</th>
                                    <th scope="col">{{__('translation.Brand Name')}}</th>
                                    <th scope="col">{{__('translation.Category')}}</th>
                                    <th scope="col">{{__('translation.Color')}}</th>
                                    <th scope="col">{{__('translation.Price')}}</th>
                                    <th scope="col">{{__('translation.Create At')}}</th>
                                    <th scope="col">{{__('translation.Create By')}}</th>
                                    <th scope="col">{{__('translation.Status')}}</th>
                                    <th scope="col">{{__('translation.Action')}}</th>
                                </tr>
                            </thead>

                            <tbody>
                                {{-- Tabel values are getting from Yajra datatable ajax --}}
                            </tbody><!-- end tbody -->
                        </table><!-- end table -->

                        @foreach($products as $key => $product)
                        @php $image = $product->product_image; @endphp
                        <input type="hidden" id="product_name_{{$product->id}}" value="{{@$product->product_name}}">
                        <input type="hidden" id="brand_{{$product->id}}" value="{{@$product->brand->name}}">
                        <input type="hidden" id="category_{{$product->id}}" value="{{@$product->category->name}}">
                        <input type="hidden" id="color_{{$product->id}}" value="{{@$product->color->name}}">
                        <input type="hidden" id="price_{{$product->id}}" value="{{@$product->price}}">
                        <input type="hidden" id="product_image_{{$product->id}}" value="{{URL::asset('/assets/images/products/'.$product->product_image)}}">
                        <input type="hidden" id="description_{{$product->id}}" value="{{@$product->description}}">
                        @endforeach

                    </div><!-- end table responsive -->
                </div>
            </div>

        </div>
    </div>

    <!-- View Modal -->
    <div class="modal fade" id="viewProductModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content border-0">
                <div class="modal-header p-4 pb-0">
                    <h5 class="modal-title" id="createMemberLabel">{{__('translation.View Product')}}</h5>
                    <button type="button" class="btn-close" id="createMemberBtn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <form method="POST" action="#" autocomplete="off" id="productform" class="needs-validation" enctype="multipart/form-data" novalidate>
                        @csrf
                        <div class="row">
                            <div class="col-lg-12">
                                <input type="hidden" id="memberid-input" class="form-control" value="">
                                <div class="text-center mb-2">
                                    <div class="position-relative d-inline-block">
                                        <div class="avatar-lg">
                                            <div class="avatar-title bg-light rounded-circle">
                                                <img src="{{URL::asset('/assets/images/users/user-dummy-img.jpg')}}" id="viewProductImage" class="avatar-md rounded-circle h-auto" />
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-6 mb-2 mt-2">
                                        <label for="productName" class="form-label">{{__('translation.Product Name')}}<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="viewProductName" readonly>
                                    </div>
                                    <div class="col-lg-6 mb-2 mt-2">
                                        <label for="brandName" class="form-label">{{__('translation.Brand Name')}}<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="viewBrand" readonly>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-6 mb-2 mt-2">
                                        <label for="category" class="form-label">{{__('translation.Category')}}<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="viewCategory" readonly>
                                    </div>
                                    <div class="col-lg-6 mb-2 mt-2">
                                        <label for="color" class="form-label">{{__('translation.Color')}}<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="viewColor" readonly>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-6 mb-2 mt-2">
                                        <label for="price" class="form-label">{{__('translation.Price')}}<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="viewPrice" readonly>
                                    </div>
                                </div>

                                <div class="mb-2 mt-2">
                                    <label for="description" class="form-label">{{__('translation.Description')}}<span class="text-danger">*</span></label>
                                    <textarea class="form-control" id="viewDescription" rows="6" readonly></textarea>
                                </div>

                                <div class="hstack gap-2 justify-content-end">
                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">{{__('translation.Close')}}</button>
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
    <!-- END View Modal-->

    @endsection
    @section('scripts')
    <!-- jquery -->
    <script src="{{URL::asset('assets/js/jquery-3.6.4.min.js')}}"></script>
    <!--datatable js-->
    <script src="{{URL::asset('assets/libs/datatable/jquery.dataTables.min.js')}}"></script>
    <script src="{{URL::asset('assets/libs/datatable/dataTables.bootstrap5.min.js')}}"></script>

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
                $('#productListTable').DataTable({
                    processing: true
                    , serverSide: true
                    , ajax: "{{route('product-list')}}"
                    , columns: [{
                            data: 'DT_RowIndex'
                            , name: 'DT_RowIndex'
                            , orderable: false
                            , searchable: false
                        }
                        , {
                            data: 'product_name'
                            , name: 'product_name'
                        }
                        , {
                            data: 'brand_name'
                            , name: 'brand_name'
                        }
                        , {
                            data: 'category_name'
                            , name: 'category_name'
                        }
                        , {
                            data: 'color_name'
                            , name: 'color_name'
                        }
                        , {
                            data: 'price'
                            , name: 'price'
                        }
                        , {
                            data: 'created_at'
                            , name: 'created_at'
                        }
                        , {
                            data: 'created_by'
                            , name: 'created_by'
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
                        viewProductData();
                    }
                });
            });

            function viewProductData(productId) {
                if (productId) {
                    document.getElementById('viewProductName').value = document.getElementById('product_name_' + productId).value;
                    document.getElementById('viewBrand').value = document.getElementById('brand_' + productId).value;
                    document.getElementById('viewCategory').value = document.getElementById('category_' + productId).value;
                    document.getElementById('viewColor').value = document.getElementById('color_' + productId).value;
                    document.getElementById('viewPrice').value = document.getElementById('price_' + productId).value;
                    document.getElementById('viewDescription').value = document.getElementById('description_' + productId).value;
                    document.getElementById('viewProductImage').src = document.getElementById('product_image_' + productId).value;
                }
            }

        })()

    </script>

    @endsection