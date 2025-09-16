<!DOCTYPE html>
<html lang="en">

<head>
    <title>@yield('title', 'Login - Bavet Jabar')</title>
    @include('partials.admin.head')
    @stack('styles')
</head>

<body class="authentication-bg position-relative" style="height: 100vh;">
    @include('sweetalert::alert')
    @yield('content')

    <!-- Vendor js -->
    <script src="{{ asset('admin/js/vendor.min.js') }}"></script>
    <script src="{{ asset('admin/vendor/lucide/umd/lucide.min.js') }}"></script>
    @stack('scripts')
    <!-- App js -->
    <script src="{{ asset('admin/js/app.min.js') }}"></script>

</body>
</html>