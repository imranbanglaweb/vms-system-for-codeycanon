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
                <button id="btn-test-push" class="btn btn-primary">
                    <i class="fa fa-paper-plane"></i> Send Test Push
                </button>
        </div>
    </div>

</div>
</section>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
const btnTestPush = document.getElementById('btn-test-push');

btnTestPush.addEventListener('click', async () => {

    // Prevent double click
    btnTestPush.disabled = true;

    // Show loading alert
    Swal.fire({
        title: 'Sending Test Notification...',
        text: 'Please wait',
        allowOutsideClick: false,
        allowEscapeKey: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });

    try {
        const res = await fetch("{{ route('admin.push.test') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            }
        });

        const data = await res.json();

        Swal.fire({
            icon: 'success',
            title: 'Done',
            text: data.message,
            timer: 2000,
            showConfirmButton: false
        });

    } catch (error) {
        console.error(error);

        Swal.fire({
            icon: 'error',
            title: 'Failed',
            text: 'Could not send test notification. Please try again.'
        });
    } finally {
        btnTestPush.disabled = false;
    }
});
</script>

<script>
const vapidPublicKey = "{{ config('webpush.vapid.public_key') }}";
const csrfToken = "{{ csrf_token() }}";

const btnSubscribe = document.getElementById('btn-subscribe');
const btnUnsubscribe = document.getElementById('btn-unsubscribe');
const statusText = document.getElementById('push-status');

function urlBase64ToUint8Array(base64String) {
    const padding = '='.repeat((4 - base64String.length % 4) % 4);
    const base64 = (base64String + padding)
        .replace(/-/g, '+')
        .replace(/_/g, '/');
    const rawData = atob(base64);
    return Uint8Array.from([...rawData].map(c => c.charCodeAt(0)));
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

/* 🔎 INIT STATE */
document.addEventListener('DOMContentLoaded', async () => {
    if (!('serviceWorker' in navigator) || !('PushManager' in window)) {
        statusText.innerHTML = 'Push notifications not supported.';
        return;
    }

    const reg = await navigator.serviceWorker.ready;
    const sub = await reg.pushManager.getSubscription();
    sub ? setEnabledUI() : setDisabledUI();
});

/* ✅ SUBSCRIBE */
btnSubscribe.addEventListener('click', async () => {
    try {
        const permission = await Notification.requestPermission();
        if (permission !== 'granted') {
            throw new Error('Permission denied');
        }

        const reg = await navigator.serviceWorker.ready;

        // 🔥 ALWAYS clean old subscription
        const oldSub = await reg.pushManager.getSubscription();
        if (oldSub) {
            await oldSub.unsubscribe();
        }

        const newSub = await reg.pushManager.subscribe({
            userVisibleOnly: true,
            applicationServerKey: urlBase64ToUint8Array(vapidPublicKey)
        });

        await fetch("{{ route('push.subscribe') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify(newSub)
        });

        setEnabledUI();

        Swal.fire({
            icon: 'success',
            title: 'Enabled',
            text: 'Notifications are now active',
            timer: 2000,
            showConfirmButton: false
        });

    } catch (err) {
        console.error(err);
        Swal.fire('Error', err.message || 'Subscription failed', 'error');
    }
});

/* ❌ UNSUBSCRIBE */
btnUnsubscribe.addEventListener('click', async () => {
    try {
        const reg = await navigator.serviceWorker.ready;
        const sub = await reg.pushManager.getSubscription();

        if (sub) {
            await fetch("{{ route('push.unsubscribe') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({ endpoint: sub.endpoint })
            });

            await sub.unsubscribe();
        }

        setDisabledUI();

        Swal.fire({
            icon: 'success',
            title: 'Disabled',
            text: 'Notifications turned off',
            timer: 2000,
            showConfirmButton: false
        });

    } catch (err) {
        console.error(err);
        Swal.fire('Error', 'Unsubscribe failed', 'error');
    }
});
</script>


@endsection
