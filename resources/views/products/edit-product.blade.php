@extends('layouts.master')
@section('title') {{__('translation.Products')}} @endsection
@section('css')
<!-- Plugins css -->
<link href="{{URL::asset('assets/libs/dropzone/dropzone.css')}}" rel="stylesheet" type="text/css" />
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
        @slot('pagetitle') {{__('translation.Edit Product')}} @endslot
    @endcomponent

    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <div class="p-2">
                        <form method="POST" action="{{url('update-product')}}" autocomplete="off" id="productform" class="needs-validation" enctype="multipart/form-data" novalidate>
                        @csrf
                            <div class="mb-3">
                                <label class="form-label" for="product_name">{{__('translation.Product Name')}}<span class="text-danger">*</span></label>
                                <input id="product_name" name="product_name" value="{{$products->product_name}}" placeholder="Enter Product Name" type="text" class="form-control" required>
                                <input id="productId" name="productId" value="{{$products->id}}" type="hidden">

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
                                        <select class="form-select" data-trigger name="brand" id="brand" required>
                                            <option value="" selected>Select</option>
                                            @foreach($brands as $key => $brand)
                                                <option value="{{$brand->id}}" @if($brand->id == $products->brand_id) {{'selected'}} @endif>{{$brand->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    @error('brand')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="category" class="form-label">{{__('translation.Product Category')}}<span class="text-danger">*</span>
                                            <i class="las la-plus-circle add-category" data-bs-toggle="modal" data-bs-target="#addCategoryModal"></i>
                                        </label>
                                        <select class="form-select" data-trigger name="category" id="category" required>
                                            <option value="" selected>Select</option>
                                            @foreach($categories as $key => $category)
                                                <option value="{{$category->id}}" @if($category->id == $products->category_id) {{'selected'}} @endif>{{$category->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    @error('category')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="price">{{__('translation.Product Price')}}<span class="text-danger">*</span></label>
                                        <input id="price" name="price" value="{{$products->price}}" placeholder="Enter Price" type="text" class="form-control" required>
                                    </div>

                                    @error('price')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="color" class="form-label">{{__('translation.Product Color')}}<span class="text-danger">*</span></label>
                                        <i class="las la-plus-circle add-color" data-bs-toggle="modal" data-bs-target="#addColorModal"></i>
                                        <select class="form-select" data-trigger name="color" id="color" required>
                                            <option value="" selected>Select</option>
                                            @foreach($colors as $key => $color)
                                                <option value="{{$color->id}}" @if($color->id == $products->color_id) {{'selected'}} @endif>{{$color->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    @error('color')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="productImage">{{__('translation.Product Thumbnail Image')}}<span class="text-danger">*</span></label>
                                        <input type="file" class="form-control" id="productImage" name="product_image" placeholder="Select Product Image" >
                                        @error('product_image')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <span class="pip">
                                        <img class="imageThumb mt-2 " src="{{URL::asset('/assets/images/products/'.$products->product_image)}}"><br>
                                    </span>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="productImage">{{__('translation.Product Sub Images')}}<span class="text-danger">*</span></label>
                                        <input type="file" class="form-control" id="productSubImage" name="product_sub_image[]" placeholder="Select Product Image" multiple>
                                        @error('product_sub_image')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    @foreach($products->product_images as $key => $value)
                                        <span class="pip_sub">
                                            <img class="imageThumb mt-2 " src="{{URL::asset('/assets/images/products/'.$value['image'])}}"><br>
                                            <span class="remove subImage" data-id="{{$value['id']}}"><i class="las la-times-circle"></i></span>
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label" for="productdesc">{{__('translation.Product Description')}}<span class="text-danger">*</span></label>
                                <textarea class="form-control" id="productdesc" name="product_description" placeholder="Enter Description" rows="4" required>{{$products->description}}</textarea>

                                @error('product_description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        
                            <div class="hstack gap-2 mt-4">
                                <button type="submit" class="btn btn-primary" id="updateProduct">{{__('translation.Update')}}</button>
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
                    <form method="POST" action="{{url('add-brand')}}" autocomplete="off" id="brandform" class="needs-validation" enctype="multipart/form-data" novalidate >
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
    <div class="modal fade" id="editCategoryModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered ">
            <div class="modal-content border-0">
                <div class="modal-header p-4 pb-0">
                    <h5 class="modal-title" id="createMemberLabel">{{__('translation.Add New Category')}}</h5>
                    <button type="button" class="btn-close" id="createMemberBtn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <form method="POST" action="{{url('add-category')}}" autocomplete="off" id="categoryform" class="needs-validation" enctype="multipart/form-data" novalidate >
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
                    <form method="POST" action="{{url('add-color')}}" autocomplete="off" id="colorform" class="needs-validation" enctype="multipart/form-data" novalidate >
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
        <script src="{{URL::asset('assets/js/jquery-3.6.4.min.js')}}" ></script>

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
            

            $(document).ready(function() {
                if (window.File && window.FileList && window.FileReader) {
                    $("#productImage").on("change", function(e) {
                    var files = e.target.files,
                        filesLength = files.length;
                        for (var i = 0; i < filesLength; i++) {
                            var f = files[i]
                            var fileReader = new FileReader();
                            fileReader.onload = (function(e) {
                            var file = e.target;
                            document.querySelectorAll(".pip").forEach(el => el.remove());
                            $("<span class=\"pip\">" +
                                "<img class=\"imageThumb mt-2\" src=\"" + e.target.result + "\" title=\"" + file.name + "\"/>" +
                                "<br/>" +
                                "</span>").insertAfter("#productImage");
                            $(".remove").click(function(){
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
                    var files = e.target.files,
                        filesLength = files.length;
                        for (var i = 0; i < filesLength; i++) {
                            var f = files[i]
                            var fileReader = new FileReader();
                            fileReader.onload = (function(e) {
                            var file = e.target;
                            $("<span class=\"pip_sub\">" +
                                "<img class=\"imageThumb mt-2\" src=\"" + e.target.result + "\" title=\"" + file.name + "\"/>" +
                                "<br/><span class=\"remove\"><i class=\"las la-times-circle\"></i></span>" +
                                "</span>").insertAfter("#productSubImage");
                            $(".remove").click(function(){
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

            $('.subImage').on('click', function(e) {
                e.preventDefault();
                var subImageId = $(this).attr("data-id");
                var token = $("input[name='_token']").val();
                if (confirm('Are you sure you want to delete this image?')) {
                    $.ajax({
                        type: 'post',
                        url: '{{url("delete-sub-image")}}',
                        dataType: 'json',
                        data: {'subImageId': subImageId,'_token': token},
                        success: function(data) {
                            if (data.status == 'success') {
                                Toastify({
                                text: data.message,
                                duration: 3000,
                                close: true,
                                gravity: "top",
                                positionLeft: false,
                                backgroundColor: "linear-gradient(to right, #00b09b, #96c93d)",
                                }).showToast();
                                location.reload();
                            } else {
                                Toastify({
                                text: data.message,
                                duration: 3000,
                                close: true,
                                gravity: "top",
                                positionLeft: false,
                                backgroundColor: "linear-gradient(to right, #ff947d, #f06548)",
                                }).showToast();
                                location.reload();
                            }
                        },
                        error: function(data) {
                            alert('oops! Something Went Wrong!!!');
                        }
                    });
                }
            });
            })()

            
        </script>
    @endsection
                

    
    
