<!-- ========== App Menu ========== -->
<div class="app-menu navbar-menu">
    <!-- LOGO -->
    <div class="navbar-brand-box">
        @if ($role == 'admin' || $role == 'accountant')
            <!-- Dark Logo-->
            <a href="{{ url('dashboard') }}" class="logo logo-dark">
                <span class="logo-sm">
                    <img src="{{URL::asset('assets/images/'.setting('logo_sm'))}}" alt="" height="22">
                </span>
                <span class="logo-lg">
                    <img src="{{URL::asset('assets/images/'.setting('dark_logo'))}}" alt="" height="21">
                </span>
            </a>
            <!-- Light Logo-->
            <a href="{{ url('dashboard') }}" class="logo logo-light">
                <span class="logo-sm">
                    <img src="{{URL::asset('assets/images/'.setting('logo_sm'))}}" alt="" height="22">
                </span>
                <span class="logo-lg">
                    <img src="{{URL::asset('assets/images/'.setting('light_logo'))}}" alt="" height="21">
                </span>
            </a>
        @else
            <!-- Dark Logo-->
            <a href="{{ url('client-invoice-list') }}" class="logo logo-dark">
                <span class="logo-sm">
                    <img src="{{URL::asset('assets/images/'.setting('logo_sm'))}}" alt="" height="22">
                </span>
                <span class="logo-lg">
                    <img src="{{URL::asset('assets/images/'.setting('dark_logo'))}}" alt="" height="21">
                </span>
            </a>
            <!-- Light Logo-->
            <a href="{{ url('client-invoice-list') }}" class="logo logo-light">
                <span class="logo-sm">
                    <img src="{{URL::asset('assets/images/'.setting('logo_sm'))}}" alt="" height="22">
                </span>
                <span class="logo-lg">
                    <img src="{{URL::asset('assets/images/'.setting('light_logo'))}}" alt="" height="21">
                </span>
            </a>
        @endif
        <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover" id="vertical-hover">
            <i class="ri-record-circle-line"></i>
        </button>
    </div>

    <div id="scrollbar">
        <div class="container-fluid">

            <div id="two-column-menu">
            </div>
            <ul class="navbar-nav" id="navbar-nav">
                <li class="menu-title"><span data-key="t-menu">{{__('translation.Menu')}}</span></li>
                @if ($role == 'admin' || $role == 'accountant')
                    <li class="nav-item">
                        <a class="nav-link menu-link" href="{{ url('dashboard') }}">
                            <i class="las la-house-damage"></i> <span data-key="t-dashboard">{{__('translation.Dashboard')}}</span>
                        </a>
                    </li>

                    <li class="menu-title"><i class="ri-more-fill"></i> <span data-key="t-pages">{{__('translation.Pages')}}</span></li>

                    <li class="nav-item">
                        <a class="nav-link menu-link" href="{{ url('company-list') }}">
                            <i class="las la-building"></i> <span data-key="t-taxes">{{__('translation.Company')}}</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link menu-link" href="#sidebarInvoice" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarInvoice">
                            <i class="las la-file-invoice"></i> <span data-key="t-invoices">{{__('translation.Invoices')}}</span>
                        </a>
                        <div class="collapse menu-dropdown" id="sidebarInvoice">
                            <ul class="nav nav-sm flex-column">
                                <li class="nav-item">
                                    <a href="{{ url('invoice-list') }}" class="nav-link" data-key="t-invoice"> {{__('translation.Invoice')}} </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ url('add-invoice-view') }}" class="nav-link" data-key="t-add-invoice"> {{__('translation.Add Invoice')}} </a>
                                </li>
                                {{-- <li class="nav-item">
                                    <a href="{{ url('view-invoice') }}" class="nav-link" data-key="t-invoice-details"> Invoice Details </a>
                                </li> --}}
                            </ul>
                        </div>
                    </li>

                    
                    <li class="nav-item">
                        <a class="nav-link menu-link @if((url()->current() == route('paid-payment')) || (url()->current() == route('pending-payment')) || (url()->current() == route('refunded-payment'))) {{'active'}} @endif" href="{{ url('payment-list') }}">
                            <i class="lab la-paypal"></i> <span data-key="t-payments">{{__('translation.Payments')}}</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link menu-link" href="#sidebarTax" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarTax">
                            <i class="las la-calculator"></i> <span data-key="t-tax">{{__('translation.Tax/Charges')}}</span>
                        </a>
                        <div class="collapse menu-dropdown" id="sidebarTax">
                            <ul class="nav nav-sm flex-column">
                                <li class="nav-item">
                                    <a class="nav-link menu-link" href="{{ url('tax-list') }}"><span data-key="t-taxes">{{__('translation.Tax')}}</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link menu-link" href="{{ url('discount-list') }}"><span data-key="t-taxes">{{__('translation.Discount')}}</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link menu-link" href="{{ url('shipping-charge-list') }}"><span data-key="t-taxes">{{__('translation.Shipping Charge')}}</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>


                    <li class="nav-item">
                        <a class="nav-link menu-link" href="#sidebarProducts" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarProducts">
                            <i class="las la-shopping-bag"></i> <span data-key="t-products">{{__('translation.Products')}}</span>
                        </a>
                        <div class="collapse menu-dropdown" id="sidebarProducts">
                            <ul class="nav nav-sm flex-column">
                                <li class="nav-item">
                                    <a href="{{ url('product-list') }}" class="nav-link" data-key="t-product-list"> {{__('translation.Product List')}} </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ url('add-product-view') }}" class="nav-link" data-key="t-add-product"> {{__('translation.Add Product')}} </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ url('brand-list') }}" class="nav-link" data-key="t-add-product"> {{__('translation.Add New Brand')}} </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ url('category-list') }}" class="nav-link" data-key="t-add-product"> {{__('translation.Add New Category')}} </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ url('color-list') }}" class="nav-link" data-key="t-add-product"> {{__('translation.Add Product Color')}} </a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link menu-link" href="#sidebarReport" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarReport">
                            <i class="las la-paste"></i> <span data-key="t-report">{{__('translation.Reports')}}</span>
                        </a>
                        <div class="collapse menu-dropdown" id="sidebarReport">
                            <ul class="nav nav-sm flex-column">
                                <li class="nav-item">
                                    <a href="{{ url('sale-reports') }}" class="nav-link" data-key="t-sale-report"> {{__('translation.Sale Report')}} </a>
                                </li>
                                {{-- <li class="nav-item">
                                    <a href="expenses-report.html" class="nav-link" data-key="t-expenses-report"> Expenses Report </a>
                                </li> --}}
                            </ul>
                        </div>
                    </li>
                
                    <li class="nav-item">
                        <a class="nav-link menu-link" href="{{ url('client-list') }}">
                            <i class="las la-user-alt"></i> <span data-key="t-users">{{__('translation.Clients')}}</span>
                        </a>
                    </li>
                @endif

                @if ($role == 'admin')
                    <li class="nav-item">
                        <a class="nav-link menu-link" href="{{ url('accountant-list') }}">
                            <i class="las la-user-circle"></i> <span data-key="t-users">{{__('translation.Accountants')}}</span>
                        </a>
                    </li>
                @endif

                @if ($role == 'client')
                    <li class="nav-item">
                        <a class="nav-link menu-link" href="{{ url('client-invoice-list') }}">
                            <i class="las la-file-invoice"></i></i> <span data-key="t-invoices">{{__('translation.Invoice List')}}</span>
                        </a>
                    </li>
                @endif

            </ul>
        </div>
        <!-- Sidebar -->
    </div>

    <div class="sidebar-background"></div>
</div>
<!-- Left Sidebar End -->
<!-- Vertical Overlay-->
<div class="vertical-overlay"></div>