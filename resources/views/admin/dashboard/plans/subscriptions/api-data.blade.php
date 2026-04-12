@extends('admin.dashboard.master')

@php
$apiBaseUrl = 'http://localhost/garibondhu360/backend/public/api';
$apiToken = '2|dSn5j6TDZlDsqyovygCwsliz5OcrLazozRBjMeJz94106c4f';
@endphp

@push('styles')
<link rel="stylesheet" href="{{ asset('public/admin_resource/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('public/admin_resource/plugins/sweetalert2/sweetalert2.min.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
<style>
    .table th, .table td { vertical-align: middle !important; font-size: 14px; }
    .api-endpoint { background: #1e1e1e; color: #d4d4d4; padding: 15px; border-radius: 8px; font-family: 'Consolas', monospace; }
    .api-endpoint code { color: #4ec9b0; }
    .api-endpoint .method { color: #569cd6; font-weight: bold; }
    .api-endpoint .url { color: #ce9178; }
    .nav-tabs .nav-link.active { font-weight: bold; border-bottom: 3px solid #0d6efd; }
    .code-block { background: #f8f9fa; border: 1px solid #dee2e6; border-radius: 6px; padding: 15px; font-size: 13px; }
    .api-info { background: #e7f3ff; border: 1px solid #b3d7ff; border-radius: 8px; padding: 15px; margin-bottom: 20px; }
    .api-info code { background: #fff; padding: 2px 6px; border-radius: 3px; }
</style>
@endpush

@section('main_content')
<br>
<section role="main" class="content-body" style="background-color: #fff;">
    <div class="container-fluid py-4">
        <h4 class="fw-bold mb-4">
            <i class="fa-solid fa-database text-primary"></i> API Data
        </h4>
        
        <div class="api-info">
            <h5><i class="fa-solid fa-key"></i> API Configuration</h5>
            <p><strong>Base URL:</strong> <code>{{ $apiBaseUrl }}</code></p>
            <p><strong>Token:</strong> <code>{{ $apiToken }}</code></p>
        </div>
        
        <ul class="nav nav-tabs mb-4" id="apiTab" role="tablist">
            <li class="nav-item">
                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#users" type="button">
                    <i class="fa-solid fa-users"></i> Users
                </button>
            </li>
            <li class="nav-item">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#pending" type="button">
                    <i class="fa-solid fa-clock"></i> Pending Payments
                </button>
            </li>
            <li class="nav-item">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#endpoints" type="button">
                    <i class="fa-solid fa-code"></i> API Endpoints
                </button>
            </li>
        </ul>

        <div class="tab-content">
            <div class="tab-pane fade show active" id="users">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="mb-3 text-end">
                            <button class="btn btn-primary" onclick="fetchUsers()">
                                <i class="fa-solid fa-download"></i> Fetch Users (Fetch API)
                            </button>
                            <button class="btn btn-success" onclick="fetchUsersAxios()">
                                <i class="fa-solid fa-download"></i> Fetch Users (Axios)
                            </button>
                        </div>
                        <table id="usersTable" class="table table-hover align-middle w-100">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Company</th>
                                    <th>Joined</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>

            <div class="tab-pane fade" id="pending">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="mb-3 text-end">
                            <button class="btn btn-warning" onclick="fetchPendingPayments()">
                                <i class="fa-solid fa-download"></i> Fetch Pending Payments
                            </button>
                        </div>
                        <table id="pendingPaymentsTable" class="table table-hover align-middle w-100">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Company</th>
                                    <th>Plan</th>
                                    <th>Amount</th>
                                    <th>Method</th>
                                    <th>Transaction ID</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>

            <div class="tab-pane fade" id="endpoints">
                <div class="row">
                    <div class="col-md-6 mb-4">
                        <div class="card border-0 shadow-sm">
                            <div class="card-header bg-primary text-white">
                                <h5 class="mb-0"><i class="fa-solid fa-users"></i> GET /users</h5>
                            </div>
                            <div class="card-body">
                                <p>Fetch all registered users from the external API.</p>
                                <div class="code-block">
                                    <strong>Using Fetch:</strong><br>
                                    <pre style="margin:0;background:#1e1e1e;color:#d4d4d4;padding:10px;border-radius:4px;font-family:monospace;font-size:12px;">const response = await fetch('{{ $apiBaseUrl }}/users', {
    headers: {
        'Authorization': 'Bearer {{ $apiToken }}',
        'Content-Type': 'application/json'
    }
});
const data = await response.json();</pre>
                                </div>
                                <br>
                                <div class="code-block">
                                    <strong>Using Axios:</strong><br>
                                    <pre style="margin:0;background:#1e1e1e;color:#d4d4d4;padding:10px;border-radius:4px;font-family:monospace;font-size:12px;">const { data } = await axios.get('{{ $apiBaseUrl }}/users', {
    headers: { 
        'Authorization': 'Bearer {{ $apiToken }}' 
    }
});</pre>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-4">
                        <div class="card border-0 shadow-sm">
                            <div class="card-header bg-warning text-dark">
                                <h5 class="mb-0"><i class="fa-solid fa-clock"></i> GET /payments?status=pending</h5>
                            </div>
                            <div class="card-body">
                                <p>Fetch all pending payments from the external API.</p>
                                <div class="code-block">
                                    <strong>Using Fetch:</strong><br>
                                    <pre style="margin:0;background:#1e1e1e;color:#d4d4d4;padding:10px;border-radius:4px;font-family:monospace;font-size:12px;">const response = await fetch('{{ $apiBaseUrl }}/payments?status=pending', {
    headers: {
        'Authorization': 'Bearer {{ $apiToken }}'
    }
});
const data = await response.json();</pre>
                                </div>
                                <br>
                                <div class="code-block">
                                    <strong>Using Axios:</strong><br>
                                    <pre style="margin:0;background:#1e1e1e;color:#d4d4d4;padding:10px;border-radius:4px;font-family:monospace;font-size:12px;">const { data } = await axios.get('{{ $apiBaseUrl }}/payments?status=pending', {
    headers: { 
        'Authorization': 'Bearer {{ $apiToken }}' 
    }
});</pre>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
const apiBaseUrl = 'http://localhost/garibondhu360/backend/public/api';
const apiToken = '2|dSn5j6TDZlDsqyovygCwsliz5OcrLazozRBjMeJz94106c4f';

let usersTable, pendingTable;

$(function () {
    usersTable = $('#usersTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('admin.api-data.index') }}",
        columns: [
            { data: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'name' },
            { data: 'email' },
            { data: 'phone' },
            { data: 'company' },
            { data: 'joined_at' },
            { data: 'status', orderable: false }
        ]
    });

    pendingTable = $('#pendingPaymentsTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('admin.api-payments.pending') }}",
        columns: [
            { data: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'company' },
            { data: 'plan' },
            { data: 'amount' },
            { data: 'method', orderable: false },
            { data: 'transaction_id' },
            { data: 'created_at' }
        ]
    });
});

async function fetchUsers() {
    try {
        const response = await fetch(apiBaseUrl + '/users', {
            headers: {
                'Authorization': 'Bearer ' + apiToken,
                'Content-Type': 'application/json',
            },
        });
        const data = await response.json();
        console.log('Users:', data);
        alert('Check console for user data');
    } catch (error) {
        console.error('Error:', error);
        alert('Failed to fetch users: ' + error.message);
    }
}

async function fetchUsersAxios() {
    try {
        const response = await axios.get(apiBaseUrl + '/users', {
            headers: {
                'Authorization': 'Bearer ' + apiToken
            }
        });
        console.log('Users (Axios):', response.data);
        alert('Check console for user data');
    } catch (error) {
        console.error('Error:', error);
        alert('Failed to fetch users: ' + error.message);
    }
}

async function fetchPendingPayments() {
    try {
        const response = await fetch(apiBaseUrl + '/payments?status=pending', {
            headers: {
                'Authorization': 'Bearer ' + apiToken,
            },
        });
        const data = await response.json();
        console.log('Pending Payments:', data);
        alert('Check console for pending payments data');
    } catch (error) {
        console.error('Error:', error);
        alert('Failed to fetch pending payments: ' + error.message);
    }
}
</script>
@endpush