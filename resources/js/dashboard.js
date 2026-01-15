import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: import.meta.env.VITE_PUSHER_APP_KEY || process.env.MIX_PUSHER_APP_KEY,
    cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER || 'mt1',
    forceTLS: false,
    encrypted: true,
    disableStats: true,
});

function updateDashboardCards(data) {
    $('#cardTotal').text(data.total);
    $('#cardPending').text(data.pending);
    $('#cardApproved').text(data.approved);
    $('#cardRejected').text(data.rejected);
    $('#cardCompleted').text(data.completed);
}

function prependTimeline(item) {
    let html = `
        <div class="mb-3">
            <div class="small text-muted">${new Date(item.travel_date).toLocaleString()} by ${item.requested_by_name}</div>
            <div class="fw-bold">${item.status_text}</div>
        </div>`;
    $('#timelineContainer').prepend(html);
}

function addLatestRequisitionRow(item) {
    let row = `
    <tr>
        <td>${item.id}</td>
        <td>${item.requested_by_name}</td>
        <td>${(new Date(item.travel_date)).toLocaleDateString()}</td>
        <td>
            <span class="badge ${item.status==3 ? 'bg-success' : (item.status==4 ? 'bg-danger' : 'bg-warning')}">
                ${item.status_text}
            </span>
        </td>
    </tr>`;
    $('#latestTableBody').prepend(row);
}

// Listen to events
window.Echo.channel('dashboard')
    .listen('RequisitionCreated', (e) => {
        prependTimeline(e);
        addLatestRequisitionRow(e);
        toastr.info('New requisition created');
        if (typeof fetchNotifications === 'function') {
            fetchNotifications();
        }
    })
    .listen('RequisitionStatusUpdated', (e) => {
        prependTimeline(e);
        toastr.info('Requisition status updated');
    });

// Listen for RequisitionCreated event on the dashboard channel
window.Echo.channel('dashboard')
    .listen('RequisitionCreated', (e) => {
        if (window.Swal) {
            Swal.fire({
                icon: 'info',
                title: 'New Requisition Created',
                text: `By: ${e.requested_by_name}\nDate: ${e.travel_date}`,
                timer: 4000,
                showConfirmButton: false
            });
        } else {
            alert('New Requisition Created by ' + e.requested_by_name);
        }
        if (typeof fetchNotifications === 'function') {
            fetchNotifications();
        }
    });
