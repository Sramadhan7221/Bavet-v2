<!DOCTYPE html>
<html lang="en">

<head>
  @include('partials.head')
  @stack('styles')
</head>

<body class="blog-details-page">

  @include('partials.header-blog',['active' => "about"])

  <main class="main">

    <!-- Page Title -->
    <div class="page-title">
      <nav class="breadcrumbs my-2">
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

    <div class="container">
      <div class="row">

        <div class="col-lg-8">

          <!-- Blog Details Section -->
          <section id="blog-details" class="blog-details section">
            <div class="container">
              <article class="article">

                <div class="post-img">
                  <img src="{{ $img_hero }}" alt="" class="img-fluid">
                </div>

                <h2 class="title">{{ $post->title ?? "" }}</h2>

                <div class="meta-top">
                  <ul>
                    <li class="d-flex align-items-center"><i class="bi bi-person"></i>{{ $penulis?->name }}</li>
                    <li class="d-flex align-items-center"><i class="bi bi-clock"></i>{{ $tgl }}</li>
                  </ul>
                </div><!-- End meta top -->

                <div class="content">
                  @foreach ($post->content as $item)
                    {!! $item !!}
                  @endforeach
                </div><!-- End post content -->

                <div class="meta-bottom">
                  <i class="bi bi-tags"></i>
                  <ul class="tags">
                    @foreach ($tags as $item)
                      <li><a href="{{ url('/artikel')."?tag=".$item->tag_name}}">{{ $item->tag_name }}</a></li>
                    @endforeach
                  </ul>
                </div><!-- End meta bottom -->

              </article>

            </div>
          </section><!-- /Blog Details Section -->

          <!-- Blog Author Section -->
          <section id="blog-author" class="blog-author section">

            <div class="container">
              <div class="author-container d-flex align-items-center">
                <img src="{{ $penulis?->picture ?? asset('admin/images/users/default-img.jpg') }}" class="rounded-circle flex-shrink-0" alt="">
                <div>
                  <h4>{{ $penulis?->name }}</h4>
                  <div class="social-links">
                    @if ($penulis?->tiktok)
                      <a href="{{ $penulis?->tiktok }}"><i class="bi bi-tiktok"></i></a>
                    @endif
                    @if ($penulis?->facebook)
                      <a href="{{ $penulis?->facebook }}"><i class="bi bi-facebook"></i></a>
                    @endif
                    @if ($penulis?->instagram)
                      <a href="{{ $penulis?->instagram }}"><i class="biu bi-instagram"></i></a>
                    @endif
                  </div>
                  <p>
                    {{ $penulis?->bio ?? '-- Tidak ada bio --' }}
                  </p>
                </div>
              </div>
            </div>

          </section><!-- /Blog Author Section -->

        </div>

        <div class="col-lg-4 sidebar">

          <div class="widgets-container">

            <!-- Search Widget -->
            <div class="search-widget widget-item">

              <h3 class="widget-title">Cari</h3>
              <form action="">
                <input type="text" id="terms" placeholder="Cari..">
                <button type="button" title="Search" class="cari"><i class="bi bi-search"></i></button>
              </form>

            </div>
            <!--/Search Widget -->

            <!-- Recent Posts Widget -->
            <div class="recent-posts-widget widget-item">

              <h3 class="widget-title">Artikel Terbaru</h3>

              @foreach ($latest_post as $post)  
                <div class="post-item">
                  <img src="{{ $post->banner }}" alt="" class="flex-shrink-0">
                  <div>
                    <h4><a href="{{ url('/artikel')."?page=".$post->slug }}">{{ $post->title }}</a></h4>
                    <time>{{ $post->created_at->translatedFormat('d F Y') }}</time>
                  </div>
                </div><!-- End recent post item-->
              @endforeach
            </div>
            <!--/Recent Posts Widget -->

            <!-- Tags Widget -->
            <div class="tags-widget widget-item">

              <h3 class="widget-title">Penanda</h3>
              <ul>
                @foreach ($tags as $item)
                  <li><a href="{{ url('/artikel')."?tag=".$item->tag_name}}">{{ $item->tag_name }}</a></li>
                @endforeach
              </ul>

            </div>
            <!--/Tags Widget -->

          </div>

        </div>

      </div>
    </div>

  </main>

  <x-footer/>

  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  @include('partials.scripts')
  <script>
    document.querySelector(".cari").addEventListener("click", function() {
      window.location.href = "{{ route('artikel.cari') }}" + "?query=" + document.getElementById("terms").value;
    });
  </script>

</body>

</html>