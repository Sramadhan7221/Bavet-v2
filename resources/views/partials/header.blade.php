<header id="header" class="header d-flex align-items-center fixed-top">
    <div class="container-fluid container-xl position-relative d-flex align-items-center">

      <a href="{{ url('/') }}" class="logo d-flex align-items-center me-auto">
        <!-- Uncomment the line below if you also wish to use an image logo -->
        <img src="{{ asset('assets/img/logo.png') }}" alt="">
      </a>

      <nav id="navmenu" class="navmenu">
        <ul>
          <li><a href="{{ url('/') }}" class="active">Beranda<br></a></li>
          <li class="dropdown"><a href="#about"><span>Profil</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
            <ul>
              <li><a href="#">Sejarah Singkat</a></li>
              <li><a href="#">Tugas dan Fungsi</a></li>
              <li><a href="#">Struktur Organisasi</a></li>
              <li><a href="#">Akreditasi dan Sertifikasi</a></li>
            </ul>
          </li>
          <li class="dropdown"><a href="#"><span>Layanan</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
            <ul>
              <li><a href="#">Tarif Pengujian Penyakit Hewan</a></li>
              <li><a href="#">Tarif Pengujian Produk Hewan</a></li>
            </ul>
          </li>
          <li class="dropdown"><a href="#contact"><span>Kontak</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
            <ul>
              <li><a href="#contact" data-location-id="1">Kantor Administrasi</a></li>
              <li class="dropdown"><a href="#contact"><span>Satuan Pelayanan Lab</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
                <ul>
                  <li><a href="#contact" data-location-id="2">Laboratorium Cikole</a></li>
                  <li><a href="#contact" data-location-id="3">Laboratorium Losari</a></li>
                </ul>
              </li>
              <li class="dropdown"><a href="#contact" data-location-id=""><span>Satuan Pelayanan</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
                <ul>
                  <li><a href="#contact" data-location-id="4">Satpel Losari</a></li>
                  <li><a href="#contact" data-location-id="5">Satpel Banjar</a></li>
                  <li><a href="#contact" data-location-id="6">Satpel Gunung Sindur</a></li>
                </ul>
              </li>
            </ul>
          </li>
          <li><a href="#portfolio">Artikel</a></li>
          <li><a href="#clients">Mitra Kami</a></li>
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>

    </div>
</header>