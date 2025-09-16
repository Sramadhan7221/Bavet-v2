<meta charset="utf-8">
<meta content="width=device-width, initial-scale=1.0" name="viewport">
{{-- <title>Index - FlexStart Bootstrap Template</title> --}}
<title>@yield('title', 'Bavet Jabar')</title>
<meta property="og:title" content="Bavet Jabar" />
<meta name="description" content="Webiste Balai Kesehatan Hewan dan Kesehatan Masyarakat Jawa Barat">
<meta name="keywords" content="Bavet Jabar">

<!-- Favicons -->
<link href="{{ asset('assets/img/favicon.png') }}" rel="icon">
<link href="{{ asset('assets/img/favicon.png') }}" rel="apple-touch-icon">

<!-- Fonts -->
<link href="https://fonts.googleapis.com" rel="preconnect">
<link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Nunito:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

<!-- Vendor CSS Files -->
<link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
<link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
<link href="{{ asset('assets/vendor/aos/aos.css') }}" rel="stylesheet">
<link href="{{ asset('assets/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
<link href="{{ asset('assets/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">

<!-- Main CSS File -->
<link href="{{ asset('assets/css/main.css') }}" rel="stylesheet">

<style>
    .loader {
      display: flex;
      justify-content: center;
      align-items: center;
      gap: 8px;
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, 0.8);
      z-index: 1010;
      visibility: hidden; /* Initially hidden */
      opacity: 0;
      transition: opacity 0.3s ease, visibility 0.3s ease;
    }

    .loader.show {
      visibility: visible;
      opacity: 1;
    }

    .loader span {
      width: 16px;
      height: 16px;
      background: #c561fb;
      border-radius: 50%;
      animation: bounce 0.6s infinite alternate;
    }

    .loader span:nth-child(2) {
      animation-delay: 0.2s;
    }

    .loader span:nth-child(3) {
      animation-delay: 0.4s;
    }

    @keyframes bounce {
      from {
        transform: translateY(0);
        opacity: 1;
      }
      to {
        transform: translateY(-20px);
        opacity: 0.6;
      }
    }
</style>