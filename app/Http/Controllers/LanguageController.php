<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use App\Services\TranslationService;

class LanguageController extends Controller
{
    protected $translationService;
    
    public function __construct(TranslationService $translationService)
    {
        $this->translationService = $translationService;
    }
    
    /**
     * Switch language
     */
    public function switch(Request $request)
    {
        $request->validate([
            'language' => 'required|string|max:10'
        ]);
        
        $locale = $request->language;
        
        // Validate language exists and active
        if (!$this->translationService->isValidLanguage($locale)) {
            return response()->json([
                'success' => false,
                'message' => 'Language not available'
            ], 400);
        }
        
        // Set locale
        App::setLocale($locale);
        Session::put('locale', $locale);
        
        // Update user preference if authenticated
        if (Auth::check()) {
            Auth::user()->update(['preferred_language' => $locale]);
        }
        
        // Clear translation cache
        $this->translationService->clearCache();
        
        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Language switched successfully',
                'language' => $locale,
                'redirect' => url()->previous()
            ]);
        }
        
        return redirect()->back()->with('success', 'Language switched to ' . $locale);
    }
    
    /**
     * Get current language
     */
    public function current()
    {
        return response()->json([
            'language' => App::getLocale(),
            'direction' => Session::get('direction', 'ltr')
        ]);
    }
    
    /**
     * Get all available languages
     */
    public function list()
    {
        $languages = $this->translationService->getLanguages();

        dd( $languages );
        
        return response()->json([
            'languages' => $languages
        ]);
    }
}