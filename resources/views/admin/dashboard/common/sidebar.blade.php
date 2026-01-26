<style>
.sidebar-left .nav-main li.nav-active > a {
    background-color: #2c3e50;
    color: #fff;
}
.sidebar-left .nav-main .nav-children li.nav-active > a {
    background-color: #34495e;
    color: #fff;
}
</style>

<aside id="sidebar-left" class="sidebar-left">
    <div class="sidebar-header">
        <div class="sidebar-title">
            <a href="{{ route('home') }}" style="color:#fff">
                {{ $settings->admin_title ?? 'TMS System' }}
            </a>
        </div>

        <div class="sidebar-toggle hidden-xs"
            data-toggle-class="sidebar-left-collapsed"
            data-target="html"
            data-fire-event="sidebar-left-toggle">
            <i class="fa fa-bars"></i>
        </div>
    </div>

    <div class="nano">
        <div class="nano-content">
            <nav class="nav-main">
                <ul class="nav nav-main">

@forelse($sidebar_menus as $menu)

    @php
        $children = $menu->children ?? collect();

        // Get base route (users.index → users)
        $menuBase = $menu->menu_url ? explode('.', $menu->menu_url)[0] : null;

        // Check if any child route is active
        $isActiveParent = false;
        foreach ($children as $child) {
            if ($child->menu_url) {
                $childBase = explode('.', $child->menu_url)[0];
                if (request()->routeIs($childBase . '.*')) {
                    $isActiveParent = true;
                    break;
                }
            }
        }
    @endphp

    {{-- SINGLE MENU --}}
    @if($children->isEmpty())
        <li class="{{ $menuBase && request()->routeIs($menuBase . '.*') ? 'nav-active' : '' }}">
            <a href="{{ $menu->menu_url && Route::has($menu->menu_url) ? route($menu->menu_url) : '#' }}">
                <i class="fa {{ $menu->menu_icon }}"></i>
                <span>{{ trans(ensure_menu_translation($menu->menu_name)) }}</span>
            </a>
        </li>

    {{-- PARENT MENU --}}
    @else
        <li class="nav-parent {{ $isActiveParent ? 'nav-expanded nav-active' : '' }}">
            <a href="#">
                <i class="fa {{ $menu->menu_icon }}"></i>
                <span>{{ trans(ensure_menu_translation($menu->menu_name)) }}</span>
            </a>

            <ul class="nav nav-children">
                @foreach($children as $child)
                    @php
                        $childBase = $child->menu_url ? explode('.', $child->menu_url)[0] : null;
                    @endphp

                    <li class="{{ $childBase && request()->routeIs($childBase . '.*') ? 'nav-active' : '' }}">
                        <a href="{{ $child->menu_url && Route::has($child->menu_url) ? route($child->menu_url) : '#' }}">
                            <i class="fa {{ $child->menu_icon }}"></i>
                            {{ trans(ensure_menu_translation($child->menu_name)) }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </li>
    @endif

@empty
    <li><a href="#">{{ trans('No menus available') }}</a></li>
@endforelse

                </ul>
            </nav>
        </div>
    </div>
</aside>
