@extends('admin.dashboard.master')

@section('main_content')
<section class="content-body" style="background-color:#f4f6f9; padding:20px;">

<div class="container-fluid">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-3 sticky-top bg-white p-3 shadow-sm rounded">
        <h4 class="mb-0">
            <i class="fa fa-edit text-primary"></i> Edit Role
            <span class="badge bg-info ms-2" id="permissionCount">0 Selected</span>
        </h4>
        <a href="{{ route('roles.index') }}" class="btn btn-outline-secondary">
            <i class="fa fa-arrow-left"></i> Back
        </a>
    </div>

    <!-- Validation Errors -->
    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Validation Error</strong>
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {!! Form::model($role, ['method' => 'PATCH','route' => ['roles.update', $role->id]]) !!}

    <div class="card shadow-sm border-0">
        <div class="card-body">

            <!-- Role Name -->
            <div class="form-group mb-4">
                <label class="fw-bold">Role Name</label>
                {!! Form::text('name', null, [
                    'class' => 'form-control form-control-lg',
                    'placeholder' => 'Enter role name'
                ]) !!}
            </div>

            <!-- Permission Search -->
            <div class="mb-3">
                <input type="text" id="permissionSearch" class="form-control"
                       placeholder="🔍 Search permissions...">
            </div>

            <!-- Select All -->
            <div class="mb-3">
                <label class="fw-bold">
                    <input type="checkbox" id="selectAll"> Select All Permissions
                </label>
            </div>

            <hr>

            <!-- Permissions -->
            <div class="row permission-wrapper" style="max-height:450px; overflow:auto;">

                @foreach($groupedPermissions as $group => $permissions)
                <div class="col-md-4 mb-4 permission-group">
                    <div class="card border shadow-sm h-100">
                        <div class="card-header bg-dark text-white sticky-top">
                            <label class="mb-0">
                                <input type="checkbox" class="group-select">
                                {{ ucfirst($group) }}
                            </label>
                        </div>

                        <div class="card-body">
                            @foreach($permissions as $permission)
                                <div class="form-check permission-item">
                                    <input type="checkbox"
                                           name="permission[]"
                                           value="{{ $permission->id }}"
                                           class="form-check-input permission-checkbox"
                                           {{ in_array($permission->id, $rolePermissions) ? 'checked' : '' }}>
                                    <label class="form-check-label">
                                        {{ $permission->name }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endforeach

            </div>

        </div>

        <!-- Footer -->
        <div class="card-footer text-center bg-light">
            <button type="submit" class="btn btn-primary btn-lg px-5">
                <i class="fa fa-save"></i> Update Role
            </button>
        </div>
    </div>

    {!! Form::close() !!}
</div>
</section>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).ready(function () {

    updateCount();

    // Select All
    $('#selectAll').on('change', function () {
        $('.permission-checkbox').prop('checked', this.checked);
        updateCount();
    });

    // Group Select
    $('.group-select').on('change', function () {
        $(this).closest('.permission-group')
               .find('.permission-checkbox')
               .prop('checked', this.checked);
        updateCount();
    });

    // Individual checkbox
    $('.permission-checkbox').on('change', updateCount);

    // Search
    $('#permissionSearch').on('keyup', function () {
        let value = $(this).val().toLowerCase();
        $('.permission-item').filter(function () {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });

    function updateCount() {
        let count = $('.permission-checkbox:checked').length;
        $('#permissionCount').text(count + ' Selected');
    }
});
</script>

<!-- SweetAlert Success -->
@if(session('success'))
<script>
Swal.fire({
    icon: 'success',
    title: 'Updated!',
    text: "{{ session('success') }}",
    timer: 2000,
    showConfirmButton: false
});
</script>
@endif
@endpush
