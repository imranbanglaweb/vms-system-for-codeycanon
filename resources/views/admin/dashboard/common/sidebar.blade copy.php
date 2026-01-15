<style>
    .sidebar-left .nav-main li.nav-active > a {
        background-color: #2c3e50;
        color: #fff;
    }
</style>

@php
    // No need for translationService, using trans() now
@endphp

<aside id="sidebar-left" class="sidebar-left">
    <div class="sidebar-header">
        <div class="sidebar-title">
            <a href="{{ route('home') }}" style="color:#fff">
                {{ $settings->admin_title ?? '' }}
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
            <nav class="nav-main" role="navigation">
                <ul class="nav nav-main">

@foreach($sidebar_menus as $menu)
@if($menu->menu_parent == 0)

@php
    $children = DB::table('menus')
        ->where('menu_parent', $menu->id)
        ->orderBy('id', 'DESC')
        ->get();

    $hasChildren = $children->count() > 0;
@endphp

{{-- ================= SINGLE MENU ================= --}}
@if(!$hasChildren)

@php
    $isActive = $menu->menu_url
        ? Route::currentRouteName() === $menu->menu_url
        : false;
@endphp

<li class="{{ $isActive ? 'nav-active' : '' }}">
    <a href="{{ $menu->menu_url ? route($menu->menu_url) : '#' }}">
        <i class="fa {{ $menu->menu_icon }}"></i>
        <span>{{ trans(ensure_menu_translation($menu->menu_name)) }}</span>
    </a>
</li>

@endif

{{-- ================= PARENT MENU ================= --}}
@if($hasChildren)

@php
    $isParentActive = false;

    foreach ($children as $child) {
        if ($child->menu_url && Route::currentRouteName() === $child->menu_url) {
            $isParentActive = true;
            break;
        }
    }
@endphp

<li class="nav-parent {{ $isParentActive ? 'nav-expanded nav-active' : '' }}">
    <a href="#">
        <i class="fa {{ $menu->menu_icon }}"></i>
        <span>{{ trans(ensure_menu_translation($menu->menu_name)) }}</span>
    </a>

    <ul class="nav nav-children">
        @foreach($children as $child)

        @php
            $isChildActive = Route::currentRouteName() === $child->menu_url;
        @endphp

        <li class="{{ $isChildActive ? 'nav-active' : '' }}">
            <a href="{{ $child->menu_url ? route($child->menu_url) : '#' }}">
                <i class="fa {{ $child->menu_icon }}"></i>
                {{ trans(ensure_menu_translation($child->menu_name)) }}
            </a>
        </li>

        @endforeach
    </ul>
</li>

@endif

@endif
@endforeach

                </ul>
            </nav>

         

        </div>
    </div>
</aside>
