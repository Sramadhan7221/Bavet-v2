<nav id="navmenu" class="navmenu">
    <ul>
        {{-- @dd($active) --}}
        <li><a href="{{ url('/') }}" class="{{ $active == 'home' ? 'active' : '' }}">Beranda<br></a></li>
        <li>
            <a href="{{ url('/artikel') }}?page=about" class="{{ $active == 'about' ? 'active' : '' }}">Tentang</a>
        </li>
        {{-- <li><a href="#services">Layanan</a></li> --}}
        <li><a href="#portfolio">Aktivitas</a></li>
        <li><a href="#team">Team</a></li>
        {{-- <li><a href="blog.html">Informasi</a></li> --}}
        {{-- <li class="dropdown"><a href="#"><span>Regulasi</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
        <ul>
            <li><a href="#">Dropdown 1</a></li>
            <li class="dropdown"><a href="#"><span>Deep Dropdown</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
            <ul>
                <li><a href="#">Deep Dropdown 1</a></li>
                <li><a href="#">Deep Dropdown 2</a></li>
                <li><a href="#">Deep Dropdown 3</a></li>
                <li><a href="#">Deep Dropdown 4</a></li>
                <li><a href="#">Deep Dropdown 5</a></li>
            </ul>
            </li>
            <li><a href="#">Dropdown 2</a></li>
            <li><a href="#">Dropdown 3</a></li>
            <li><a href="#">Dropdown 4</a></li>
        </ul>
        </li> --}}
        {{-- <li class="listing-dropdown"><a href="#"><span>Listing Dropdown</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
        <ul>
            <li>
            <a href="#">Column 1 link 1</a>
            <a href="#">Column 1 link 2</a>
            <a href="#">Column 1 link 3</a>
            </li>
            <li>
            <a href="#">Column 2 link 1</a>
            <a href="#">Column 2 link 2</a>
            <a href="#">Column 3 link 3</a>
            </li>
            <li>
            <a href="#">Column 3 link 1</a>
            <a href="#">Column 3 link 2</a>
            <a href="#">Column 3 link 3</a>
            </li>
            <li>
            <a href="#">Column 4 link 1</a>
            <a href="#">Column 4 link 2</a>
            <a href="#">Column 4 link 3</a>
            </li>
            <li>
            <a href="#">Column 5 link 1</a>
            <a href="#">Column 5 link 2</a>
            <a href="#">Column 5 link 3</a>
            </li>
        </ul>
        </li> --}}
        <li><a href="#contact">Kontak</a></li>
    </ul>
    <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
</nav>