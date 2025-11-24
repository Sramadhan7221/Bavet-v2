<!DOCTYPE html>
<html lang="en">

<head>
  @include('partials.head')
  @stack('styles')
</head>

<body class="blog-details-page">

  @include('partials.header-blog',['active' => "blog"])

  <main class="main">

    <!-- Page Title -->
    <div class="page-title">
      <div class="heading">
        <div class="container">
          <div class="row d-flex justify-content-center text-center">
            <div class="col-lg-8">
              
            </div>
          </div>
        </div>
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

    <div class="container">
      <div class="row">

        <div class="col-lg-8">

          <!-- Blog Posts Section -->
          <section id="blog-posts" class="blog-posts section">

            <div class="container">

              <div class="row gy-4">

                @forelse ($artikels as $artikel)
                  <div class="col-12">
                    <article>

                      <div class="post-img">
                        <img src="{{ $artikel->banner ?? asset('assets/img/blog/blog-1.jpg') }}" alt="{{ $artikel->title }}" class="img-fluid">
                      </div>

                      <h2 class="title">
                        <a href="{{ route('artikel.detail', ['page' => $artikel->slug]) }}">{{ $artikel->title }}</a>
                      </h2>

                      <div class="meta-top">
                        <ul>
                          <li class="d-flex align-items-center"><i class="bi bi-person"></i> <a href="#">{{ $artikel->penulis?->name ?? 'Unknown' }}</a></li>
                          <li class="d-flex align-items-center"><i class="bi bi-clock"></i> <a href="#"><time datetime="{{ $artikel->created_at }}">{{ $artikel->created_at->translatedFormat('M d, Y') }}</time></a></li>
                          <li class="d-flex align-items-center"><i class="bi bi-chat-dots"></i> <a href="#">{{ $artikel->tags->count() }} Penanda</a></li>
                        </ul>
                      </div>

                      <div class="content">
                        <p>
                          {{ Str::limit(strip_tags($artikel->content), 200) }}
                        </p>

                        <div class="read-more">
                          <a href="{{ route('artikel.detail', ['page' => $artikel->slug]) }}">Read More</a>
                        </div>
                      </div>

                    </article>
                  </div><!-- End post list item -->
                @empty
                  <div class="col-12">
                    <div class="alert alert-info text-center">
                      No articles found.
                    </div>
                  </div>
                @endforelse

              </div><!-- End blog posts list -->

            </div>

          </section><!-- /Blog Posts Section -->

          <!-- Blog Pagination Section -->
          <section id="blog-pagination" class="blog-pagination section">

            <div class="container">
              <div class="d-flex justify-content-center">
                {{ $artikels->links('pagination.custom') }}
              </div>
            </div>

          </section><!-- /Blog Pagination Section -->

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

              <h3 class="widget-title">Recent Posts</h3>

              @foreach ( $artikels->take(5) as $artikel )
                
                <div class="post-item">
                  <img src="{{ $artikel->banner }}" alt="" class="flex-shrink-0">
                  <div>
                    <h4><a href="{{ route('artikel.detail') }}?page={{ $artikel->slug }}">{{ $artikel->title }}</a></h4>
                    <time datetime="{{ $artikel->created_at->format('Y-m-d')}}">{{ $artikel->created_at->format('d-m-Y')}}</time>
                  </div>
                </div><!-- End recent post item-->
              
              @endforeach

            </div><!--/Recent Posts Widget -->

            <!-- Tags Widget -->
            <div class="tags-widget widget-item">

              <h3 class="widget-title">Penanda</h3>
              <ul>
                @php
                  // Collect all unique tags from current page articles
                  $uniqueTags = collect();
                  foreach ($artikels as $artikel) {
                    foreach ($artikel->tags as $tag) {
                      $uniqueTags->push($tag->tag_name);
                    }
                  }
                  $uniqueTags = $uniqueTags->unique()->sort()->values();
                @endphp

                @forelse ($uniqueTags as $tag)
                  <li><a href="{{ route('artikel.cari', ['tag' => $tag]) }}">{{ $tag }}</a></li>
                @empty
                  <li class="text-muted">No tags available</li>
                @endforelse
              </ul>

            </div><!--/Tags Widget -->

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