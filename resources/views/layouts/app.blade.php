<!DOCTYPE html>
<html lang="en">

<head>
    <title>@yield('title', 'Bavet Jabar')</title>
    @include('partials.admin.head')
    <style>
        .sub-nav {
            font-size: .85rem!important;
        }
    </style>
    @stack('styles')
</head>

<body>
    <x-loader/>
	<!-- Begin page -->
	<div class="wrapper">

		<!-- ========== Topbar Start ========== -->
        @include('partials.admin.navbar')
        <!-- ========== Topbar End ========== -->

        <!-- Left Sidebar Start -->
        @include('partials.admin.sidebar')
        <!-- Left Sidebar End -->
            
        <!-- ============================================================== -->
        <!-- Start Page Content here -->
        <!-- ============================================================== -->

        <div class="content-page">
            <div class="content">

                <!-- Start Content-->
                @yield('content')
                <!-- end container -->

                <!-- Footer Start -->
                @include('partials.admin.footer')
                <!-- end Footer -->

            </div>
            <!-- content -->
        </div>

        <!-- ============================================================== -->
        <!-- End Page content -->
        <!-- ============================================================== -->

    </div>
    <!-- END wrapper -->

    <!-- Theme Settings -->
    @include('partials.admin.theme-setting')

    <!-- Vendor js -->
    <script src="{{ asset('admin/js/vendor.min.js') }}"></script>
    <script src="{{ asset('admin/vendor/lucide/umd/lucide.min.js') }}"></script>
    @stack('scripts')
    <!-- App js -->
    <script src="{{ asset('admin/js/app.min.js') }}"></script>
    <script>
    $("#logout").click(function () {
        $.ajax({
            url: "{{ route('logout') }}",
            type: 'POST',
            data: {
                _token: "{{ csrf_token() }}"
            },
            beforeSend: function () {
                $(".loader").addClass("show");
            },
            success: function(response) {
                setTimeout(() => {
                    window.location.replace("{{ url('login') }}")
                }, 600);
            },
            error: function(response) {
                alert('Error: ' + response.responseJSON.message);
            }
        });
    })
</script>
</body>
</html>