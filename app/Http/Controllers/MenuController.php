<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class MenuController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:system-configure')->except(['index', 'show']);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // For client-side DataTables, we'll load all menus with relationships
        $menus = Menu::with(['parent', 'children', 'creator', 'updater'])
            ->orderBy('menu_order')
            ->get();

        // Prepare data for DataTables
        $menuData = $menus->map(function($menu, $index) {
            return [
                'DT_RowIndex' => $index + 1,
                'menu_name' => $menu->menu_name,
                'menu_type' => $menu->menu_parent == 0 ? 'Parent' : 'Child',
                'menu_icon' => $menu->menu_icon ? '<i class="fa ' . $menu->menu_icon . '"></i>' : '-',
                'menu_url' => $menu->menu_url ?: '-',
                'menu_permission' => $menu->menu_permission ?: '-',
                'parent_name' => $menu->parent ? $menu->parent->menu_name : '-',
                'created_at' => $menu->created_at->format('M d, Y'),
                'action' => view('admin.dashboard.menus.partials.actions', compact('menu'))->render()
            ];
        });

        return view('admin.dashboard.menus.index', compact('menus', 'menuData'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $parentMenus = Menu::where('menu_parent', 0)
            ->orderBy('menu_order')
            ->get();

        return view('admin.dashboard.menus.create', compact('parentMenus'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'menu_name' => 'required|string|max:255',
            'menu_slug' => 'nullable|string|max:255|unique:menus',
            'menu_icon' => 'nullable|string|max:255',
            'menu_url' => 'nullable|string|max:255',
            'menu_permission' => 'nullable|string|max:255',
            'menu_parent' => 'nullable|integer|exists:menus,id',
            'menu_order' => 'nullable|integer|min:0',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Generate slug if not provided
        $slug = $request->menu_slug ?: Str::slug($request->menu_name);

        // Ensure slug is unique
        $originalSlug = $slug;
        $counter = 1;
        while (Menu::where('menu_slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        // Get the next menu order
        $menuOrder = $request->menu_order ?: Menu::where('menu_parent', $request->menu_parent ?: 0)->max('menu_order') + 1;

        Menu::create([
            'menu_name' => $request->menu_name,
            'menu_slug' => $slug,
            'menu_icon' => $request->menu_icon,
            'menu_url' => $request->menu_url,
            'menu_permission' => $request->menu_permission,
            'menu_parent' => $request->menu_parent ?: 0,
            'menu_order' => $menuOrder,
            'created_by' => Auth::id(),
            'updated_by' => Auth::id(),
        ]);

        return redirect()->route('menus.index')
            ->with('success', 'Menu created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Menu $menu)
    {
        $menu->load('parent', 'children');
        return view('admin.dashboard.menus.show', compact('menu'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Menu $menu)
    {
        $parentMenus = Menu::where('menu_parent', 0)
            ->where('id', '!=', $menu->id)
            ->orderBy('menu_order')
            ->get();

        return view('admin.dashboard.menus.edit', compact('menu', 'parentMenus'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Menu $menu)
    {
        $validator = Validator::make($request->all(), [
            'menu_name' => 'required|string|max:255',
            'menu_slug' => 'nullable|string|max:255|unique:menus,menu_slug,' . $menu->id,
            'menu_icon' => 'nullable|string|max:255',
            'menu_url' => 'nullable|string|max:255',
            'menu_permission' => 'nullable|string|max:255',
            'menu_parent' => 'nullable|integer|exists:menus,id',
            'menu_order' => 'nullable|integer|min:0',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Generate slug if not provided
        $slug = $request->menu_slug ?: Str::slug($request->menu_name);

        // Ensure slug is unique (excluding current menu)
        $originalSlug = $slug;
        $counter = 1;
        while (Menu::where('menu_slug', $slug)->where('id', '!=', $menu->id)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        $menu->update([
            'menu_name' => $request->menu_name,
            'menu_slug' => $slug,
            'menu_icon' => $request->menu_icon,
            'menu_url' => $request->menu_url,
            'menu_permission' => $request->menu_permission,
            'menu_parent' => $request->menu_parent ?: 0,
            'menu_order' => $request->menu_order ?: $menu->menu_order,
            'updated_by' => Auth::id(),
        ]);

        return redirect()->route('menus.index')
            ->with('success', 'Menu updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Menu $menu)
    {
        // Check if menu has children
        if ($menu->children()->count() > 0) {
            return redirect()->back()
                ->with('error', 'Cannot delete menu with child menus. Please delete child menus first.');
        }

        $menu->delete();

        return redirect()->route('menus.index')
            ->with('success', 'Menu deleted successfully.');
    }

    /**
     * Reorder menus.
     */
    public function reorder(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'menus' => 'required|array',
            'menus.*.id' => 'required|integer|exists:menus,id',
            'menus.*.order' => 'required|integer|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => 'Invalid data provided'], 422);
        }

        foreach ($request->menus as $menuData) {
            Menu::where('id', $menuData['id'])->update([
                'menu_order' => $menuData['order'],
                'updated_by' => Auth::id(),
            ]);
        }

        return response()->json(['success' => 'Menu order updated successfully']);
    }
}