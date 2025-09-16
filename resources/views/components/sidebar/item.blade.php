<li class="side-nav-item">
    <a href="{{ route('cms.manage', ['slug' => $url]) }}" class="side-nav-link">
        @if ($type == 'static')
            <i class="ri-article-line"></i>
        @else
            <i class="ri-artboard-line"></i>
        @endif
        <span> {{ $title }}</span>
    </a>
</li>