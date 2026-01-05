<!DOCTYPE html>
<html lang="en">

<head>
  @include('partials.head')
  
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
  <style>
    /* Banner container with background image and purple overlay */
    .banner-bg {
      position: relative;
      background-image: url('{{ asset('assets/img/rs.png') }}');
      background-size: cover;
      background-position: top;
      background-attachment: fixed;
      padding: 80px 0;
      min-height: 400px;
    }

    /* Purple overlay with transparency to show background image */
    .banner-overlay {
      position: absolute;
      inset: 0;
      background-color: rgba(128, 0, 128, 0.5); /* #800080 with 50% transparency */
      pointer-events: none;
      z-index: 1;
    }

    .container {
      max-width: 1200px;
      margin: 0 auto;
      padding: 0 20px;
      position: relative;
      z-index: 2;
    }

    /* Slider wrapper */
    .custom-slider {
      width: 100%;
      overflow: hidden;
      border-radius: 12px;
    }

    /* Individual slider item - fixed height container */
    .custom-slider .slider-item {
      display: flex;
      align-items: center;
      justify-content: center;
      height: 300px; /* Fixed height for layout stability */
      background: rgba(255, 255, 255, 0.1);
      border-radius: 8px;
      padding: 10px;
    }

    /* Image styling - landscape default with portrait protection */
    .custom-slider .slider-img {
      width: 500px; /* Default width for landscape images */
      max-width: 100%; /* Responsive constraint */
      height: auto;
      max-height: 250px; /* Prevents portrait images from breaking layout */
      object-fit: contain; /* Maintains aspect ratio without stretching */
      display: block;
      margin: 0 auto;
      border-radius: 8px;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
    }

    /* Swiper navigation buttons */
    .swiper-button-next,
    .swiper-button-prev {
      color: #fff;
      background: rgba(128, 0, 128, 0.7);
      width: 45px;
      height: 45px;
      border-radius: 50%;
    }

    .swiper-button-next:after,
    .swiper-button-prev:after {
      font-size: 20px;
      font-weight: bold;
    }

    .swiper-button-next:hover,
    .swiper-button-prev:hover {
      background: rgba(128, 0, 128, 0.9);
    }

    /* Pagination dots */
    .swiper-pagination-bullet {
      background: #fff;
      opacity: 0.5;
      width: 12px;
      height: 12px;
    }

    .swiper-pagination-bullet-active {
      background: #800080;
      opacity: 1;
    }

    .badge-tahun {
      position: absolute;
      top: 10px;
      right: 10px;
      background-color: #007bff;
      color: white;
      padding: 4px 8px;
      border-radius: 4px;
      font-size: 0.75rem;
      font-weight: bold;
    }

    .artikel-recent-posts {
      padding: 60px 0;
    }

    .artikel-container {
      max-width: 1200px;
      margin: 0 auto;
      padding: 0 20px;
    }

    .artikel-section-title {
      text-align: center;
      margin-bottom: 50px;
    }

    .artikel-section-title h2 {
      font-size: 32px;
      font-weight: bold;
      color: #333;
      margin-bottom: 10px;
    }

    .artikel-section-title p {
      color: #666;
      font-size: 16px;
      margin-bottom: 20px;
    }

    /* Article Card Styling */
    .artikel-card {
      background: #fff;
      border-radius: 12px;
      overflow: hidden;
      box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
      transition: transform 0.3s ease, box-shadow 0.3s ease;
      height: 100%;
      display: flex;
      flex-direction: column;
    }

    .artikel-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 5px 25px rgba(0, 0, 0, 0.15);
    }

    /* Banner Image Container - Landscape Format with Portrait Protection */
    .artikel-banner-wrapper {
      position: relative;
      width: 100%;
      height: 200px; /* Fixed height for consistency */
      overflow: hidden;
      background: #f0f0f0;
    }

    .artikel-banner {
      width: 100%;
      height: 100%;
      object-fit: cover; /* Cover untuk landscape, akan crop jika portrait */
      object-position: center;
      transition: transform 0.3s ease;
    }

    .artikel-card:hover .artikel-banner {
      transform: scale(1.05);
    }

    /* Date Badge */
    .artikel-date {
      position: absolute;
      bottom: 10px;
      right: 10px;
      background: rgba(128, 0, 128, 0.9);
      color: #fff;
      padding: 5px 12px;
      border-radius: 20px;
      font-size: 12px;
      font-weight: 600;
    }

    /* Content Area */
    .artikel-content {
      padding: 20px;
      flex-grow: 1;
      display: flex;
      flex-direction: column;
    }

    .artikel-title {
      font-size: 18px;
      font-weight: 700;
      color: #333;
      margin-bottom: 10px;
      line-height: 1.4;
      /* Limit to 2 lines */
      display: -webkit-box;
      -webkit-line-clamp: 2;
      -webkit-box-orient: vertical;
      overflow: hidden;
      text-overflow: ellipsis;
      min-height: 50px; /* Reserve space for 2 lines */
    }

    .artikel-description {
      font-size: 14px;
      color: #666;
      margin-bottom: 15px;
      line-height: 1.6;
      /* CRITICAL: Limit to exactly 2 lines */
      display: -webkit-box;
      -webkit-line-clamp: 2;
      -webkit-box-orient: vertical;
      overflow: hidden;
      text-overflow: ellipsis;
      height: 44px; /* Fixed height: 14px * 1.6 * 2 lines ≈ 44px */
    }

    .artikel-meta {
      display: flex;
      align-items: center;
      gap: 5px;
      color: #999;
      font-size: 13px;
      margin-bottom: 15px;
      padding-bottom: 15px;
      border-bottom: 1px solid #eee;
    }

    .artikel-meta i {
      font-size: 14px;
    }

    .artikel-readmore {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      color: #800080;
      text-decoration: none;
      font-weight: 600;
      font-size: 14px;
      margin-top: auto;
      transition: gap 0.3s ease;
    }

    .artikel-readmore:hover {
      gap: 12px;
      color: #600060;
    }

    .artikel-readmore i {
      font-size: 16px;
      transition: transform 0.3s ease;
    }

    .artikel-readmore:hover i {
      transform: translateX(3px);
    }

    /* Swiper Customization */
    .artikel-posts-slider {
      padding: 0 0 50px 0;
    }

    .artikel-posts-slider .swiper-button-next,
    .artikel-posts-slider .swiper-button-prev {
      color: #800080;
      background: #fff;
      width: 45px;
      height: 45px;
      border-radius: 50%;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    .artikel-posts-slider .swiper-button-next:after,
    .artikel-posts-slider .swiper-button-prev:after {
      font-size: 20px;
      font-weight: bold;
    }

    .artikel-posts-slider .swiper-button-next:hover,
    .artikel-posts-slider .swiper-button-prev:hover {
      background: #800080;
      color: #fff;
    }

    .artikel-posts-slider .swiper-pagination-bullet {
      background: #ccc;
      opacity: 1;
      width: 10px;
      height: 10px;
    }

    .artikel-posts-slider .swiper-pagination-bullet-active {
      background: #800080;
      width: 30px;
      border-radius: 5px;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
      .banner-bg {
        padding: 60px 0;
        min-height: 350px;
      }

      .custom-slider .slider-item {
        height: 250px;
      }

      .custom-slider .slider-img {
        width: 400px;
        max-height: 200px;
      }

      .swiper-button-next,
      .swiper-button-prev {
        width: 35px;
        height: 35px;
      }

      .swiper-button-next:after,
      .swiper-button-prev:after {
        font-size: 16px;
      }
    }

    @media (max-width: 576px) {
      .banner-bg {
        padding: 40px 0;
        min-height: 300px;
      }

      .custom-slider .slider-item {
        height: 200px;
      }

      .custom-slider .slider-img {
        width: 300px;
        max-height: 180px;
      }

      .swiper-button-next,
      .swiper-button-prev {
        width: 30px;
        height: 30px;
      }

      .swiper-button-next:after,
      .swiper-button-prev:after {
        font-size: 14px;
      }
    }

        /* Responsive */
    @media (max-width: 1024px) {
      .artikel-banner-wrapper {
        height: 180px;
      }

      .artikel-title {
        font-size: 16px;
        min-height: 45px;
      }
    }

    @media (max-width: 640px) {
      .artikel-recent-posts {
        padding: 40px 0;
      }

      .artikel-section-title h2 {
        font-size: 26px;
      }

      .artikel-banner-wrapper {
        height: 160px;
      }

      .artikel-title {
        font-size: 15px;
        min-height: 42px;
      }

      .artikel-description {
        font-size: 13px;
        height: 41px;
      }

      .artikel-posts-slider .swiper-button-next,
      .artikel-posts-slider .swiper-button-prev {
        width: 35px;
        height: 35px;
      }

      .artikel-posts-slider .swiper-button-next:after,
      .artikel-posts-slider .swiper-button-prev:after {
        font-size: 16px;
      }
    }
  </style>
</head>

<body class="index-page">

  @include('partials.header')

  <main class="main">

    <!-- Hero Section -->
    <section id="hero" class="hero section">
      
      <div class="container">
        <div class="row gy-4">
          <div class="col-lg-6 order-2 order-lg-1 d-flex flex-column justify-content-center">
            <h1 data-aos="fade-up">{{ $hc?->title }}</h1>
            <p data-aos="fade-up" data-aos-delay="100">{{ $hc?->subtitle }}</p>
            <div class="d-flex flex-column flex-md-row" data-aos="fade-up" data-aos-delay="200">
              <a href="#about" class="btn-get-started">Selengkapnya <i class="bi bi-arrow-right"></i></a>
              <a href="{{ $hc?->yt_link }}" class="glightbox btn-watch-video d-flex align-items-center justify-content-center ms-0 ms-md-4 mt-4 mt-md-0"><i class="bi bi-play-circle"></i><span>Tonton Video</span></a>
            </div>
          </div>
          <div class="col-lg-6 order-1 order-lg-2 hero-img" data-aos="zoom-out">
            <img src="{{ $hc?->image_hero }}" class="img-fluid animated" alt="">
          </div>
        </div>
      </div>

    </section><!-- /Hero Section -->
    
    <!-- Purple Banner Slider Section -->
    <section id="purple-banner" class="purple-banner section">
      <div class="banner-bg">
        <div class="banner-overlay"></div>
        <div class="container">
          <div class="custom-slider swiper" id="purpleBannerSlider">
            
            <x-carousel-banners :carousels="$carousels"/>
            
            <div class="swiper-pagination"></div>
            <div class="swiper-button-prev"></div>
            <div class="swiper-button-next"></div>
          </div>
        </div>
      </div>
    </section>
 
    <!-- Services Section -->
    <section id="services" class="services section">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2>Layanan</h2>
        <p>Layanan Utama<br></p>
      </div><!-- End Section Title -->

      <div class="container">

        <x-layanan-utama-list :services="$services"/>

      </div>

    </section><!-- /Services Section -->
  
    <!-- Features Section -->
    <section id="features" class="features section">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2>visi & misi</h2>
        <p>Visi</p>
      </div><!-- End Section Title -->

      <div class="container">

        <div class="content">
          <p>{{ $hc?->visi }}</p>
        </div>
        <div class="row gy-5">

          <div class="col-xl-5" data-aos="zoom-out" data-aos-delay="100">
            <img src="{{ $hc?->vm_banner }}" class="img-fluid" alt="">
          </div>

          <div class="col-xl-7 d-flex">
            <div class="row align-self-center gy-4 mt-2">
              <div class="container section-title">
                <p class="m-0">Misi</p>
              </div>
              @foreach (explode("|", $hc?->misi) as $idx => $item)
                <div class="col-md-6" data-aos="fade-up" data-aos-delay="{{ $idx+1 * 100 }}">
                  <div class="feature-box d-flex align-items-center">
                    <i class="bi bi-check"></i>
                    <span>{{ $item }}</span>
                  </div>
                </div><!-- End Feature Item -->
              @endforeach

            </div>
          </div>

        </div>

      </div>

    </section><!-- /Features Section -->

    <!-- Stats Section -->
    <section id="stats" class="stats section">

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="row gy-4">

          <div class="col-lg-4 col-md-6">
            <div class="stats-item d-flex align-items-center w-100 h-100 position-relative">
              
              <p class="badge bg-primary position-absolute top-0 end-0 m-2 p-1">{{ $hc->p_year ?? date('y') }}</p>

              <i class="bi bi-graph-up color-blue flex-shrink-0"></i>
              <div>
                <span data-purecounter-start="0" data-purecounter-end="{{ $hc->p_hewan ?? 0 }}" data-purecounter-duration="1" class="purecounter"></span>
                <p>Pengujian Penyakit Hewan</p>
              </div>
            </div>
          </div>

          <div class="col-lg-4 col-md-6">
            <div class="stats-item d-flex align-items-center w-100 h-100 position-relative">
              
              <p class="badge bg-primary position-absolute top-0 end-0 m-2 p-1">{{ $hc->p_year ?? date('y') }}</p>

              <i class="bi bi-graph-up color-orange flex-shrink-0" style="color: #ee6c20;"></i>
              <div>
                <span data-purecounter-start="0" data-purecounter-end="{{ $hc->p_produk ?? 0}}" data-purecounter-duration="1" class="purecounter"></span>
                <p>Pengujian Produk Hewan</p>
              </div>
            </div>
          </div>

          <div class="col-lg-4 col-md-6">
            <div class="stats-item d-flex align-items-center w-100 h-100 position-relative">
              
              <p class="badge bg-primary position-absolute top-0 end-0 m-2 p-1">{{ $hc->p_year ?? date('y') }}</p>

              <i class="bi bi-graph-up color-green flex-shrink-0" style="color: #15be56;"></i>
              <div>
                <span data-purecounter-start="0" data-purecounter-end="{{ $hc->p_kesmavet }}" data-purecounter-duration="1" class="purecounter"></span>
                <p>Pengujian Kesmavet</p>
              </div>
            </div>
          </div><!-- End Stats Item -->

        </div>

      </div>

    </section><!-- /Stats Section -->

    
    <!-- Portfolio Section -->
    <section id="portfolio" class="portfolio section">
      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2 class="mb-2">Publikasi</h2>
        <p></p>
      </div><!-- End Section Title -->

      <div class="container">

        <div class="swiper gallery-slider" id="gallerySlider">
          <script type="application/json" class="swiper-config">
            {
              "loop": true,
              "speed": 600,
              "autoplay": {
                "delay": 4000,
                "disableOnInteraction": false
              },
              "slidesPerView": 1,
              "spaceBetween": 20,
              "pagination": {
                "el": ".swiper-pagination",
                "type": "bullets",
                "clickable": true
              },
              "navigation": {
                "nextEl": ".swiper-button-next",
                "prevEl": ".swiper-button-prev"
              },
              "breakpoints": {
                "640": {
                  "slidesPerView": 2,
                  "spaceBetween": 15
                },
                "1024": {
                  "slidesPerView": 3,
                  "spaceBetween": 20
                }
              }
            }
          </script>

          <div class="swiper-wrapper">
            @foreach ($galleries as $item)
              <div class="swiper-slide">
                <div class="portfolio-item">
                  <div class="portfolio-content h-100">
                    <img src="{{ $item->banner }}" class="img-fluid" alt="{{ $item->title }}">
                    <div class="portfolio-info">
                      <h4>{{ $item->title }}</h4>
                      <p>{!! Str::limit(strip_tags($item->content), 100) !!}</p>
                      <a href="{{ $item->banner }}" title="{{ $item->title }}" data-gallery="portfolio-gallery-product" class="glightbox preview-link"><i class="bi bi-zoom-in"></i></a>
                      <a href="{{ route('galeri.detail', ['page' => $item->slug]) }}" title="More Details" class="details-link"><i class="bi bi-link-45deg"></i></a>
                    </div>
                  </div>
                </div>
              </div><!-- End Portfolio Item -->
            @endforeach
          </div>

          <!-- Pagination -->
          <div class="swiper-pagination"></div>

          <!-- Navigation buttons -->
          <div class="swiper-button-prev"></div>
          <div class="swiper-button-next"></div>

        </div><!-- End Gallery Slider -->

      </div>

    </section><!-- /Portfolio Section -->

    <!-- Recent Posts Section -->
    <section id="recent-posts" class="artikel-recent-posts section">
      <div class="artikel-container artikel-section-title">
        <h2>Artikel</h2>
        <p>Baca artikel terbaru</p>
      </div>

      <div class="artikel-container">
        <div class="swiper artikel-posts-slider" id="artikelPostsSlider">
          <div class="swiper-wrapper">
            @if($blogs && $blogs->count() > 0)
              @foreach ($blogs as $blog)
                <div class="swiper-slide">
                  <div class="artikel-card">
                    <div class="artikel-banner-wrapper">
                      <img src="{{ $blog->banner }}" 
                          class="artikel-banner" 
                          alt="{{ $blog->title }}">
                      <span class="artikel-date">{{ $blog->created_at->format('d-m-Y') }}</span>
                    </div>
                    <div class="artikel-content">
                      <h3 class="artikel-title">{{ $blog->title }}</h3>
                      <p class="artikel-description">{{ $blog->description ?? 'Deskripsi singkat artikel' }}</p>
                      <div class="artikel-meta">
                        <i class="bi bi-person"></i>
                        <span>{{ $blog->penulis->name ?? 'Admin' }}</span>
                      </div>
                      <a href="{{ url('/artikel') }}?page={{ $blog->slug }}" class="artikel-readmore">
                        <span>Selengkapnya</span>
                        <i class="bi bi-arrow-right"></i>
                      </a>
                    </div>
                  </div>
                </div>
              @endforeach
            @else
              <div class="swiper-slide">
                <div class="artikel-card">
                  <div class="artikel-content">
                    <p class="text-center">Belum ada artikel tersedia</p>
                  </div>
                </div>
              </div>
            @endif
          </div>

          <div class="swiper-pagination"></div>
          <div class="swiper-button-prev"></div>
          <div class="swiper-button-next"></div>
        </div>
      </div>
    </section>

    <!-- Testimonials Section -->
    <section id="testimonials" class="testimonials section">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2>Testimoni</h2>
        <p>Ucap pelanggan<br></p>
      </div><!-- End Section Title -->

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="swiper init-swiper">
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
              },
              "breakpoints": {
                "320": {
                  "slidesPerView": 1,
                  "spaceBetween": 40
                },
                "1200": {
                  "slidesPerView": 3,
                  "spaceBetween": 1
                }
              }
            }
          </script>
          <div class="swiper-wrapper">

            @foreach ($testi_list as $item)
              <div class="swiper-slide">
                <div class="testimonial-item">
                  <div class="stars">
                    <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                  </div>
                  {!! $item->review !!}
                  <div class="profile mt-auto">
                    <img src="{{ $item->profil ?? asset('admin/images/users/default-img.jpg') }}" class="testimonial-img" alt="">
                    <h3>{{ $item->nama }}</h3>
                    <h4>{{ $item->institusi }}</h4>
                  </div>
                </div>
              </div><!-- End testimonial item -->
            @endforeach

          </div>
          <div class="swiper-pagination"></div>
        </div>

      </div>

    </section><!-- /Testimonials Section -->

    <!-- Clients Section -->
    <section id="clients" class="clients section">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2>Partner</h2>
        <p><br></p>
      </div><!-- End Section Title -->

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="swiper init-swiper">
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
              },
              "breakpoints": {
                "320": {
                  "slidesPerView": 2,
                  "spaceBetween": 40
                },
                "480": {
                  "slidesPerView": 3,
                  "spaceBetween": 60
                },
                "640": {
                  "slidesPerView": 4,
                  "spaceBetween": 80
                },
                "992": {
                  "slidesPerView": 6,
                  "spaceBetween": 120
                }
              }
            }
          </script>
          <div class="swiper-wrapper align-items-center">
            <div class="swiper-slide"><img src="assets/img/clients/client-1.png" class="img-fluid" alt=""></div>
            <div class="swiper-slide"><img src="assets/img/clients/client-2.png" class="img-fluid" alt=""></div>
            <div class="swiper-slide"><img src="assets/img/clients/client-3.png" class="img-fluid" alt=""></div>
            <div class="swiper-slide"><img src="assets/img/clients/client-4.png" class="img-fluid" alt=""></div>
            <div class="swiper-slide"><img src="assets/img/clients/client-5.png" class="img-fluid" alt=""></div>
            <div class="swiper-slide"><img src="assets/img/clients/client-6.png" class="img-fluid" alt=""></div>
            <div class="swiper-slide"><img src="assets/img/clients/client-7.png" class="img-fluid" alt=""></div>
            <div class="swiper-slide"><img src="assets/img/clients/client-8.png" class="img-fluid" alt=""></div>
          </div>
          <div class="swiper-pagination"></div>
        </div>

      </div>

    </section><!-- /Clients Section -->

    <!-- Faq Section -->
    <section id="faq" class="faq section">

      <!-- Section Title -->
      <div class="container section-title" data-aos ="fade-up">
        <h2>F.A.Q</h2>
        <p>Frequently Asked Questions</p>
      </div><!-- End Section Title -->

      <div class="container">

        <div class="row">

          <div class="col-lg-6" data-aos="fade-up" data-aos-delay="100">

            <div class="faq-container">

              <div class="faq-item faq-active">
                <h3>Non consectetur a erat nam at lectus urna duis?</h3>
                <div class="faq-content">
                  <p>Feugiat pretium nibh ipsum consequat. Tempus iaculis urna id volutpat lacus laoreet non curabitur gravida. Venenatis lectus magna fringilla urna porttitor rhoncus dolor purus non.</p>
                </div>
                <i class="faq-toggle bi bi-chevron-right"></i>
              </div><!-- End Faq item-->

              <div class="faq-item">
                <h3>Feugiat scelerisque varius morbi enim nunc faucibus a pellentesque?</h3>
                <div class="faq-content">
                  <p>Dolor sit amet consectetur adipiscing elit pellentesque habitant morbi. Id interdum velit laoreet id donec ultrices. Fringilla phasellus faucibus scelerisque eleifend donec pretium. Est pellentesque elit ullamcorper dignissim. Mauris ultrices eros in cursus turpis massa tincidunt dui.</p>
                </div>
                <i class="faq-toggle bi bi-chevron-right"></i>
              </div><!-- End Faq item-->

              <div class="faq-item">
                <h3>Dolor sit amet consectetur adipiscing elit pellentesque?</h3>
                <div class="faq-content">
                  <p>Eleifend mi in nulla posuere sollicitudin aliquam ultrices sagittis orci. Faucibus pulvinar elementum integer enim. Sem nulla pharetra diam sit amet nisl suscipit. Rutrum tellus pellentesque eu tincidunt. Lectus urna duis convallis convallis tellus. Urna molestie at elementum eu facilisis sed odio morbi quis</p>
                </div>
                <i class="faq-toggle bi bi-chevron-right"></i>
              </div><!-- End Faq item-->

            </div>

          </div><!-- End Faq Column-->

          <div class="col-lg-6" data-aos="fade-up" data-aos-delay="200">

            <div class="faq-container">

              <div class="faq-item">
                <h3>Ac odio tempor orci dapibus. Aliquam eleifend mi in nulla?</h3>
                <div class="faq-content">
                  <p>Dolor sit amet consectetur adipiscing elit pellentesque habitant morbi. Id interdum velit laoreet id donec ultrices. Fringilla phasellus faucibus scelerisque eleifend donec pretium. Est pellentesque elit ullamcorper dignissim. Mauris ultrices eros in cursus turpis massa tincidunt dui.</p>
                </div>
                <i class="faq-toggle bi bi-chevron-right"></i>
              </div><!-- End Faq item-->

              <div class="faq-item">
                <h3>Tempus quam pellentesque nec nam aliquam sem et tortor consequat?</h3>
                <div class="faq-content">
                  <p>Molestie a iaculis at erat pellentesque adipiscing commodo. Dignissim suspendisse in est ante in. Nunc vel risus commodo viverra maecenas accumsan. Sit amet nisl suscipit adipiscing bibendum est. Purus gravida quis blandit turpis cursus in</p>
                </div>
                <i class="faq-toggle bi bi-chevron-right"></i>
              </div><!-- End Faq item-->

              <div class="faq-item">
                <h3>Perspiciatis quod quo quos nulla quo illum ullam?</h3>
                <div class="faq-content">
                  <p>Enim ea facilis quaerat voluptas quidem et dolorem. Quis et consequatur non sed in suscipit sequi. Distinctio ipsam dolore et.</p>
                </div>
                <i class="faq-toggle bi bi-chevron-right"></i>
              </div><!-- End Faq item-->

            </div>

          </div><!-- End Faq Column-->

        </div>

      </div>

    </section><!-- /Faq Section -->

    <!-- Contact Section -->
    <section id="contact" class="contact section">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2>kontak</h2>
        <p>Kontak kami</p>
      </div><!-- End Section Title -->

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="row gy-4">

          <div class="col-lg-6">

            <div class="row gy-4">
              <div class="col-md-6">
                <div class="info-item" data-aos="fade" data-aos-delay="200">
                  <i class="bi bi-geo-alt"></i>
                  <h3>Alamat</h3>
                  <p>Jl. Tangkuban Parahu</p>
                  <p>Cikole, Bandung Barat</p>
                </div>
              </div><!-- End Info Item -->

              <div class="col-md-6">
                <div class="info-item" data-aos="fade" data-aos-delay="300">
                  <i class="bi bi-telephone"></i>
                  <h3>Telpon</h3>
                  <p>+1 5589 55488 55</p>
                  <p>+1 6678 254445 41</p>
                </div>
              </div><!-- End Info Item -->

              <div class="col-md-6">
                <div class="info-item" data-aos="fade" data-aos-delay="400">
                  <i class="bi bi-envelope"></i>
                  <h3>Email</h3>
                  <p>info@example.com</p>
                  <p>contact@example.com</p>
                </div>
              </div><!-- End Info Item -->

              <div class="col-md-6">
                <div class="info-item" data-aos="fade" data-aos-delay="500">
                  <i class="bi bi-clock"></i>
                  <h3>Jam Pelayanan</h3>
                  <p>Monday - Friday</p>
                  <p>9:00AM - 05:00PM</p>
                </div>
              </div><!-- End Info Item -->

            </div>

          </div>

          <div class="col-lg-6">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d126757.2319022395!2d107.55669202021456!3d-6.8710040725830694!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e68e0151b39c079%3A0x9f5ab4972d82e5b2!2sRumah%20Sakit%20Hewan%20Jawa%20Barat!5e0!3m2!1sid!2sid!4v1757980581739!5m2!1sid!2sid" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
          </div><!-- End Contact Form -->

        </div>

      </div>

    </section><!-- /Contact Section -->

  </main>

  <x-footer/>

  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  @include('partials.scripts')
  <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
  <script>
    // Initialize Swiper
    const swiper = new Swiper('#purpleBannerSlider', {
      loop: true,
      speed: 600,
      autoplay: {
        delay: 4000,
        disableOnInteraction: false,
      },
      slidesPerView: 1,
      spaceBetween: 20,
      centeredSlides: true,
      pagination: {
        el: '.swiper-pagination',
        type: 'bullets',
        clickable: true,
      },
      navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
      },
      breakpoints: {
        768: {
          slidesPerView: 1,
          spaceBetween: 30,
        },
        1024: {
          slidesPerView: 1,
          spaceBetween: 40,
        }
      }
    });
  </script>
  <script>
    // Initialize Swiper untuk Artikel
    const artikelSwiper = new Swiper('#artikelPostsSlider', {
      loop: true,
      speed: 600,
      // autoplay: {
      //   delay: 5000,
      //   disableOnInteraction: false,
      // },
      slidesPerView: 1,
      spaceBetween: 30,
      pagination: {
        el: '.artikel-posts-slider .swiper-pagination',
        type: 'bullets',
        clickable: true,
      },
      navigation: {
        nextEl: '.artikel-posts-slider .swiper-button-next',
        prevEl: '.artikel-posts-slider .swiper-button-prev',
      },
      breakpoints: {
        640: {
          slidesPerView: 2,
          spaceBetween: 15,
          slidesPerGroup: 2,
        },
        768: {
          slidesPerView: 3,
          slidesPerGroup: 3,  // Slide 3 items at once
        },
        1024: {
          slidesPerView: 4,
          slidesPerGroup: 4,  // Slide 4 items at once
        },
        1280: {
          slidesPerView: 4,
          slidesPerGroup: 4,  // XL screens
        }
      }
    });
  </script>

</body>

</html>