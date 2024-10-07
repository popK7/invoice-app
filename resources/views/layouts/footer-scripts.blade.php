<!-- JAVASCRIPT -->
<script src="{{URL::asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{URL::asset('assets/libs/simplebar/simplebar.min.js')}}"></script>
<script src="{{URL::asset('assets/libs/node-waves/waves.min.js')}}"></script>
<script src="{{URL::asset('assets/libs/feather-icons/feather.min.js')}}"></script>
<script src="{{URL::asset('assets/js/plugins.js')}}"></script>
<script src="{{ URL::asset('assets/libs/toastify/toastify.min.js') }}"></script>

@yield('scripts')

<!-- App js -->
<script src="{{URL::asset('assets/js/app.js')}}"></script>

<script>

    @if (Session::has('success'))
        Toastify({
        text: "{{ session('success') }}",
        duration: 3000,
        close: true,
        gravity: "top", // `top` or `bottom`
        positionLeft: false, // `true` or `false`
        backgroundColor: "linear-gradient(to right, #00b09b, #96c93d)",
        }).showToast();
    @endif
    @if (Session::has('error'))
        Toastify({
        text: "{{ session('error') }}",
        duration: 3000,
        close: true,
        gravity: "top", // `top` or `bottom`
        positionLeft: false, // `true` or `false`
        backgroundColor: "linear-gradient(to right, #ff947d, #f06548)",
        }).showToast();
    @endif

</script>
@yield('script-bottom')