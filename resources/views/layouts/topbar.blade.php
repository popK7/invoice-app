<header id="page-topbar">
    <div class="layout-width">
        <div class="navbar-header">
            <div class="d-flex">
                <!-- LOGO -->
                <div class="navbar-brand-box horizontal-logo">
                    <a href="{{ url('dashboard') }}" class="logo logo-dark">
                        <span class="logo-sm">
                            <img src="{{URL::asset('assets/images/'.setting('logo_sm'))}}" alt="" height="22">
                        </span>
                        <span class="logo-lg">
                            <img src="{{URL::asset('assets/images/'.setting('dark_logo'))}}" alt="" height="21">
                        </span>
                    </a>

                    <a href="{{ url('dashboard') }}" class="logo logo-light">
                        <span class="logo-sm">
                            <img src="{{URL::asset('assets/images/'.setting('logo_sm'))}}" alt="" height="22">
                        </span>
                        <span class="logo-lg">
                            <img src="{{URL::asset('assets/images/'.setting('light_logo'))}}" alt="" height="21">
                        </span>
                    </a>
                </div>

                <button type="button" class="btn btn-sm px-3 fs-16 header-item vertical-menu-btn topnav-hamburger" id="topnav-hamburger-icon">
                    <span class="hamburger-icon">
                        <span></span>
                        <span></span>
                        <span></span>
                    </span>
                </button>

                <!-- App Search-->
                <form class="app-search d-none d-md-block me-2">
                    <div class="dropdown-menu dropdown-menu-lg" id="search-dropdown">
                        <div data-simplebar class="search-dropdown-scroll">
                            <!-- item-->                 
                             <div class="dropdown-header">
                                <h6 class="text-overflow text-muted mb-0 text-uppercase" data-key="t-research"> {{__('translation.Research')}}</h6>
                            </div>

                            <div class="dropdown-item bg-transparent text-wrap">
                                <a href="{{ url('dashboard') }}" class="btn btn-soft-secondary btn-sm btn-rounded" data-key="t-setup"> {{__('translation.Setup')}} <i class="mdi mdi-magnify ms-1"></i></a>
                                <a href="{{ url('dashboard') }}" class="btn btn-soft-secondary btn-sm btn-rounded" data-key="t-buttons">{{__('translation.Buttons')}} <i class="mdi mdi-magnify ms-1"></i></a>
                            </div>
                            <!-- item-->
                            <div class="dropdown-header mt-2">
                                <h6 class="text-overflow text-muted mb-1 text-uppercase" data-key="t-pages">{{__('translation.Pages')}}</h6>
                            </div>

                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item notify-item">
                                <i class="ri-bubble-chart-line align-middle fs-18 text-muted me-2" ></i>
                                <span data-key="t-analytics-dashboard">{{__('translation.Analytics dashboard')}}</span>
                            </a>

                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item notify-item">
                                <i class="ri-lifebuoy-line align-middle fs-18 text-muted me-2"></i>
                                <span  data-key="t-help-center">{{__('translation.Help center')}}</span>
                            </a>

                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item notify-item">
                                <i class="ri-user-settings-line align-middle fs-18 text-muted me-2"></i>
                                <span data-key="t-account-setting">{{__('translation.Account_setting')}}</span>
                            </a>

                            <!-- item-->
                            <div class="dropdown-header mt-2">
                                <h6 class="text-overflow text-muted mb-2 text-uppercase" data-key="t-member">{{__('translation.Member')}}</h6>
                            </div>

                            <div class="notification-list">
                                
                            </div>
                        </div>

                        <div class="text-center pt-3 pb-1">
                            <a href="pages-search-results.html" class="btn btn-primary btn-sm" data-key="t-view-result">{{__('translation.View Result')}} <i class="ri-arrow-right-line ms-1"></i></a>
                        </div>
                    </div>
                </form>

            </div>

            <div class="d-flex align-items-center">

                

                <div class="dropdown d-md-none topbar-head-dropdown header-item">
                    <button type="button" class="btn btn-icon btn-topbar btn-ghost-primary rounded-circle" id="page-header-search-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="bx bx-search fs-22"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0" aria-labelledby="page-header-search-dropdown">
                        <form class="p-3">
                            <div class="form-group m-0">
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Search ..." aria-label="Recipient's username">
                                    <button class="btn btn-primary" type="submit"><i class="mdi mdi-magnify"></i></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="dropdown ms-1 topbar-head-dropdown header-item">
                    <button type="button" class="btn btn-icon btn-topbar btn-ghost-primary rounded-circle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    @switch(Session::get('lang'))
                        @case('ru')
                        <img src="{{ URL::asset('/assets/images/flags/russia.svg') }}" class="rounded" alt="Header Language" height="20">
                        @break
                        @case('it')
                        <img src="{{ URL::asset('/assets/images/flags/italy.svg') }}" class="rounded" alt="Header Language" height="20">
                        @break
                        @case('sp')
                        <img src="{{ URL::asset('/assets/images/flags/spain.svg') }}" class="rounded" alt="Header Language" height="20">
                        @break
                        @case('ch')
                        <img src="{{ URL::asset('/assets/images/flags/china.svg') }}" class="rounded" alt="Header Language" height="20">
                        @break
                        @case('fr')
                        <img src="{{ URL::asset('/assets/images/flags/french.svg') }}" class="rounded" alt="Header Language" height="20">
                        @break
                        @case('gr')
                        <img src="{{ URL::asset('/assets/images/flags/germany.svg') }}" class="rounded" alt="Header Language" height="20">
                        @break
                        @case('ar')
                        <img src="{{ URL::asset('/assets/images/flags/ae.svg') }}" class="rounded" alt="Header Language" height="20">
                        @break
                        @default
                        <img src="{{ URL::asset('/assets/images/flags/us.svg') }}" class="rounded" alt="Header Language" height="20">
                    @endswitch
                    </button>
                    <div class="dropdown-menu dropdown-menu-end">

                        <!-- item-->
                        <a href="{{ url('lang/en') }}" class="dropdown-item notify-item language py-2" data-lang="en" title="English">
                            <img src="{{URL::asset('assets/images/flags/us.svg')}}" alt="user-image" class="me-2 rounded" height="18">
                            <span class="align-middle">English</span>
                        </a>
                        <!-- item-->
                        <a href="{{ url('lang/ar') }}" class="dropdown-item notify-item language" data-lang="ar" title="Arabic">
                            <img src="{{URL::asset('assets/images/flags/ae.svg')}}" alt="user-image" class="me-2 rounded" height="18">
                            <span class="align-middle">Arabic</span>
                        </a>

                        <!-- item-->
                        <a href="{{ url('lang/sp') }}" class="dropdown-item notify-item language" data-lang="sp" title="Spanish">
                            <img src="{{URL::asset('assets/images/flags/spain.svg')}}" alt="user-image" class="me-2 rounded" height="18">
                            <span class="align-middle">Española</span>
                        </a>

                        <!-- item-->
                        <a href="{{ url('lang/gr') }}" class="dropdown-item notify-item language" data-lang="gr" title="German">
                            <img src="{{URL::asset('assets/images/flags/germany.svg')}}" alt="user-image" class="me-2 rounded" height="18"> <span class="align-middle">Deutsche</span>
                        </a>

                        <!-- item-->
                        <a href="{{ url('lang/it') }}" class="dropdown-item notify-item language" data-lang="it" title="Italian">
                            <img src="{{URL::asset('assets/images/flags/italy.svg')}}" alt="user-image" class="me-2 rounded" height="18">
                            <span class="align-middle">Italiana</span>
                        </a>

                        <!-- item-->
                        <a href="{{ url('lang/ru') }}" class="dropdown-item notify-item language" data-lang="ru" title="Russian">
                            <img src="{{URL::asset('assets/images/flags/russia.svg')}}" alt="user-image" class="me-2 rounded" height="18">
                            <span class="align-middle">русский</span>
                        </a>

                        <!-- item-->
                        <a href="{{ url('lang/ch') }}" class="dropdown-item notify-item language" data-lang="ch" title="Chinese">
                            <img src="{{URL::asset('assets/images/flags/china.svg')}}" alt="user-image" class="me-2 rounded" height="18">
                            <span class="align-middle">中国人</span>
                        </a>

                        <!-- item-->
                        <a href="{{ url('lang/fr') }}" class="dropdown-item notify-item language" data-lang="fr" title="French">
                            <img src="{{URL::asset('assets/images/flags/french.svg')}}" alt="user-image" class="me-2 rounded" height="18">
                            <span class="align-middle">français</span>
                        </a>
                    </div>
                </div>

                <div class="ms-1 header-item d-none d-sm-flex">
                    <button type="button" class="btn btn-icon btn-topbar btn-ghost-primary rounded-circle" data-toggle="fullscreen">
                        <i class='las la-expand fs-24'></i>
                    </button>
                </div>

                <div class="ms-1 header-item d-none d-sm-flex">
                    <button type="button" class="btn btn-icon btn-topbar btn-ghost-primary rounded-circle light-dark-mode">
                        <i class='las la-moon fs-24'></i>
                    </button>
                </div>

                <div class="dropdown topbar-head-dropdown ms-1 header-item" id="notificationDropdown">
                    <button type="button" class="btn btn-icon btn-topbar btn-ghost-primary rounded-circle" id="page-header-notifications-dropdown" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-haspopup="true" aria-expanded="false">
                        <i class='las la-bell fs-24'></i>
                        <span class="position-absolute topbar-badge fs-9 translate-middle badge rounded-pill bg-danger">{{count($notification)}}<span class="visually-hidden">unread messages</span></span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0" aria-labelledby="page-header-notifications-dropdown">

                        <div class="dropdown-head rounded-top">
                            <div class="p-3 bg-primary bg-pattern">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <h6 class="m-0 fs-16 fw-semibold text-white" data-key="t-notifications">{{__('translation.Notifications')}} </h6>
                                    </div>
                                    <div class="col-auto dropdown-tabs">
                                        <span class="badge badge-soft-light fs-13"> {{count($notification)}} New</span>
                                    </div>
                                </div>
                            </div>

                            <div class="pt-2">
                                <div data-simplebar class="pe-2 notification-dropdown-scroll">

                                    @foreach ($notification as $item)
                                        <div class="text-reset notification-item d-block dropdown-item position-relative">
                                            <div class="d-flex">
                                                <div class="avatar-xs me-3">
                                                    <span class="avatar-title bg-soft-info text-info rounded-circle fs-16">
                                                        <img src="@if($item->user->profile_image != ''){{ URL::asset('assets/images/users/' . $item->user->profile_image) }}@else{{ URL::asset('assets/images/users/user-dummy-img.jpg') }}@endif" class="mr-3 rounded-circle avatar-xs" alt="user-pic">
                                                    </span>
                                                </div>
                                                <div class="flex-1">
                                                    <a href="#!" class="stretched-link">
                                                        <h6 class="mt-0 fs-14 mb-1 lh-base"><b>{{$item->title}}</b></h6>
                                                    </a>
                                                    <div class="fs-13 text-muted">
                                                        <p class="mb-1"><b>{{$item->user->first_name.' '.$item->user->last_name}}</b> {{$item->data}}.</p>
                                                    </div>
                                                    <p class="mb-0 fs-11 fw-medium text-uppercase text-muted">
                                                        <span><i class="mdi mdi-clock-outline"></i> {{ $item->created_at->diffForHumans() }} </span>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                    
                                    <div class="my-3 text-center view-all">
                                        <a class="btn btn-soft-success btn-sm waves-effect waves-light" href="{{ url('/notification-list') }}">
                                            <i class="ri-arrow-right-line align-middle"></i> {{ __("All Notifications") }}
                                        </a>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="dropdown header-item">
                    <button type="button" class="btn" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="d-flex align-items-center">
                            <img class="rounded-circle header-profile-user" src="{{URL::asset('assets/images/users/'.$user->profile_image)}}" alt="Header Avatar">
                            <span class="text-start ms-xl-2">
                                <span class="d-none d-xl-inline-block fw-medium user-name-text fs-16">{{$user->first_name.' '.$user->last_name}}<i class="las la-angle-down fs-12 ms-1"></i></span>
                            </span>
                        </span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end">
                        <!-- item-->
                        <a class="dropdown-item" href="{{url('view-profile')}}"><i class="bx bx-user fs-15 align-middle me-1"></i> <span key="t-profile">{{__('translation.Profile')}}</span></a>
                        
                        @if ($role == 'admin' || $role == 'accountant')
                            <a class="dropdown-item d-block" href="{{url('view-site-settings')}}"><span class="badge bg-success float-end"></span><i class="bx bx-wrench fs-15 align-middle me-1"></i> <span key="t-settings">{{__('translation.Site Settings')}}</span></a>
                        @endif

                        <div class="dropdown-divider"></div>
                        <form action="{{url('logout')}}" method="POST" class="">
                        @csrf
                            <button class="dropdown-item text-danger" type="submit"><i class="bx bx-power-off fs-15 align-middle me-1 text-danger"></i> <span key="t-logout">{{__('translation.Logout')}}</span></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>