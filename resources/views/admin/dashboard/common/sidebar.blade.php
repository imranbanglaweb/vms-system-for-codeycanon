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
        $currentRoute = request()->route() ? request()->route()->getName() : '';

        // Parent active if any child belongs to same resource group
        $isActiveParent = false;
        foreach ($children as $child) {
            if ($child->menu_url) {
                $base = explode('.', $child->menu_url)[0];
                if (str_starts_with($currentRoute, $base . '.')) {
                    $isActiveParent = true;
                    break;
                }
            }
        }
    @endphp

    {{-- SINGLE MENU --}}
    @if($children->isEmpty())
        @php
            // For FA 6, icons need 'fa-' prefix but NOT 'fa fa-' (double prefix)
            $iconValue = $menu->menu_icon;
            if (str_starts_with($iconValue, 'fa-')) {
                $iconClass = 'fas ' . $iconValue;
            } else {
                $iconClass = 'fas fa-' . $iconValue;
            }
        @endphp
        <li class="{{ $menu->menu_url === $currentRoute ? 'nav-active' : '' }}">
            <a href="{{ $menu->menu_url && Route::has($menu->menu_url) ? route($menu->menu_url) : '#' }}">
                <i class="{{ $iconClass }}"></i>
                <span>{{ trans(ensure_menu_translation($menu->menu_name)) }}</span>
            </a>
        </li>

    {{-- PARENT MENU --}}
    @else
        @php
            $parentIconValue = $menu->menu_icon;
            if (str_starts_with($parentIconValue, 'fa-')) {
                $parentIconClass = 'fas ' . $parentIconValue;
            } else {
                $parentIconClass = 'fas fa-' . $parentIconValue;
            }
        @endphp
        <li class="nav-parent {{ $isActiveParent ? 'nav-expanded nav-active' : '' }}">
            <a href="#">
                <i class="{{ $parentIconClass }}"></i>
                <span>{{ trans(ensure_menu_translation($menu->menu_name)) }}</span>
            </a>

            <ul class="nav nav-children">
                @foreach($children as $child)
                    @php
                        $childIconValue = $child->menu_icon;
                        if (str_starts_with($childIconValue, 'fa-')) {
                            $childIconClass = 'fas ' . $childIconValue;
                        } else {
                            $childIconClass = 'fas fa-' . $childIconValue;
                        }
                    @endphp
                    <li class="{{ $child->menu_url === $currentRoute ? 'nav-active' : '' }}">
                        <a href="{{ $child->menu_url && Route::has($child->menu_url) ? route($child->menu_url) : '#' }}">
                            <i class="{{ $childIconClass }}"></i>
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
