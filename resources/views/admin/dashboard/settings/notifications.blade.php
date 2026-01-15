@extends('admin.dashboard.master')

@section('main_content')
<br>
<section role="main" class="content-body" style="background-color:#fff">
<div class="container">

    <h4 class="fw-bold text-primary mb-3">
        <i class="bi bi-bell-fill"></i> Notification Settings
    </h4>

    <div class="card shadow-sm border-0">
        <div class="card-body">

            <p id="push-status" class="text-muted mb-3">
                Checking notification status...
            </p>

            <button id="btn-subscribe" class="btn btn-success d-none">
                <i class="fa  fa-bell"></i> Enable Notifications
            </button>

            <button id="btn-unsubscribe" class="btn btn-danger d-none">
                <i class="fa fa-bell-slash"></i> Disable Notifications
            </button>

        </div>
    </div>

</div>
</section>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
const vapidPublicKey = "{{ config('webpush.vapid.public_key') }}";
const csrfToken = "{{ csrf_token() }}";

const btnSubscribe = document.getElementById('btn-subscribe');
const btnUnsubscribe = document.getElementById('btn-unsubscribe');
const statusText = document.getElementById('push-status');

function urlBase64ToUint8Array(base64String) {
    const padding = '='.repeat((4 - base64String.length % 4) % 4);
    const base64 = (base64String + padding)
        .replace(/\-/g, '+')
        .replace(/_/g, '/');

    const rawData = window.atob(base64);
    return Uint8Array.from([...rawData].map(char => char.charCodeAt(0)));
}

function setEnabledUI() {
    btnSubscribe.classList.add('d-none');
    btnUnsubscribe.classList.remove('d-none');
    statusText.innerHTML = `<i class="fa fa-check-circle text-success"></i> Push notifications are enabled.`;
}

function setDisabledUI() {
    btnSubscribe.classList.remove('d-none');
    btnUnsubscribe.classList.add('d-none');
    statusText.innerHTML = `<i class="fa fa-times-circle text-danger"></i> Push notifications are disabled.`;
}

document.addEventListener('DOMContentLoaded', async () => {

    if (!('serviceWorker' in navigator) || !('PushManager' in window)) {
        statusText.innerHTML =
            `<i class="fa fa-exclamation-triangle text-warning"></i> Push notifications are not supported in this browser.`;
        return;
    }

    const registration = await navigator.serviceWorker.ready;
    const subscription = await registration.pushManager.getSubscription();

    subscription ? setEnabledUI() : setDisabledUI();
});

/* ✅ Subscribe */
btnSubscribe?.addEventListener('click', async () => {
    try {
        const registration = await navigator.serviceWorker.ready;

        const subscription = await registration.pushManager.subscribe({
            userVisibleOnly: true,
            applicationServerKey: urlBase64ToUint8Array(vapidPublicKey)
        });

        await fetch("{{ route('push.subscribe') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify(subscription)
        });

        setEnabledUI();

        Swal.fire({
            icon: 'success',
            title: 'Notifications Enabled',
            text: 'You will now receive real-time notifications.',
            timer: 2000,
            showConfirmButton: false
        });

    } catch (e) {
        Swal.fire({
            icon: 'error',
            title: 'Permission Denied',
            text: 'Please allow notification permission from browser settings.'
        });
    }
});

/* ❌ Unsubscribe */
btnUnsubscribe?.addEventListener('click', async () => {
    const registration = await navigator.serviceWorker.ready;
    const subscription = await registration.pushManager.getSubscription();

    if (subscription) {
        await subscription.unsubscribe();

        await fetch("{{ route('push.unsubscribe') }}", {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': csrfToken }
        });
    }

    setDisabledUI();

    Swal.fire({
        icon: 'success',
        title: 'Notifications Disabled',
        text: 'You will no longer receive notifications.',
        timer: 2000,
        showConfirmButton: false
    });
});
</script>

@endsection
