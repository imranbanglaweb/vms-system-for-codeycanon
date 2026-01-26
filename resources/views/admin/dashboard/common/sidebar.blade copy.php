<style>
.sidebar-left .nav-main li.nav-active > a {
    background-color: #2c3e50;
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

    <!-- @php
        $children = $menu->children ?? collect();
        $isActiveParent = $children->contains(function ($child) {
            return $child->menu_url && Route::has($child->menu_url)
                && Route::currentRouteName() === $child->menu_url;
        });
    @endphp -->

    @php
        $children = $menu->children ?? collect();

        $isActiveParent = $children->contains(function ($child) {
            return $child->menu_url && request()->routeIs($child->menu_url . '*');
        });
    @endphp


    {{-- SINGLE MENU (no children) --}}
    @if($children->isEmpty())
        <!-- <li class="{{ Route::currentRouteName() === $menu->menu_url ? 'nav-active' : '' }}"> -->
        <li class="{{ request()->routeIs($menu->menu_url . '*') ? 'nav-active' : '' }}">
            <a href="{{ $menu->menu_url && Route::has($menu->menu_url) ? route($menu->menu_url) : '#' }}">
                <i class="fa {{ $menu->menu_icon }}"></i>
                <span>{{ trans(ensure_menu_translation($menu->menu_name)) }}</span>
            </a>
        </li>
    @else
        {{-- PARENT MENU (with children) --}}
        <li class="nav-parent {{ $isActiveParent ? 'nav-expanded nav-active' : '' }}">
            <a href="#">
                <i class="fa {{ $menu->menu_icon }}"></i>
                <span>{{ trans(ensure_menu_translation($menu->menu_name)) }}</span>
            </a>
            <ul class="nav nav-children">
                @foreach($children as $child)
                    <!-- <li class="{{ Route::currentRouteName() === $child->menu_url ? 'nav-active' : '' }}"> -->
                <li class="{{ request()->routeIs($child->menu_url . '*') ? 'nav-active' : '' }}">

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
