@extends('layouts.master')
@section('title') {{__('translation.Products')}} @endsection
@section('css')
<style>
    input[type="file"] {
        display: block;
    }

    .imageThumb {
        max-height: 75px;
        border: 2px solid;
        padding: 1px;
        cursor: pointer;
    }

    .pip {
        display: inline-block;
        margin: 10px 10px 0 0;
    }

    .pip_sub {
        display: inline-block;
        margin: 10px 10px 0 0;
    }

    .remove {
        display: block;
        background: #397568;
        border: 1px solid black;
        color: white;
        text-align: center;
        cursor: pointer;
    }

    .remove:hover {
        background: white;
        color: black;
    }

</style>
@endsection

@section('body')
<body>
    @endsection

    @section('content')

    @component('components.breadcrumb')
    @slot('title') {{__('translation.Products')}} @endslot
    @slot('pagetitle') {{__('translation.Add Product')}} @endslot
    @endcomponent

    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <div class="p-2">
                        <form method="POST" action="{{url('add-product')}}" autocomplete="off" id="productform" class="needs-validation" enctype="multipart/form-data" novalidate>
                            @csrf
                            <div class="mb-3">
                                <label class="form-label" for="product_name">{{__('translation.Product Name')}}<span class="text-danger">*</span></label>
                                <input id="product_name" name="product_name" placeholder="Enter Product Name" type="text" class="form-control @error('product_name') is-invalid @enderror" required>

                                @error('product_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="brand" class="form-label">{{__('translation.Product Brand')}}<span class="text-danger">*</span>
                                            <i class="las la-plus-circle add-brand" data-bs-toggle="modal" data-bs-target="#addBrandModal"></i>
                                        </label>
                                        <select class="form-select @error('brand') is-invalid @enderror" data-trigger name="brand" id="brand" required>
                                            <option value="" selected>Select</option>
                                            @foreach($brands as $key => $brand)
                                            <option value="{{$brand->id}}">{{$brand->name}}</option>
                                            @endforeach
                                        </select>

                                        @error('brand')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>

                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="category" class="form-label">{{__('translation.Product Category')}}<span class="text-danger">*</span>
                                            <i class="las la-plus-circle add-category" data-bs-toggle="modal" data-bs-target="#addCategoryModal"></i>
                                        </label>
                                        <select class="form-select  @error('category') is-invalid @enderror" data-trigger name="category" id="category" required>
                                            <option value="" selected>Select</option>
                                            @foreach($categories as $key => $category)
                                            <option value="{{$category->id}}">{{$category->name}}</option>
                                            @endforeach
                                        </select>

                                        @error('category')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="price">{{__('translation.Product Price')}}<span class="text-danger">*</span></label>
                                        <input type="number" id="price" name="price" placeholder="Enter Price" class="form-control  @error('price') is-invalid @enderror" required>

                                        @error('price')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="color" class="form-label">{{__('translation.Product Color')}}<span class="text-danger">*</span></label>
                                        <i class="las la-plus-circle add-color" data-bs-toggle="modal" data-bs-target="#addColorModal"></i>
                                        <select class="form-select @error('color') is-invalid @enderror" data-trigger name="color" id="color" required>
                                            <option value="" selected>Select</option>
                                            @foreach($colors as $key => $color)
                                            <option value="{{$color->id}}">{{$color->name}}</option>
                                            @endforeach
                                        </select>
                                        @error('color')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="productImage">{{__('translation.Product Thumbnail Image')}}<span class="text-danger">*</span></label>
                                        <input type="file" class="form-control  @error('product_image') is-invalid @enderror" id="productImage" name="product_image" placeholder="Select Product Image" required>
                                        @error('product_image')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="productImage">{{__('translation.Product Sub Images')}}<span class="text-danger">*</span></label>
                                        <input type="file" class="form-control @error('product_sub_image') is-invalid @enderror" id="productSubImage" name="product_sub_image[]" placeholder="Select Product Image" multiple required>
                                        @error('product_sub_image')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="productdesc">{{__('translation.Product Description')}}<span class="text-danger">*</span></label>
                                <textarea class="form-control @error('product_description') is-invalid @enderror" id="productdesc" name="product_description" placeholder="Enter Description" rows="4" required></textarea>
                                @error('product_description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="hstack gap-2 mt-4">
                                <button type="submit" class="btn btn-primary" id="addProduct">{{__('translation.Save')}}</button>
                                <button type="button" class="btn btn-light">{{__('translation.Discard')}}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Brand Modal -->
    <div class="modal fade" id="addBrandModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered ">
            <div class="modal-content border-0">
                <div class="modal-header p-4 pb-0">
                    <h5 class="modal-title" id="createMemberLabel">{{__('translation.Add New Brand')}}</h5>
                    <button type="button" class="btn-close" id="createMemberBtn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <form method="POST" action="{{url('add-brand')}}" autocomplete="off" id="brandform" class="needs-validation" enctype="multipart/form-data" novalidate>
                        @csrf
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="mb-2 mt-2">
                                    <label for="brandName" class="form-label">{{__('translation.Brand Name')}}<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('brand_name') is-invalid @enderror" id="brandName" name="brand_name" placeholder="Enter brand name" required>
                                    <div class="invalid-feedback">Please enter brand name.</div>

                                    @error('brand_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="hstack gap-2 justify-content-end">
                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">{{__('translation.Close')}}</button>
                                    <button type="submit" class="btn btn-success" id="addNewBrand">{{__('translation.Add')}}</button>
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
    <!-- END Add Brand Modal -->

    <!-- Add Category Modal -->
    <div class="modal fade" id="addCategoryModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered ">
            <div class="modal-content border-0">
                <div class="modal-header p-4 pb-0">
                    <h5 class="modal-title" id="createMemberLabel">{{__('translation.Add New Category')}}</h5>
                    <button type="button" class="btn-close" id="createMemberBtn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <form method="POST" action="{{url('add-category')}}" autocomplete="off" id="categoryform" class="needs-validation" enctype="multipart/form-data" novalidate>
                        @csrf
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="mb-2 mt-2">
                                    <label for="categoryName" class="form-label">{{__('translation.Category Name')}}<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('category_name') is-invalid @enderror" id="categoryName" name="category_name" placeholder="Enter category name" required>
                                    <div class="invalid-feedback">Please enter category name.</div>

                                    @error('category_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="hstack gap-2 justify-content-end">
                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">{{__('translation.Close')}}</button>
                                    <button type="submit" class="btn btn-success" id="addNewCategory">{{__('translation.Add')}}</button>
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
    <!-- END Add Category Modal -->

    <!-- Add Color Modal -->
    <div class="modal fade" id="addColorModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered ">
            <div class="modal-content border-0">
                <div class="modal-header p-4 pb-0">
                    <h5 class="modal-title" id="createMemberLabel">{{__('translation.Add New Color')}}</h5>
                    <button type="button" class="btn-close" id="createMemberBtn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <form method="POST" action="{{url('add-color')}}" autocomplete="off" id="colorform" class="needs-validation" enctype="multipart/form-data" novalidate>
                        @csrf
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="mb-2 mt-2">
                                    <label for="colorName" class="form-label">{{__('translation.Color Name')}}<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('color_name') is-invalid @enderror" id="colorName" name="color_name" placeholder="Enter color name" required>
                                    <div class="invalid-feedback">Please enter color name.</div>

                                    @error('color_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="hstack gap-2 justify-content-end">
                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">{{__('translation.Close')}}</button>
                                    <button type="submit" class="btn btn-success" id="addNewColor">{{__('translation.Add')}}</button>
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
    <!-- END Add color Modal -->

    @endsection
    @section('scripts')
    <!-- jquery -->
    <script src="{{URL::asset('assets/js/jquery-3.6.4.min.js')}}"></script>

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
                if (window.File && window.FileList && window.FileReader) {
                    $("#productImage").on("change", function(e) {

                        var files = e.target.files
                            , filesLength = files.length;
                        for (var i = 0; i < filesLength; i++) {
                            var f = files[i]
                            var fileReader = new FileReader();
                            fileReader.onload = (function(e) {
                                var file = e.target;
                                document.querySelectorAll(".pip").forEach(el => el.remove());
                                $("<span class=\"pip\">" +
                                    "<img class=\"imageThumb mt-2\" src=\"" + e.target.result + "\" title=\"" + file.name + "\"/>" +
                                    "<br/><span class=\"remove\"><i class=\"las la-times-circle\"></i></span>" +
                                    "</span>").insertAfter("#productImage");
                                $(".remove").click(function() {
                                    $(this).parent(".pip").remove();
                                });
                            });
                            fileReader.readAsDataURL(f);
                        }
                    });
                } else {
                    alert("Your browser doesn't support to File API")
                }

                if (window.File && window.FileList && window.FileReader) {
                    $("#productSubImage").on("change", function(e) {
                        var files = e.target.files
                            , filesLength = files.length;
                        for (var i = 0; i < filesLength; i++) {
                            var f = files[i]
                            var fileReader = new FileReader();
                            fileReader.onload = (function(e) {
                                var file = e.target;
                                $("<span class=\"pip_sub\">" +
                                    "<img class=\"imageThumb mt-2\" src=\"" + e.target.result + "\" title=\"" + file.name + "\"/>" +
                                    "<br/><span class=\"remove\"><i class=\"las la-times-circle\"></i></span>" +
                                    "</span>").insertAfter("#productSubImage");
                                $(".remove").click(function() {
                                    $(this).parent(".pip_sub").remove();
                                });
                            });
                            fileReader.readAsDataURL(f);
                        }
                    });
                } else {
                    alert("Your browser doesn't support to File API")
                }
            });
        })()

    </script>
    @endsection
