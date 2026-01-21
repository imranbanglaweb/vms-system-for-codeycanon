@extends('admin.dashboard.master')

@section('main_content')

<style>
    .settings-container {
        background: #ffffff;
        padding: 25px;
        border-radius: 12px;
        box-shadow: 0 4px 16px rgba(0,0,0,0.08);
    }

    .settings-title {
        font-size: 22px;
        font-weight: 600;
        color: #2a2a2a;
    }

    .tab-btn {
        padding: 10px 25px;
        border-radius: 30px;
        font-weight: 600;
        transition: 0.3s;
    }

    .tab-btn.active {
        background: #4A90E2 !important;
        color: #fff !important;
        box-shadow: 0 4px 10px rgba(74,144,226,0.4);
    }

    .settings-card {
        background: #f9fafc;
        padding: 25px;
        border-radius: 12px;
        transition: 0.3s;
        border: 1px solid #e3e6ea;
    }

    .settings-card:hover {
        box-shadow: 0 3px 12px rgba(0,0,0,0.06);
    }

    label {
        font-weight: 600;
        margin-bottom: 6px;
        color: #333;
    }

    .form-control {
        border-radius: 8px;
    }

    .btn-primary.saved {
        padding: 10px 30px;
        border-radius: 30px;
        font-weight: 600;
        font-size: 16px;
    }
</style>

<section role="main" class="content-body">
    <div class="settings-container">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="settings-title">
                ⚙️ {{ trans(ensure_menu_translation('website_settings')) }}
                
            </h2>
            <a class="btn btn-outline-primary" href="{{ route('home') }}">
                <i class="fa fa-arrow-left me-1"></i> Back
            </a>
        </div>

        {{-- TAB BUTTONS --}}
        <div class="mb-4">
            <button class="btn btn-light tab-btn site_menu active" data-target=".site_settings">
                <i class="fa fa-globe me-1"></i> Site Settings
            </button>
            <button class="btn btn-light tab-btn admin_menu" data-target=".admin_settings">
                <i class="fa fa-user"></i>  Admin Settings
            </button>
            <button class="btn btn-light tab-btn language_menu" data-target=".language_settings">
                <i class="fa fa-language me-1"></i> Language Settings
            </button>
        </div>

        <hr>

        {{-- FORM --}}
        {!! Form::open(['method'=>'POST','enctype'=>'multipart/form-data', 'id'=>'upload-image-form']) !!}

        <div class="row">

            {{-- SITE SETTINGS CARD --}}
            <div class="col-md-12 site_settings settings-card">

                <div class="form-group mb-3">
                    <label>Site Title:</label>
                    {!! Form::text('site_title', $settings->site_title ?? null, ['class'=>'form-control']) !!}
                </div>

                <div class="form-group mb-3">
                    <label>Site Description:</label>
                    {!! Form::textarea('site_description', $settings->site_description ?? null, ['class'=>'form-control']) !!}
                </div>

                <div class="form-group mb-3">
                    <label>Site Copyright:</label>
                    {!! Form::text('site_copyright_text', $settings->site_copyright_text ?? null, ['class'=>'form-control']) !!}
                </div>

                <label>Site Logo:</label>
                <div class="d-flex align-items-center gap-3 mb-3">
                    <input type="file" name="site_logo">
                    @if(!empty($settings->site_logo))
                        <img src="{{ asset('admin_resource/assets/images/'.$settings->site_logo) }}" width="80">
                    @endif
                </div>

            </div>

            {{-- ADMIN SETTINGS CARD --}}
            <div class="col-md-12 admin_settings settings-card">

                <div class="form-group mb-3">
                    <label>Admin Title:</label>
                    {!! Form::text('admin_title', $settings->admin_title ?? null, ['class'=>'form-control']) !!}
                </div>

                <div class="form-group mb-3">
                    <label>Admin Description:</label>
                    {!! Form::text('admin_description', $settings->admin_description ?? null, ['class'=>'form-control']) !!}
                </div>

                <label>Admin Logo:</label>
                <div class="d-flex align-items-center gap-3 mb-3">
                    <input type="file" name="admin_logo">
                    @if(!empty($settings->admin_logo))
                        <img src="{{ asset('public/admin_resource/assets/images/'.$settings->admin_logo) }}" width="80">
                    @endif
                </div>

            </div>

            {{-- LANGUAGE SETTINGS CARD --}}
            <div class="col-md-12 language_settings settings-card" style="display: none;">

                <h4 class="mb-4"><i class="fa fa-language text-primary me-2"></i>Language Management</h4>

                {{-- Default Language --}}
                <div class="form-group mb-4">
                    <label>Default Language:</label>
                    <select name="default_language" class="form-control">
                        @foreach($languages as $lang)
                            <option value="{{ $lang->code }}"
                                    {{ ($settings->default_language ?? 'en') == $lang->code ? 'selected' : '' }}>
                                {{ $lang->native_name }} ({{ strtoupper($lang->code) }})
                            </option>
                        @endforeach
                    </select>
                    <small class="text-muted">This will be the fallback language for untranslated content</small>
                </div>

                {{-- Available Languages --}}
                <div class="form-group mb-4">
                    <label>Available Languages:</label>
                    <div class="border rounded p-3 bg-light">
                        @php
                            $availableLanguages = json_decode($settings->available_languages ?? '["en"]', true);
                        @endphp
                        @foreach($languages as $lang)
                            <div class="form-check d-inline-block me-4 mb-2">
                                <input class="form-check-input" type="checkbox"
                                       name="available_languages[]" value="{{ $lang->code }}"
                                       id="lang_{{ $lang->code }}"
                                       {{ in_array($lang->code, $availableLanguages) ? 'checked' : '' }}>
                                <label class="form-check-label" for="lang_{{ $lang->code }}">
                                    <span class="fi fi-{{ $lang->flag_icon ?? 'us' }} me-1"></span>
                                    {{ $lang->native_name }} ({{ strtoupper($lang->code) }})
                                </label>
                            </div>
                        @endforeach
                    </div>
                    <small class="text-muted">Select which languages users can choose from</small>
                </div>

                {{-- Auto Translation --}}
                <div class="form-group mb-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox"
                               name="auto_translate" value="1" id="auto_translate"
                               {{ ($settings->auto_translate ?? false) ? 'checked' : '' }}>
                        <label class="form-check-label" for="auto_translate">
                            <strong>Enable Auto Translation</strong>
                        </label>
                    </div>
                    <small class="text-muted">Automatically translate new content using Google Translate API</small>
                </div>

                {{-- Language Cache --}}
                <div class="form-group mb-4">
                    <label>Translation Cache Duration (hours):</label>
                    {!! Form::number('cache_duration', $settings->cache_duration ?? 24, [
                        'class'=>'form-control',
                        'min'=>'1',
                        'max'=>'168',
                        'placeholder'=>'24'
                    ]) !!}
                    <small class="text-muted">How long to cache translations (1-168 hours)</small>
                </div>

                {{-- Quick Actions --}}
                <div class="border-top pt-3">
                    <h5 class="mb-3">Quick Actions</h5>
                    <div class="d-flex gap-2 flex-wrap">
                        <button type="button" class="btn btn-outline-primary btn-sm" onclick="clearTranslationCache()">
                            <i class="fa fa-trash me-1"></i>Clear Translation Cache
                        </button>
                        <button type="button" class="btn btn-outline-info btn-sm" onclick="syncLanguages()">
                            <i class="fa fa-sync me-1"></i>Sync Languages
                        </button>
                        <a href="{{ route('admin.translations') }}" class="btn btn-outline-secondary btn-sm" target="_blank">
                            <i class="fa fa-list me-1"></i>Manage Translations
                        </a>
                    </div>
                </div>

            </div>

            <div class="text-center mt-3">
                <button type="submit" class="btn btn-primary saved">Save Changes</button>
            </div>

        </div>

        {!! Form::close() !!}

    </div>
