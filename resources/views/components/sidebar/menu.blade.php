<div data-simplebar>
        <ul class="side-nav">
            <li class="side-nav-title">CMS</li>

            <li class="side-nav-item">
                <a href="{{ route('dashboard') }}" class="side-nav-link">
                    <i class="ri-dashboard-2-line"></i>
                    <span> Dashboard </span>
                    {{-- <span class="badge bg-success float-end">9+</span> --}}
                </a>
            </li>
    
            <li class="side-nav-item">
                <a href="{{ route('menus.tree') }}" class="side-nav-link">
                    <i class="ri-compass-3-line"></i>
                    <span> Manajemen Menu</span>

                </a>
            </li>

            <li class="side-nav-title">Menu</li>
    
            @foreach ($menus as $menu)
                @if (is_null($menu->module) && $menu->type == 'module' && count($menu->children) > 0)
                    <x-sidebar.item-multiples 
                        :title="$menu->title" 
                        :slug="$menu->slug" 
                        :items="$menu->children" 
                    />
                @else
                    <x-sidebar.item 
                        :title="$menu->title" 
                        :type="$menu->type"
                        :url="$menu->slug" 
                    />
                @endif
                
            @endforeach
        </ul>
    </div>