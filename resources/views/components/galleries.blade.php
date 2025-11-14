<div class="isotope-layout" data-default-filter="*" data-layout="masonry" data-sort="original-order">

    {{-- <ul class="portfolio-filters isotope-filters" data-aos="fade-up" data-aos-delay="100"> --}}
    {{-- <li data-filter="*" class="filter-active">All</li>
    <li data-filter=".filter-app">App</li>
    <li data-filter=".filter-product">Product</li>
    <li data-filter=".filter-branding">Branding</li>
    <li data-filter=".filter-books">Books</li> --}}
    {{-- </ul><!-- End Portfolio Filters --> --}}

    <div class="row gy-4 isotope-container" data-aos="fade-up" data-aos-delay="200">

        {{-- <div class="col-lg-4 col-md-6 portfolio-item isotope-item filter-app">
            <div class="portfolio-content h-100">
            <img src="{{ asset('assets/img/portfolio/app-1.jpg') }}" class="img-fluid" alt="">
            <div class="portfolio-info">
                <h4>App 1</h4>
                <p>Lorem ipsum, dolor sit amet consectetur</p>
                <a href="{{ asset('assets/img/portfolio/app-1.jpg') }}" title="App 1" data-gallery="portfolio-gallery-app" class="glightbox preview-link"><i class="bi bi-zoom-in"></i></a>
                <a href="portfolio-details.html" title="More Details" class="details-link"><i class="bi bi-link-45deg"></i></a>
            </div>
            </div>
        </div><!-- End Portfolio Item --> --}}

        @foreach ($list as $item)
            <div class="col-lg-4 col-md-6 portfolio-item isotope-item">
                <div class="portfolio-content h-100">
                <img src="{{ $item->banner }}" class="img-fluid" alt="">
                <div class="portfolio-info">
                    <h4>{{ $item->title }}</h4>
                    <p>{!! $item->content !!}</p>
                    <a href="{{ $item->banner }}" title="{{ $item->title }}" data-gallery="portfolio-gallery-product" class="glightbox preview-link"><i class="bi bi-zoom-in"></i></a>
                    <a href="{{ route('galeri.detail', ['page' => $item->slug]) }}" title="More Details" class="details-link"><i class="bi bi-link-45deg"></i></a>
                </div>
                </div>
            </div><!-- End Portfolio Item -->
        @endforeach

    </div><!-- End Portfolio Container -->

</div>