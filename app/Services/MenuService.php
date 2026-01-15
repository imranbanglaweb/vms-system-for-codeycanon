<?php

namespace App\Services;

use App\Models\Menu;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class MenuService
{
    /**
     * Get sidebar menus cached per role
     */
    public static function sidebar()
    {
        $user = Auth::user();

        // If no user is authenticated, return empty collection
        if (!$user) {
            return collect();
        }

        // Check if user is Super Admin
        $isSuperAdmin = $user->hasRole('Super Admin');

        // Load all parent menus
        $menus = Menu::where('menu_parent', 0)
            ->orderBy('menu_order')
            ->get();
        
        $filtered = $menus->map(function ($menu) use ($user, $isSuperAdmin) {

            // Load children
            $children = Menu::where('menu_parent', $menu->id)
                ->orderBy('menu_order')
                ->get()
                ->filter(function ($child) use ($user, $isSuperAdmin) {
                    // Super Admin sees everything, others need permission
                    if ($isSuperAdmin) {
                        return true;
                    }
                    return !$child->menu_permission || $user->can($child->menu_permission);
                })
                ->values();

            // Check parent permission - show if:
            // 1. Super Admin, OR
            // 2. Has visible children, OR
            // 3. No permission required, OR  
            // 4. User has permission
            if ($isSuperAdmin) {
                $menu->visible = true;
            } else {
                $hasPermission = !$menu->menu_permission || $user->can($menu->menu_permission);
                $menu->visible = $children->isNotEmpty() || $hasPermission;
            }

            $menu->children = $children;

            return $menu;
        })
        ->filter(fn ($menu) => $menu->visible)
        ->values();

        return $filtered;
    }

    /**
     * Clear menu cache (call after role/menu change)
     */
    public static function clear()
    {
        Cache::flush();
    }
}