</section>

<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function() {
        // Initialize: Hide all cards
        $('.settings-card').hide();

        // Restore active tab from localStorage or default to Site Settings
        let activeTab = localStorage.getItem('active_settings_tab') || '.site_settings';
        if ($(activeTab).length === 0) activeTab = '.site_settings'; // Fallback

        $(activeTab).show();
        $('.tab-btn').removeClass('active');
        $('.tab-btn[data-target="' + activeTab + '"]').addClass('active');

        // Generic Tab Switching Logic
        $(".tab-btn").click(function(e) {
            e.preventDefault();
            $(".tab-btn").removeClass("active");
            $(this).addClass("active");
            var target = $(this).data('target');
            $(".settings-card").hide();
            $(target).fadeIn(300);
            localStorage.setItem('active_settings_tab', target);
        });
    });

    // AJAX SAVE
    $('#upload-image-form').submit(function(e) {
        e.preventDefault();

        let formData = new FormData(this);
        let btn = $('.saved');
        let originalText = btn.html();

        $.ajax({
            type:'POST',
            url:"{{ route('settings.store') }}",
            data: formData,
            contentType: false,
            processData: false,
            beforeSend: function() {
                btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Saving...');
            },

            success: (response) => {
                Swal.fire({
                    icon: "success",
                    title: "Settings Updated",
                    html: "<span style='color:green;'>Your changes have been saved successfully.</span>",
                    confirmButtonColor: "#4A90E2"
                }).then(() => {
                    location.reload();
                });
            },

            error: function(err){
                console.log(err);
            },
            complete: function() {
                btn.prop('disabled', false).html(originalText);
            }
        });
    });

    // Language Management Functions
    function clearTranslationCache() {
        Swal.fire({
            title: 'Clear Translation Cache?',
            text: 'This will clear all cached translations and may temporarily slow down the site.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, Clear Cache'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '{{ route("admin.language.clear-cache") }}',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Cache Cleared',
                            text: 'Translation cache has been cleared successfully.',
                            confirmButtonColor: '#4A90E2'
                        });
                    },
                    error: function() {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Failed to clear translation cache.',
                            confirmButtonColor: '#d33'
                        });
                    }
                });
            }
        });
    }

    function syncLanguages() {
        Swal.fire({
            title: 'Sync Languages?',
            text: 'This will synchronize language settings with the database.',
            icon: 'info',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Sync Now'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '{{ route("admin.language.sync") }}',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Languages Synced',
                            text: 'Language settings have been synchronized successfully.',
                            confirmButtonColor: '#4A90E2'
                        });
                    },
                    error: function() {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Failed to sync languages.',
                            confirmButtonColor: '#d33'
                        });
                    }
                });
            }
        });
    }
</script>

@endsection
