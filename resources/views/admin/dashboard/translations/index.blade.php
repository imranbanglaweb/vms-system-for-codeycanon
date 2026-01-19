@extends('admin.dashboard.master')

@section('main_content')

<link rel="stylesheet" href="{{ asset('public/admin_resource/assets/css/translation.css') }}">

<div id="notification-container"></div>

<section class="content-body" style="background:#fff;">
<div class="main-container">

    <!-- Header -->
    <div class="content-header d-flex justify-content-between align-items-center mb-3">
        <h2><i class="fa fa-language"></i> Translation Management</h2>
        <br>

        <div class="d-flex gap-2 ms-auto align-items-center">
        <div class="row">
            <div class="col-md-4">
                        <!-- Select & Bulk Save -->

        <label>
            <input type="checkbox" id="select-all"> Select All
        </label>

        <button class="btn btn-primary px-4" id="bulk-save-btn" disabled>
            <i class="fa fa-save"></i> Bulk Save
        </button>

            <button class="btn btn-success" id="bulk-auto-btn">
                <i class="fa fa-language"></i> Bulk Auto Translate
            </button>
           
            </div>
            <div class="col-md-4"><input type="text" id="search-input" class="form-control" placeholder="Search..." style="width:260px;">
        </div>
            <div class="col-md-4">
                 <button class="btn btn-primary ms-2 pull-right" data-bs-toggle="modal" data-bs-target="#addTranslationModal">
                <i class="fa fa-plus"></i> Add
            </button>
            </div>
        </div>
        </div>
    </div>

    <div class="progress mb-3" style="display: block;">
        <div id="bulk-save-progress" class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
    </div>

    <!-- Table -->
    <table class="table table-bordered align-middle">
        <thead>
        <tr>
            <th width="40">✔</th>
            <th>Key</th>
            <th>Group</th>
            @foreach(available_languages() as $lang)
                <th>{{ strtoupper($lang->code) }}</th>
            @endforeach
            <th width="180">Action</th>
        </tr>
        </thead>

        <tbody id="translations-table-body">
            <tr>
                <td colspan="100%" class="text-center">
                    <i class="fa fa-spinner fa-spin"></i> Loading...
                </td>
            </tr>
        </tbody>
    </table>

    <div id="pagination-wrapper" class="mt-3"></div>

</div>
</section>
{{-- ADD MODAL --}}
<div class="modal" id="addTranslationModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content p-3">
            <div class="modal-header border-0">
                <h5 class="modal-title"><i class="fa fa-plus-circle me-2"></i> Add Translation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <div class="row g-3">
                    {{-- Left Column: Group + Key --}}
                    <div class="col-md-6">
                        <div class="mb-3 position-relative">
                            <label class="form-label"><i class="fa fa-layer-group me-1"></i> Group</label>
                            <input class="form-control" id="new-group" placeholder="Enter group">
                            <div class="invalid-feedback" id="error-group"></div>
                        </div>

                        <div class="mb-3 position-relative">
                            <label class="form-label"><i class="fa fa-key me-1"></i> Key</label>
                            <input class="form-control" id="new-key" placeholder="Enter key">
                            <div class="invalid-feedback" id="error-key"></div>
                        </div>
                    </div>

                    {{-- Right Column: Language Values --}}
                    <div class="col-md-6">
                        @foreach(available_languages() as $lang)
                            <div class="mb-3 position-relative">
                                <label class="form-label">
                                    <i class="fa fa-language me-1"></i> {{ strtoupper($lang->code) }}
                                    @if(strtolower($lang->code) === 'en') <span class="text-danger">*</span> @endif
                                </label>
                                <input class="form-control new-value" 
                                       data-lang="{{ $lang->code }}" 
                                       placeholder="Enter {{ strtoupper($lang->code) }} value">
                                <div class="invalid-feedback" id="error-{{ $lang->code }}"></div>
                                <span class="valid-icon"><i class="fa fa-check-circle text-success"></i></span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="modal-footer border-0">
                <button class="btn btn-primary px-4" id="add-translation-submit">
                    <i class="fa fa-plus-circle me-1"></i> Submit
                </button>
            </div>
        </div>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
window.LANGUAGES = @json(available_languages()->pluck('code'));
window.ROUTES = {
    ajax: "{{ route('admin.translations.ajax') }}",
    update: "{{ route('translations.update') }}",
    auto: "{{ route('admin.translations.auto') }}",
    create: "{{ route('translations.create') }}"
};
window.CSRF_TOKEN = "{{ csrf_token() }}";
</script>

<script src="{{ asset('public/admin_resource/assets/js/translate.js') }}"></script>

@endsection
