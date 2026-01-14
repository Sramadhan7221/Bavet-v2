<!DOCTYPE html>
<html lang="en">

<head>
    <title>@yield('title', 'Bavet Jabar')</title>
    @include('partials.admin.head')
    <style>
        .sub-nav {
            font-size: .85rem!important;
        }
    
        /* Loader Container - Hidden by default */
        .loader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.3s ease, visibility 0.3s ease;
        }

        /* Show loader when class is added */
        .loader.show {
            opacity: 0.98;
            visibility: visible;
        }

        /* Loader animation container */
        .loader span {
            width: 20px;
            height: 20px;
            margin: 0 8px;
            background: #ffffff;
            border-radius: 50%;
            display: inline-block;
            animation: pulse 1.4s infinite ease-in-out both;
            box-shadow: 0 0 20px rgba(255, 255, 255, 0.5);
        }

        /* Stagger animation delays */
        .loader span:nth-child(1) {
            animation-delay: -0.32s;
            background: #ff6b6b;
        }

        .loader span:nth-child(2) {
            animation-delay: -0.16s;
            background: #4ecdc4;
        }

        .loader span:nth-child(3) {
            animation-delay: 0s;
            background: #ffe66d;
        }

        /* Pulse animation */
        @keyframes pulse {
            0%, 80%, 100% {
                transform: scale(0);
                opacity: 0.5;
            }
            40% {
                transform: scale(1.5);
                opacity: 1;
            }
        }

        /* Alternative: Bouncing dots animation */
        /* Uncomment to use this animation instead */
        /*
        .loader span {
            animation: bounce 1.4s infinite ease-in-out both;
        }

        @keyframes bounce {
            0%, 80%, 100% {
                transform: translateY(0);
            }
            40% {
                transform: translateY(-30px);
            }
        }
        */

        /* Alternative: Rotating orbital animation */
        /* Uncomment to use this animation instead */
        /*
        .loader {
            perspective: 1000px;
        }

        .loader span {
            position: absolute;
            animation: orbit 2s infinite linear;
        }

        .loader span:nth-child(1) {
            animation-delay: 0s;
        }

        .loader span:nth-child(2) {
            animation-delay: -0.66s;
        }

        .loader span:nth-child(3) {
            animation-delay: -1.33s;
        }

        @keyframes orbit {
            0% {
                transform: rotateZ(0deg) translateX(60px) rotateZ(0deg);
            }
            100% {
                transform: rotateZ(360deg) translateX(60px) rotateZ(-360deg);
            }
        }
        */
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