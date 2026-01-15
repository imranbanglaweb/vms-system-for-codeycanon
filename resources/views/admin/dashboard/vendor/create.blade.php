@extends('admin.dashboard.master')

@section('main_content')
<section role="main" class="content-body" style=background-color:#fff;>
<div class="container-fluid">
    <div class="card shadow-lg border-0">
        <div class="card-header">
            <br>
            <h4 class="mb-0"><i class="bi bi-building"></i> Add New Vendor</h4>
            <a href="{{ route('vendors.index') }}" class="btn btn-light btn-sm">
                <i class="bi bi-arrow-left"></i> Back
            </a>
        </div>

        <div class="card-body">
            <form action="{{ route('vendors.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row">
                    <!-- Vendor Name -->
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Vendor Name</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-person-vcard"></i></span>
                            <input type="text" name="vendor_name" value="{{ old('vendor_name') }}" class="form-control @error('vendor_name') is-invalid @enderror" placeholder="Enter Vendor Name">
                        </div>
                        @error('vendor_name')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Vendor Type -->
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Vendor Type</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-tags"></i></span>
                            <select name="vendor_type" class="form-select @error('vendor_type') is-invalid @enderror">
                                <option value="">Select Type</option>
                                <option value="Local" {{ old('vendor_type') == 'Local' ? 'selected' : '' }}>Local</option>
                                <option value="International" {{ old('vendor_type') == 'International' ? 'selected' : '' }}>International</option>
                            </select>
                        </div>
                        @error('vendor_type')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Contact Person -->
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Contact Person</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-person-lines-fill"></i></span>
                            <input type="text" name="contact_person" value="{{ old('contact_person') }}" class="form-control @error('contact_person') is-invalid @enderror" placeholder="Enter Contact Person">
                        </div>
                        @error('contact_person')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Contact Number -->
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Contact Number</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-telephone"></i></span>
                            <input type="text" name="contact_number" value="{{ old('contact_number') }}" class="form-control @error('contact_number') is-invalid @enderror" placeholder="Enter Contact Number">
                        </div>
                        @error('contact_number')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Email</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                            <input type="email" name="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" placeholder="Enter Email">
                        </div>
                        @error('email')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Address -->
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Address</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-geo-alt"></i></span>
                            <input type="text" name="address" value="{{ old('address') }}" class="form-control @error('address') is-invalid @enderror" placeholder="Enter Address">
                        </div>
                        @error('address')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Linked RTA Office -->
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Linked RTA Office</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-building-check"></i></span>
                            <select name="rta_office_id" class="form-select @error('rta_office_id') is-invalid @enderror">
                                <option value="">Select Office</option>
                                @foreach($rtaOffices as $office)
                                    <option value="{{ $office->id }}" {{ old('rta_office_id') == $office->id ? 'selected' : '' }}>
                                        {{ $office->office_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        @error('rta_office_id')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Status -->
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Status</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-toggle-on"></i></span>
                            <select name="status" class="form-select @error('status') is-invalid @enderror">
                                <option value="Active" {{ old('status') == 'Active' ? 'selected' : '' }}>Active</option>
                                <option value="Inactive" {{ old('status') == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>
                        @error('status')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="text-end mt-4">
                    <button type="submit" class="btn btn-success px-4">
                        <i class="bi bi-save2"></i> Save Vendor
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
</section>
@endsection
