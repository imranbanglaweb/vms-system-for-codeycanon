@extends('admin.dashboard.master')

@section('title','Create Subscription Plan')

@section('main_content')
<section class="content-body py-4" style="background:#fff">
<div class="container-fluid">

<!-- HEADER -->
<div class="d-flex justify-content-between align-items-center mb-5">
    <h2 class="fw-bold mb-0">
        <i class="bi bi-box-seam text-primary"></i>
        Create Subscription Plan
    </h2>

    <a href="{{ route('admin.plans.index') }}"
       class="btn btn-outline-secondary btn-lg">
        <i class="bi bi-arrow-left"></i> Back
    </a>
</div>

<form id="planForm" method="POST" action="{{ route('admin.plans.store') }}">
@csrf

<div class="card border-0 shadow-sm rounded-4">
<div class="card-body p-5">

<div class="row">

<!-- BASIC INFO -->
<div class="col-md-4">
    <label class="form-label fw-semibold fs-5">Plan Name</label>
    <input type="text" name="name"
           class="form-control form-control-xl"
           placeholder="Business Plan">
</div>

<div class="col-md-4">
    <label class="form-label fw-semibold fs-5">Slug</label>
    <input type="text" name="slug"
           class="form-control form-control-xl"
           placeholder="business-plan">
</div>

<div class="col-md-4">
    <label class="form-label fw-semibold fs-5">Price (৳)</label>
    <input type="number" name="price"
           class="form-control form-control-xl"
           placeholder="5000">
</div>

<div class="col-md-4">
    <label class="form-label fw-semibold fs-5">Billing Cycle</label>
    <select name="billing_cycle"
            class="form-select form-control-xl">
        <option value="monthly">Monthly</option>
        <option value="yearly">Yearly</option>
    </select>
</div>

<div class="col-md-4">
    <label class="form-label fw-semibold fs-5 d-block">
        Popular Plan
    </label>
    <div class="form-check form-switch mt-3 fs-5">
        <input class="form-check-input" type="checkbox"
               name="is_popular" value="1">
        <label class="form-check-label ms-2">
            Mark as Most Popular
        </label>
    </div>
</div>

<hr>

<!-- LIMITS -->
<div class="col-md-6">
    <label class="form-label fw-semibold fs-5">Vehicle Limit</label>
    <input type="number" name="vehicle_limit"
           class="form-control form-control-xl"
           placeholder="25">
</div>

<div class="col-md-6">
    <label class="form-label fw-semibold fs-5">User Limit</label>
    <input type="number" name="user_limit"
           class="form-control form-control-xl"
           placeholder="10">
</div>
<div style="clear:both"></div>
<!-- FEATURES -->
<div class="col-12">
    <label class="form-label fw-semibold fs-4 mb-3">
        Plan Features
    </label>

    <div id="feature-list" class="feature-editor">

        <div class="feature-item">
            <input type="text" name="features[]"
                   class="form-control form-control-xl"
                   placeholder="Fuel Management">
            <button type="button"
                    class="btn btn-outline-danger btn-lg remove-feature">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>

    </div>

    <button type="button"
            class="btn btn-info btn-md pull-right mt-3"
            onclick="addFeature()">
        <i class="bi bi-plus-circle"></i> Add Feature
    </button>
</div>

</div>
</div>
<br>

<div id="form-errors" class="alert alert-danger d-none"></div>

<!-- FOOTER -->

<button type="submit" class="btn btn-primary btn-xl px-5">
    <span class="btn-text">
        <i class="bi bi-save"></i> Save Plan
    </span>
    <span class="spinner-border spinner-border-sm d-none" id="btnLoader"></span>
</button>
<!-- <div class="card-footer bg-white border-0 pull-right">
    <button class="btn btn-primary btn-xl shadow-sm"> 
        <i class="bi bi-save"></i> Save Plan
    </button>
    <br>
</div> -->
<br>
</div>
</form>

</div>
</section>

<link rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

<style>
/* EXTRA LARGE CONTROLS */
.form-control-xl,
.form-select.form-control-xl {
    font-size: 1.25rem;
    padding: 14px 18px;
    border-radius: 14px;
    color:#000
}

/* FEATURE EDITOR */
.feature-editor {
    background: #f9fafb;
    border: 1px solid #e5e7eb;
    border-radius: 18px;
    padding: 24px;
    color:#000
}

.feature-item {
    display: flex;
    gap: 14px;
    align-items: center;
    margin-bottom: 14px;
    color:#000
}

.feature-item:last-child {
    margin-bottom: 0;
    color:#000
}

.remove-feature {
    width: 52px;
    height: 52px;
    border-radius: 50%;
    color:#000
}

/* BUTTON SIZE */
.btn-xl {
    font-size: 1.2rem;
    padding: 14px 28px;
    color:#000
}

/* CARD */
.card {
    border-radius: 22px;
    color:#000
}
</style>
<script>
document.getElementById('planForm').addEventListener('submit', function (e) {
    e.preventDefault();

    const form = this;
    const url = form.action;
    const formData = new FormData(form);

    const errorBox = document.getElementById('form-errors');
    const btnLoader = document.getElementById('btnLoader');
    const btnText = document.querySelector('.btn-text');

    // Reset UI
    errorBox.classList.add('d-none');
    errorBox.innerHTML = '';
    btnLoader.classList.remove('d-none');
    btnText.classList.add('d-none');

    fetch(url, {
        method: 'POST',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': document.querySelector('input[name=_token]').value
        },
        body: formData
    })
    .then(async response => {
        btnLoader.classList.add('d-none');
        btnText.classList.remove('d-none');

        if (!response.ok) {
            const data = await response.json();
            throw data;
        }
        return response.json();
    })
    .then(data => {
        // SUCCESS
        window.location.href = data.redirect ?? "{{ route('admin.plans.index') }}";
    })
    .catch(err => {
        btnLoader.classList.add('d-none');
        btnText.classList.remove('d-none');

        errorBox.classList.remove('d-none');

        if (err.errors) {
            let html = '<ul class="mb-0">';
            Object.values(err.errors).forEach(messages => {
                messages.forEach(msg => {
                    html += `<li>${msg}</li>`;
                });
            });
            html += '</ul>';
            errorBox.innerHTML = html;
        } else {
            errorBox.innerHTML = 'Something went wrong. Please try again.';
        }
    });
});
</script>

<script>
function addFeature() {
    const container = document.getElementById('feature-list');

    const div = document.createElement('div');
    div.className = 'feature-item';

    div.innerHTML = `
        <input type="text" name="features[]"
               class="form-control form-control-xl"
               placeholder="New Feature">
        <button type="button"
                class="btn btn-outline-danger btn-lg remove-feature">
            <i class="bi bi-x-lg"></i>
        </button>
    `;

    container.appendChild(div);
}

document.addEventListener('click', function(e) {
    if (e.target.closest('.remove-feature')) {
        e.target.closest('.feature-item').remove();
    }
});
</script>

@endsection
