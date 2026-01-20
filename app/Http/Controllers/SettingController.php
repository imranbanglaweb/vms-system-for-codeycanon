<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
class SettingController extends Controller
{
    public function index()
    {
           // $menus = Menu::orderBy('menu_oder','ASC')->paginate(100);

        $settings = DB::table('settings')->where('id',1)->first();
        $languages = DB::table('languages')->orderBy('name')->get();
        return view('admin.dashboard.settings.index', compact('settings', 'languages'));
    }

    public function notification()
    {
        return view('admin.dashboard.settings.notifications');
    }


    public function loadLanguages()
    {
        // Logic to load languages for settings dropdown
        if (class_exists(\App\Models\Language::class)) {
            return \App\Models\Language::all();
        }
        return [];
    }
 public function store(Request $request)
    {

          $validator = Validator::make($request->all(), [
                    "site_title" => "required",
                    // "site_description" => "required",
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()], 400);
        }

          if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()], 400);
        }

        $setting = Setting::find(1);

        if ($request->file('site_logo')) {
            $imagePath = $request->file('site_logo');
       $request->validate([
          'site_logo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
            $imageName = $imagePath->getClientOriginalName();

            // $path = $request->file('site_logo')->storeAs('admin_resource\assets\images', $imageName, 'public');
            // $path = public_path().'//images';
            //   $imagePath->move($path, $imageName);

 $site_logo = time().'.'.$request->site_logo->extension();  
     
  $request->site_logo->move(public_path('admin_resource\assets\images'), $site_logo);

        }

        if ($request->file('admin_logo')) {
            
            $imagePath = $request->file('admin_logo');
       $request->validate([
          'admin_logo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
            $imageName = $imagePath->getClientOriginalName();

            // $path = $request->file('site_logo')->storeAs('admin_resource\assets\images', $imageName, 'public');
            // $path = public_path().'//images';
            //   $imagePath->move($path, $imageName);

 $admin_logo = time().'.'.$request->admin_logo->extension();  
     
  $request->admin_logo->move(public_path('admin_resource\assets\images'), $admin_logo);
        }

        $setting->site_title = $request->site_title;
        $setting->site_description = $request->site_description;
        $setting->site_copyright_text = $request->site_copyright_text;
        $setting->admin_title = $request->admin_title;
        $setting->admin_description = $request->admin_description;

        // Language Settings
        $setting->default_language = $request->default_language ?? 'en';
        $setting->available_languages = $request->available_languages ? json_encode($request->available_languages) : json_encode(['en']);
        $setting->auto_translate = $request->auto_translate ? 1 : 0;
        $setting->translation_cache_duration = $request->translation_cache_duration ?? 60;

        if (!empty($admin_logo)) {
            
             $setting->admin_logo = $admin_logo;
        }

        if (!empty($site_logo)) {
            
             $setting->site_logo = $site_logo;
        }

        $setting->created_by = Auth::id();
        // $setting->path = '/storage/'.$path;
        $setting->save();

        return response()->json('Settings Updated Successfully');
    }

    /**
     * Clear translation cache
     */
    public function clearTranslationCache()
    {
        try {
            Cache::forget('translations');
            Cache::forget('translation_keys');
            
            // Also clear any language-specific caches
            $languages = ['en', 'ar', 'fr', 'es', 'de', 'it', 'pt', 'ru', 'zh', 'ja', 'ko'];
            foreach ($languages as $lang) {
                Cache::forget("translations_{$lang}");
            }
            
            return response()->json(['success' => true, 'message' => 'Translation cache cleared successfully']);
        } catch (\Exception $e) {
            Log::error('Failed to clear translation cache: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to clear translation cache'], 500);
        }
    }

        public function syncLanguages()
        {
        try {
            // Get available languages from settings
            $settings = DB::table('settings')->where('id', 1)->first();
            $availableLanguages = json_decode($settings->available_languages ?? '["en"]', true);
            
            // Ensure all available languages exist in languages table
            foreach ($availableLanguages as $langCode) {
                DB::table('languages')->updateOrInsert(
                    ['code' => $langCode],
                    [
                        'name' => $this->getLanguageName($langCode),
                        'is_active' => 1,
                        'is_default' => ($langCode === ($settings->default_language ?? 'en')),
                        'updated_at' => now()
                    ]
                );
            }
            
            // Clear translation cache to force reload
            $this->clearTranslationCache();
            
            return response()->json(['success' => true, 'message' => 'Languages synchronized successfully']);
        } catch (\Exception $e) {
            Log::error('Failed to sync languages: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to sync languages'], 500);
        }
    }

    /**
     * Get language name from code
     */
    private function getLanguageName($code)
    {
        $languages = [
            'en' => 'English',
            'ar' => 'العربية',
            'fr' => 'Français',
            'es' => 'Español',
            'de' => 'Deutsch',
            'it' => 'Italiano',
            'pt' => 'Português',
            'ru' => 'Русский',
            'zh' => '中文',
            'ja' => '日本語',
            'ko' => '한국어'
        ];
        
        return $languages[$code] ?? ucfirst($code);
    }
}