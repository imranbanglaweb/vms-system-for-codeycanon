@extends('admin.dashboard.master')

@section('title','Manual Payment')

@section('main_content')

<style>
    body { background:#fff; }

    .payment-card h2 { font-size:32px; }
    .payment-card h4 { font-size:22px; }
    .payment-card p,
    .payment-card span,
    .payment-card label {
        font-size:17px;
        line-height:1.6;
    }

    .step-circle{
        width:44px;height:44px;border-radius:50%;
        display:flex;align-items:center;justify-content:center;
        font-weight:700;
    }

    .copy-btn{
        min-width:40px;
        height:36px;
        display:flex;
        align-items:center;
        justify-content:center;
        background:orange;
        color:#fff;
    }

    .copy-row{
        display:flex;
        justify-content:space-between;
        align-items:center;
        gap:10px;
        margin-bottom:12px;
    }
</style>

<section class="content-body bg-white py-4">
<div class="container-fluid">
    <br>
<!-- STEP PROGRESS (INLINE STYLE) -->
<div class="mb-5 text-center">

    <div style="display:inline-flex;align-items:center;gap:60px;position:relative;">

        <!-- PROGRESS LINE -->
        <div style="
            position:absolute;
            top:26px;
            left:60px;
            right:60px;
            height:5px;
            background:#e5e7eb;
            border-radius:10px;
            z-index:0;">
        </div>

        <div style="
            position:absolute;
            top:26px;
            left:60px;
            width:calc(100% - 120px);
            height:5px;
            background:linear-gradient(90deg,#22c55e,#16a34a);
            border-radius:10px;
            z-index:1;">
        </div>

        <!-- STEP 1 -->
        <div style="display:inline-block;z-index:2;">
            <div style="
                width:54px;
                height:54px;
                border-radius:50%;
                background:#22c55e;
                color:#fff;
                display:flex;
                align-items:center;
                justify-content:center;
                box-shadow:0 6px 14px rgba(0,0,0,.15);
                margin:auto;">
                <i class="fa fa-check fs-4"></i>
            </div>
            <div style="margin-top:12px;font-size:18px;font-weight:700;">
                Choose Plan
            </div>
            <div style="font-size:14px;color:#6b7280;">
                Step 1
            </div>
        </div>

        <!-- STEP 2 -->
        <div style="display:inline-block;z-index:2;">
            <div style="
                width:54px;
                height:54px;
                border-radius:50%;
                background:#2563eb;
                color:#fff;
                display:flex;
                align-items:center;
                justify-content:center;
                box-shadow:0 6px 14px rgba(0,0,0,.15);
                margin:auto;">
                <i class="fa fa-credit-card fs-4"></i>
            </div>
            <div style="margin-top:12px;font-size:18px;font-weight:700;">
                Payment
            </div>
            <div style="font-size:14px;color:#6b7280;">
                Step 2
            </div>
        </div>

    </div>

</div>


<div class="row justify-content-center">
<div class="col-xl-10 col-lg-11">

<div class="card payment-card shadow-lg border-0 rounded-4">

<!-- HEADER -->
<div class="card-header bg-primary text-white px-5 py-4">
    <h2 class="fw-bold mb-1" style="padding:10px">Manual Payment</h2>
    <p class="mb-0 opacity-75" style="padding:10px">
        Pay securely using Bank or Mobile Banking
    </p>
</div>

<div class="card-body px-5 py-5">

<!-- PLAN SUMMARY -->
<div class="row mb-5 align-items-center">
    <div class="col-md-6">
        <h4 class="fw-bold mb-1"><strong>{{ $plan->name }}</strong></h4>
        <span><strong>Subscription Plan</strong></span>
    </div>
    <div class="col-md-6 text-md-end mt-3 mt-md-0">
        <br>
        <div class="fw-bold text-success" style="font-size:32px;">
            ৳{{ number_format($plan->price,2) }}
        </div>
        <br>
        <small><strong>Total Payable</strong></small>
    </div>
</div>

<hr class="mb-5">

<!-- PAYMENT METHODS -->
<div class="row g-4 mb-5">

<!-- BANK -->
<div class="col-md-6">
    <div class="border rounded-4 p-4 bg-light h-100">
        <h4 class="fw-bold mb-4">
            <i class="fa fa-bank text-primary me-2"></i>
            Bank Transfer
        </h4>

        <p class="mb-2"><strong>Bank Name:</strong> ABC Bank Ltd.</p>
        <p class="mb-3"><strong>Account Name:</strong> VMS Software Ltd.</p>

        <div class="copy-row">
            <span>
                <strong>Account No:</strong>
                <span id="bankAccount">123-456-789</span>
            </span>
            <button type="button"
                    class="btn btn-outline-primary btn-sm copy-btn"
                    onclick="copyText('bankAccount')">
                <i class="fa fa-copy"></i>
            </button>
        </div>

        <p class="mb-0"><strong>Branch:</strong> Main Branch</p>
    </div>
</div>

<!-- MOBILE -->
<div class="col-md-6">
    <div class="border rounded-4 p-4 bg-light h-100">
        <h4 class="fw-bold mb-4">
            <i class="fa fa-mobile text-success me-2"></i>
            Mobile Banking
        </h4>

        <div class="copy-row">
            <span>
                <strong>bKash:</strong>
                <span id="bkash">01XXXXXXXX</span>
            </span>
            <button type="button"
                    class="btn btn-outline-success btn-sm copy-btn"
                    onclick="copyText('bkash')">
                <i class="fa fa-copy"></i>
            </button>
        </div>

        <div class="copy-row">
            <span>
                <strong>Nagad:</strong>
                <span id="nagad">01XXXXXXXX</span>
            </span>
            <button type="button"
                    class="btn btn-outline-success btn-sm copy-btn"
                    onclick="copyText('nagad')">
                <i class="fa fa-copy"></i>
            </button>
        </div>

        <div class="copy-row">
            <span>
                <strong>Rocket:</strong>
                <span id="rocket">01XXXXXXXX</span>
            </span>
            <button type="button"
                    class="btn btn-outline-success btn-sm copy-btn"
                    onclick="copyText('rocket')">
                <i class="fa fa-copy"></i>
            </button>
        </div>

        <small class="text-muted">
            Use your username or invoice ID as reference
        </small>
    </div>
</div>

</div>

<!-- INFO -->
<div class="alert alert-warning d-flex align-items-start mb-5">
    <i class="fa fa-info-circle fs-3 me-3 mt-1"></i>
    <div>
        After completing payment, submit the transaction ID.
        Subscription will activate after admin verification.
    </div>
</div>

<!-- FORM -->
<form id="manualPaymentForm">
@csrf
<input type="hidden" name="plan_id" value="{{ $plan->id }}">
<input type="hidden" name="amount" value="{{ $plan->price }}">

<div class="mb-4">
    <label class="fw-semibold mb-2">
        Transaction ID / Reference Number
    </label>
    <input type="text"
           name="trx_id"
           class="form-control form-control-lg"
           placeholder="Enter transaction ID"
           required>
</div>

<button  type="submit" class="btn btn-success btn-lg w-100">
    <i class="fa fa-paper-plane me-2"></i>
    Submit Payment for Approval
</button>
</form>

</div>

<div class="card-footer text-center bg-light">
    <h4>
        <strong>Payments are reviewed within 24 business hours.</strong>
</h4>
</div>

</div>
</div>
</div>
</div>
<div class="modal" id="successModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content text-center p-4">
        <div class="modal-body">
            <i class="fa fa-check-circle text-success fs-1 mb-3"></i>
            <h4 class="fw-bold">Payment Submitted</h4>
            <p class="text-muted">Your payment is under admin review.</p>

            <a id="invoiceLink" href="#" class="btn btn-outline-primary mt-3">
                <i class="fa fa-download me-2"></i>
                Download Invoice
            </a>
        </div>
    </div>
  </div>
</div>

</section>


<script>
document.getElementById('manualPaymentForm').addEventListener('submit', function(e) {
    e.preventDefault();

    const form = this;
    const formData = new FormData(form);

    fetch("{{ route('manual.payment.ajax') }}", {
        method: "POST",
        headers: {
            'X-CSRF-TOKEN': document.querySelector('input[name=_token]').value
        },
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            document.getElementById('invoiceLink').href = data.invoice_url;
            new bootstrap.Modal(document.getElementById('successModal')).show();
            form.reset();
        }
    })
    .catch(() => alert('Something went wrong'));
});
</script>

<!-- COPY + BACK DISABLE -->
<script>
function copyText(elementId) {
    const text = document.getElementById(elementId).innerText.trim();

    // Create temporary input
    const tempInput = document.createElement("input");
    tempInput.value = text;
    document.body.appendChild(tempInput);

    // Select & copy
    tempInput.select();
    tempInput.setSelectionRange(0, 99999);
    document.execCommand("copy");

    // Remove temp input
    document.body.removeChild(tempInput);

    // Optional feedback
    showCopyToast();
}

function showCopyToast() {
    const toast = document.createElement("div");
    toast.innerText = "Copied to clipboard";
    toast.style.position = "fixed";
    toast.style.bottom = "30px";
    toast.style.right = "30px";
    toast.style.background = "#16a34a";
    toast.style.color = "#fff";
    toast.style.padding = "12px 20px";
    toast.style.borderRadius = "8px";
    toast.style.fontSize = "16px";
    toast.style.boxShadow = "0 10px 20px rgba(0,0,0,.2)";
    toast.style.zIndex = "9999";

    document.body.appendChild(toast);

    setTimeout(() => toast.remove(), 2000);
}

(function(){
    history.pushState(null,null,location.href);
    window.onpopstate=function(){history.go(1);}
})();
</script>

@endsection
