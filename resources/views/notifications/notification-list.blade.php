@extends('layouts.master')
@section('title') Notification list @endsection
@section('css')

@endsection

@section('body')
<body>
    @endsection

    @section('content')

    @component('components.breadcrumb')
    @slot('title') Notification @endslot
    @slot('pagetitle') Notification List @endslot
    @endcomponent

        <!-- end page title -->
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div data-simplebar>
                                    @if(count($notifications) > 0)
                                        @foreach ($notifications as $item)
                                            <div class="media mb-3 p-2 bg-light">
                                                <img src="@if ($item->user->profile_image != ''){{ URL::asset('assets/images/users/' . $item->user->profile_image) }}@else{{ URL::asset('assets/images/users/user-dummy-img.jpg') }}@endif" class="mr-3 rounded-circle avatar-xs"
                                                    alt="user-pic">
                                                <div class="media-body">
                                                    <h6 class="mt-0 mb-1">
                                                        {{ $item->title }} 
                                                    </h6>
                                                    <div class="font-sixe-12">
                                                        <p class="mb-0">{{ $item->user->first_name . ' ' . $item->user->last_name }} {{ $item->data }}</p>
                                                    </div>
                                                    <div class="font-size-12 text-muted">
                                                        <p class="mb-0"><i class="mdi mdi-clock-outline"></i>
                                                            {{ $item->created_at->diffForHumans() }}
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <p>No matching records found</p>
                                    @endif
                                    <div class="col-md-12 text-center mt-3">
                                        <div class="d-flex justify-content-center">
                                            {{ $notifications->links("pagination::bootstrap-4") }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    
    @endsection

    @section('scripts')
        
    @endsection
