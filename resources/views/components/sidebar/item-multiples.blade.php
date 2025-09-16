<li class="side-nav-item">
    <a data-bs-toggle="collapse" href="#sidebarPages{{ $slug }}" aria-expanded="false" aria-controls="sidebarPages{{ $slug }}" class="side-nav-link">
        <i class="ri-stack-line"></i>
        <span> {{ $title }} </span>
        <span class="menu-arrow"></span>
        
    </a>
    <div class="collapse" id="sidebarPages{{ $slug }}">
        <ul class="side-nav-second-level">
            @foreach ($items as $subMenu)
                <x-sidebar.item 
                    :title="$subMenu->title" 
                    :type="$subMenu->type"
                    :url="$subMenu->slug" 
                />
            @endforeach
        </ul>
    </div>
</li>