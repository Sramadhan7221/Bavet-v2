<div class="row gy-4">

    @foreach ($services as $index => $layanan)    
        <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="{{ $index+1 * 100 }}">
            <div class="service-item item-indigo position-relative">
                {!! $layanan->icon !!}
                <h3 class="pt-3">{{ $layanan->title }}</h3>
                <p>{{ $layanan->desc }}</p>
                <a href="#" class="read-more stretched-link"><span>Read More</span> <i class="bi bi-arrow-right"></i></a>
            </div>
        </div><!-- End Service Item -->
    @endforeach

</div>