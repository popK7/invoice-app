@extends('layouts.master')
@section('title') Payments @endsection
@section('css')
<!-- Sweet Alert css-->
<link href="{{URL::asset('assets/libs/sweetalert2/sweetalert2.min.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('body') 
    <body> 
@endsection

    @section('content')

    @component('components.breadcrumb')
        @slot('title') Payments @endslot
        @slot('pagetitle') Payment Summary @endslot
    @endcomponent
    
        <div class="row pb-4 gy-3">
            <div class="col-sm-4">
                <div class="d-flex">
                    <div class="search-box">
                        <input type="text" class="form-control" placeholder="Search for Result">
                        <i class="las la-search search-icon"></i>
                    </div>
                </div>
            </div>

            <div class="col-sm-auto ms-auto">
                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-soft-primary fs-14"><i class="las la-filter fs-16 align-middle me-2"></i>Filter</button>
                    <button type="button" id="dropdownMenuLink1" data-bs-toggle="dropdown" aria-expanded="false" class="btn btn-soft-info btn-icon fs-14"><i class="las la-ellipsis-v fs-18"></i></button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink1">
                        <li><a class="dropdown-item" href="#">Print</a></li>
                        <li><a class="dropdown-item" href="#">Export to Excel</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive table-card">
                            <table class="table table-hover table-nowrap align-middle mb-0">
                                <thead>
                                    <tr class="text-muted text-uppercase">
                                        <th scope="col">Date</th>
                                        <th scope="col">Invoice ID</th>
                                        <th scope="col">Client</th>
                                        <th scope="col">Billed</th>
                                        <th scope="col" style="width: 16%;">Payment Type</th>
                                        <th scope="col" style="width: 12%;">Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <tr>
                                        <td>20 Sep, 2022</td>
                                        <td><p class="fw-medium mb-0">Lec-2152</p></td>
                                        <td>
                                            <a href="#javascript: void(0);" class="text-body align-middle fw-medium">Donald Risher</a>
                                        </td>
                                        <td>$240.00</td>
                                        <td><span class="badge badge-soft-success p-2">Google Pay</span></td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="las la-ellipsis-h align-middle fs-18"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    <li>
                                                        <button class="dropdown-item" href="javascript:void(0);"><i class="las la-eye fs-18 align-middle me-2 text-muted"></i>
                                                            View</button>
                                                    </li>
                                                    <li>
                                                        <button class="dropdown-item" href="javascript:void(0);"><i class="las la-pen fs-18 align-middle me-2 text-muted"></i>
                                                            Edit</button>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" href="javascript:void(0);"><i class="las la-file-download fs-18 align-middle me-2 text-muted"></i>
                                                            Download</a>
                                                    </li>
                                                    <li class="dropdown-divider"></li>
                                                    <li>
                                                        <a class="dropdown-item remove-item-btn" href="#">
                                                            <i class="las la-trash-alt fs-18 align-middle me-2 text-muted"></i>
                                                            Delete
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>12 Arl, 2022</td>
                                        <td><p class="fw-medium mb-0">Lec-2153</p></td>
                                        <td>
                                            <a href="#javascript: void(0);" class="text-body align-middle fw-medium">Brody Holman</a>
                                        </td>
                                        <td>$390.00</td>
                                        <td><span class="badge badge-soft-warning p-2">Cash</span></td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="las la-ellipsis-h align-middle fs-18"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    <li>
                                                        <button class="dropdown-item" href="javascript:void(0);"><i class="las la-eye fs-18 align-middle me-2 text-muted"></i>
                                                            View</button>
                                                    </li>
                                                    <li>
                                                        <button class="dropdown-item" href="javascript:void(0);"><i class="las la-pen fs-18 align-middle me-2 text-muted"></i>
                                                            Edit</button>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" href="javascript:void(0);"><i class="las la-file-download fs-18 align-middle me-2 text-muted"></i>
                                                            Download</a>
                                                    </li>
                                                    <li class="dropdown-divider"></li>
                                                    <li>
                                                        <a class="dropdown-item remove-item-btn" href="#">
                                                            <i class="las la-trash-alt fs-18 align-middle me-2 text-muted"></i>
                                                            Delete
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>28 Mar, 2022</td>
                                        <td><p class="fw-medium mb-0">Lec-2154</p></td>
                                        <td>
                                            <a href="#javascript: void(0);" class="text-body align-middle fw-medium">Jolie Hood</a>
                                        </td>
                                        <td>$440.00</td>
                                        <td><span class="badge badge-soft-success p-2">Google Pay</span></td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="las la-ellipsis-h align-middle fs-18"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    <li>
                                                        <button class="dropdown-item" href="javascript:void(0);"><i class="las la-eye fs-18 align-middle me-2 text-muted"></i>
                                                            View</button>
                                                    </li>
                                                    <li>
                                                        <button class="dropdown-item" href="javascript:void(0);"><i class="las la-pen fs-18 align-middle me-2 text-muted"></i>
                                                            Edit</button>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" href="javascript:void(0);"><i class="las la-file-download fs-18 align-middle me-2 text-muted"></i>
                                                            Download</a>
                                                    </li>
                                                    <li class="dropdown-divider"></li>
                                                    <li>
                                                        <a class="dropdown-item remove-item-btn" href="#">
                                                            <i class="las la-trash-alt fs-18 align-middle me-2 text-muted"></i>
                                                            Delete
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>23 Aug, 2022</td>
                                        <td><p class="fw-medium mb-0">Lec-2155</p></td>
                                        <td>
                                            <a href="#javascript: void(0);" class="text-body align-middle fw-medium">Buckminster Wong</a>
                                        </td>
                                        <td>$520.00</td>
                                        <td><span class="badge badge-soft-success p-2">Google Pay</span></td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="las la-ellipsis-h align-middle fs-18"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    <li>
                                                        <button class="dropdown-item" href="javascript:void(0);"><i class="las la-eye fs-18 align-middle me-2 text-muted"></i>
                                                            View</button>
                                                    </li>
                                                    <li>
                                                        <button class="dropdown-item" href="javascript:void(0);"><i class="las la-pen fs-18 align-middle me-2 text-muted"></i>
                                                            Edit</button>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" href="javascript:void(0);"><i class="las la-file-download fs-18 align-middle me-2 text-muted"></i>
                                                            Download</a>
                                                    </li>
                                                    <li class="dropdown-divider"></li>
                                                    <li>
                                                        <a class="dropdown-item remove-item-btn" href="#">
                                                            <i class="las la-trash-alt fs-18 align-middle me-2 text-muted"></i>
                                                            Delete
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>18 Sep, 2022</td>
                                        <td><p class="fw-medium mb-0">Lec-2156</p></td>
                                        <td>
                                            <a href="#javascript: void(0);" class="text-body align-middle fw-medium">Howard Lyons</a>
                                        </td>
                                        <td>$480.00</td>
                                        <td><span class="badge badge-soft-warning p-2">Cash</span></td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="las la-ellipsis-h align-middle fs-18"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    <li>
                                                        <button class="dropdown-item" href="javascript:void(0);"><i class="las la-eye fs-18 align-middle me-2 text-muted"></i>
                                                            View</button>
                                                    </li>
                                                    <li>
                                                        <button class="dropdown-item" href="javascript:void(0);"><i class="las la-pen fs-18 align-middle me-2 text-muted"></i>
                                                            Edit</button>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" href="javascript:void(0);"><i class="las la-file-download fs-18 align-middle me-2 text-muted"></i>
                                                            Download</a>
                                                    </li>
                                                    <li class="dropdown-divider"></li>
                                                    <li>
                                                        <a class="dropdown-item remove-item-btn" href="#">
                                                            <i class="las la-trash-alt fs-18 align-middle me-2 text-muted"></i>
                                                            Delete
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>12 Feb, 2022</td>
                                        <td><p class="fw-medium mb-0">Lec-2157</p></td>
                                        <td>
                                            <a href="#javascript: void(0);" class="text-body align-middle fw-medium">Howard Oneal</a>
                                        </td>
                                        <td>$550.00</td>
                                        <td><span class="badge badge-soft-success p-2">Google Pay</span></td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="las la-ellipsis-h align-middle fs-18"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    <li>
                                                        <button class="dropdown-item" href="javascript:void(0);"><i class="las la-eye fs-18 align-middle me-2 text-muted"></i>
                                                            View</button>
                                                    </li>
                                                    <li>
                                                        <button class="dropdown-item" href="javascript:void(0);"><i class="las la-pen fs-18 align-middle me-2 text-muted"></i>
                                                            Edit</button>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" href="javascript:void(0);"><i class="las la-file-download fs-18 align-middle me-2 text-muted"></i>
                                                            Download</a>
                                                    </li>
                                                    <li class="dropdown-divider"></li>
                                                    <li>
                                                        <a class="dropdown-item remove-item-btn" href="#">
                                                            <i class="las la-trash-alt fs-18 align-middle me-2 text-muted"></i>
                                                            Delete
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>30 Nov, 2022</td>
                                        <td><p class="fw-medium mb-0">Lec-2158</p></td>
                                        <td>
                                            <a href="#javascript: void(0);" class="text-body align-middle fw-medium">Jena Hall</a>
                                        </td>
                                        <td>$170.00</td>
                                        <td><span class="badge badge-soft-danger p-2">Credit Card</span></td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="las la-ellipsis-h align-middle fs-18"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    <li>
                                                        <button class="dropdown-item" href="javascript:void(0);"><i class="las la-eye fs-18 align-middle me-2 text-muted"></i>
                                                            View</button>
                                                    </li>
                                                    <li>
                                                        <button class="dropdown-item" href="javascript:void(0);"><i class="las la-pen fs-18 align-middle me-2 text-muted"></i>
                                                            Edit</button>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" href="javascript:void(0);"><i class="las la-file-download fs-18 align-middle me-2 text-muted"></i>
                                                            Download</a>
                                                    </li>
                                                    <li class="dropdown-divider"></li>
                                                    <li>
                                                        <a class="dropdown-item remove-item-btn" href="#">
                                                            <i class="las la-trash-alt fs-18 align-middle me-2 text-muted"></i>
                                                            Delete
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>23 Sep, 2022</td>
                                        <td><p class="fw-medium mb-0">Lec-2159</p></td>
                                        <td>
                                            <a href="#javascript: void(0);" class="text-body align-middle fw-medium">Paki Edwards</a>
                                        </td>
                                        <td>$720.00</td>
                                        <td><span class="badge badge-soft-danger p-2">Credit Card</span></td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="las la-ellipsis-h align-middle fs-18"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    <li>
                                                        <button class="dropdown-item" href="javascript:void(0);"><i class="las la-eye fs-18 align-middle me-2 text-muted"></i>
                                                            View</button>
                                                    </li>
                                                    <li>
                                                        <button class="dropdown-item" href="javascript:void(0);"><i class="las la-pen fs-18 align-middle me-2 text-muted"></i>
                                                            Edit</button>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" href="javascript:void(0);"><i class="las la-file-download fs-18 align-middle me-2 text-muted"></i>
                                                            Download</a>
                                                    </li>
                                                    <li class="dropdown-divider"></li>
                                                    <li>
                                                        <a class="dropdown-item remove-item-btn" href="#">
                                                            <i class="las la-trash-alt fs-18 align-middle me-2 text-muted"></i>
                                                            Delete
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>16 Aug, 2022</td>
                                        <td><p class="fw-medium mb-0">Lec-2160</p></td>
                                        <td>
                                            <a href="#javascript: void(0);" class="text-body align-middle fw-medium">James Diaz</a>
                                        </td>
                                        <td>$820.00</td>
                                        <td><span class="badge badge-soft-success p-2">Google Pay</span></td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="las la-ellipsis-h align-middle fs-18"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    <li>
                                                        <button class="dropdown-item" href="javascript:void(0);"><i class="las la-eye fs-18 align-middle me-2 text-muted"></i>
                                                            View</button>
                                                    </li>
                                                    <li>
                                                        <button class="dropdown-item" href="javascript:void(0);"><i class="las la-pen fs-18 align-middle me-2 text-muted"></i>
                                                            Edit</button>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" href="javascript:void(0);"><i class="las la-file-download fs-18 align-middle me-2 text-muted"></i>
                                                            Download</a>
                                                    </li>
                                                    <li class="dropdown-divider"></li>
                                                    <li>
                                                        <a class="dropdown-item remove-item-btn" href="#">
                                                            <i class="las la-trash-alt fs-18 align-middle me-2 text-muted"></i>
                                                            Delete
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody><!-- end tbody -->
                            </table><!-- end table -->
                        </div><!-- end table responsive -->
                    </div>
                </div>
            </div>
        </div>

        <div class="row align-items-center mb-4 gy-3">
            <div class="col-md-5">
                <p class="mb-0 text-muted">Showing <b>1</b> to <b>5</b> of <b>10</b> results</p>
            </div>
            <div class="col-sm-auto ms-auto">
                <nav aria-label="...">
                    <ul class="pagination mb-0">
                        <li class="page-item disabled">
                        <span class="page-link">Previous</span>
                        </li>
                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                        <li class="page-item" aria-current="page">
                        <span class="page-link">2</span>
                        </li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item">
                        <a class="page-link" href="#">Next</a>
                        </li>
                    </ul>
                    </nav>
            </div>
        </div>
    
    @endsection
    @section('scripts')
        <!-- Sweet Alerts js -->
        <script src="{{URL::asset('assets/libs/sweetalert2/sweetalert2.min.js')}}"></script>
    @endsection
    
