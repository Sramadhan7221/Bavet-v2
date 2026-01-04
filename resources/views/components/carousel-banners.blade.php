<div class="swiper-wrapper">
    @foreach ($bannerList as $banner)
        <div class="swiper-slide slider-item">
            <div class="slider-img">
                <img src="{{ $banner->img_path }}" class="img-fluid">
            </div>
        </div>
    @endforeach
</div>