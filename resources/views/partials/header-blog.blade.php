<header id="header" class="header d-flex align-items-center sticky-top">
    <div class="container-fluid container-xl position-relative d-flex align-items-center">

        <a href="{{ url('/') }}" class="logo d-flex align-items-center me-auto">
            <img src="{{ asset('assets/img/logo.png') }}" alt="">
        </a>

        <x-navbar active="{{ $active }}"/>
    </div>
</header>