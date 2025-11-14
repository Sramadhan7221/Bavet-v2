<!DOCTYPE html>
<html lang="en">

<head>
  @include('partials.head')
  @stack('styles')
</head>

<body class="portfolio-details-page">

  @include('partials.header-blog',['active' => "about"])

  <main class="main">

    <!-- Page Title -->
    <div class="page-title">
      <div class="heading">
        {{-- <div class="container">
          <div class="row d-flex justify-content-center text-center">
            <div class="col-lg-8">
              <h1>Portfolio Details</h1>
              <p class="mb-0">Odio et unde deleniti. Deserunt numquam exercitationem. Officiis quo odio sint voluptas consequatur ut a odio voluptatem. Sit dolorum debitis veritatis natus dolores. Quasi ratione sint. Sit quaerat ipsum dolorem.</p>
            </div>
          </div>
        </div> --}}
      </div>
      <nav class="breadcrumbs">
        <div class="container">
          <ol>
            @foreach ($breadcrumb as $item)
              @if ($item['current'])
                <li class="current">{{ $item['title'] }}</li>
              @else
                <li><a href="{{ $item['url'] }}">{{ $item['title'] }}</a></li>
              @endif
            @endforeach
          </ol>
        </div>
      </nav>
    </div><!-- End Page Title -->

    <!-- Portfolio Details Section -->
    <section id="portfolio-details" class="portfolio-details section">

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="row gy-4">

          <div class="col-lg-8">
            <div class="portfolio-details-slider swiper init-swiper">

              <script type="application/json" class="swiper-config">
                {
                  "loop": true,
                  "speed": 600,
                  "autoplay": {
                    "delay": 5000
                  },
                  "slidesPerView": "auto",
                  "pagination": {
                    "el": ".swiper-pagination",
                    "type": "bullets",
                    "clickable": true
                  }
                }
              </script>

              <div class="swiper-wrapper align-items-center">

                @foreach ($assets as $item)    
                    <div class="swiper-slide">
                        <img src="{{ $item }}" alt="">
                    </div>
                @endforeach

              </div>
              <div class="swiper-pagination"></div>
            </div>
          </div>

          <div class="col-lg-4">
            <div class="portfolio-description" data-aos="fade-up" data-aos-delay="200">
              <h2>{{ $gallery_title }}</h2>
              {!! $desc !!}
            </div>
          </div>

        </div>

      </div>

    </section><!-- /Portfolio Details Section -->

  </main>

  <x-footer/>

  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  @include('partials.scripts')

</body>

</html>