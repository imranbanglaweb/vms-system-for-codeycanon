<?php

// routes/api.php
Route::middleware('web')->group(function () {
    Route::post('/switch-language', function (Request $request) {
        $request->validate([
            'language' => 'required|string|in:en,bn,ar,hi'
        ]);
        
        session(['locale' => $request->language]);
        
        // Update user preference if logged in
        if (Auth::check()) {
            Auth::user()->update(['preferred_language' => $request->language]);
        }
        
        return response()->json([
            'success' => true,
            'message' => 'Language switched successfully',
            'language' => $request->language
        ]);
    });
    
    // Get all translations for current language
    Route::get('/translations/{group?}', function ($group = 'frontend') {
        $translationService = app(App\Services\TranslationService::class);
        return response()->json([
            'translations' => $translationService->getAll($group)
        ]);
    });
});