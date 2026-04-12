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
    .api-page-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 30px;
        border-radius: 15px;
        margin-bottom: 25px;
        box-shadow: 0 10px 30px rgba(102, 126, 234, 0.4);
    }
    .api-page-header h3 {
        font-weight: 700;
        margin: 0;
    }
    .api-page-header p {
        margin: 5px 0 0;
        opacity: 0.9;
    }
    .config-card {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        border: none;
        border-radius: 15px;
        color: white;
        margin-bottom: 25px;
        box-shadow: 0 8px 25px rgba(245, 87, 108, 0.3);
    }
    .config-card .card-body {
        padding: 20px;
    }
    .config-card code {
        background: rgba(255,255,255,0.25);
        padding: 4px 10px;
        border-radius: 5px;
        font-size: 13px;
        color: #fff;
    }
    .config-card .api-label {
        font-weight: 600;
        font-size: 14px;
        opacity: 0.9;
    }
    .premium-tabs {
        border: none;
        margin-bottom: 20px;
    }
    .premium-tabs .nav-link {
        border: none;
        padding: 12px 25px;
        border-radius: 10px;
        font-weight: 600;
        color: #6c757d;
        transition: all 0.3s ease;
        margin-right: 10px;
    }
    .premium-tabs .nav-link:hover {
        background: #f8f9fa;
        color: #667eea;
    }
    .premium-tabs .nav-link.active {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
    }
    .premium-card {
        border: none;
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.08);
        transition: all 0.3s ease;
        overflow: hidden;
    }
    .premium-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 40px rgba(0,0,0,0.12);
    }
    .premium-card .card-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
        padding: 15px 20px;
        font-weight: 600;
    }
    .premium-card .card-header.warning {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    }
    .premium-card .card-body {
        padding: 20px;
    }
    .code-box {
        background: #1e1e1e;
        color: #d4d4d4;
        padding: 15px;
        border-radius: 10px;
        font-family: 'Consolas', monospace;
        font-size: 12px;
        overflow-x: auto;
        margin-bottom: 10px;
    }
    .code-box .method {
        color: #569cd6;
        font-weight: bold;
    }
    .code-box .key {
        color: #9cdcfe;
    }
    .code-box .string {
        color: #ce9178;
    }
    .premium-btn {
        border: none;
        padding: 10px 20px;
        border-radius: 8px;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    .premium-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.2);
    }
    .btn-gradient-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }
    .btn-gradient-success {
        background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
        color: white;
    }
    .btn-gradient-warning {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        color: white;
    }
    .table th {
        background: #f8f9fa;
        font-weight: 600;
        color: #495057;
    }
    .table-hover tbody tr:hover {
        background: #f8f9fa;
    }
    .stat-card {
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 15px;
        color: white;
    }
    .stat-card.blue { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
    .stat-card.green { background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%); }
    .stat-card.orange { background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); }
    .stat-card .stat-number { font-size: 28px; font-weight: 700; }
    .stat-card .stat-label { font-size: 14px; opacity: 0.9; }
</style>
@endpush

@section('main_content')
<br>
<section role="main" class="content-body" style="background-color: #fff;">
    <div class="container-fluid py-4">
        <!-- Header -->
        <div class="api-page-header">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <h3><i class="fa-solid fa-database me-2"></i> API Data</h3>
                    <p>Connect and fetch data from external API endpoints</p>
                </div>
                <div class="text-end">
                    <span class="badge bg-white text-dark px-3 py-2">
                        <i class="fa-solid fa-circle text-success me-1"></i> Connected
                    </span>
                </div>
            </div>
        </div>

        <!-- API Configuration -->
        <div class="row">
            <div class="col-md-6">
                <div class="config-card">
                    <div class="card-body">
                        <h5 class="mb-3"><i class="fa-solid fa-link me-2"></i>API Endpoint</h5>
                        <p class="api-label mb-1">Base URL</p>
                        <code>{{ $apiBaseUrl }}</code>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="config-card" style="background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%); box-shadow: 0 8px 25px rgba(56, 239, 125, 0.3);">
                    <div class="card-body">
                        <h5 class="mb-3"><i class="fa-solid fa-key me-2"></i>Authentication</h5>
                        <p class="api-label mb-1">Bearer Token</p>
                        <code>{{ $apiToken }}</code>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabs -->
        <ul class="nav nav-tabs premium-tabs" id="apiTab" role="tablist">
            <li class="nav-item">
                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#users" type="button">
                    <i class="fa-solid fa-users me-2"></i>Users
                </button>
            </li>
            <li class="nav-item">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#pending" type="button">
                    <i class="fa-solid fa-clock me-2"></i>Pending Payments
                </button>
            </li>
            <li class="nav-item">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#endpoints" type="button">
                    <i class="fa-solid fa-code me-2"></i>API Endpoints
                </button>
            </li>
        </ul>

        <div class="tab-content">
            <!-- Users Tab -->
            <div class="tab-pane fade show active" id="users">
                <div class="row mb-3">
                    <div class="col-md-4">
                        <div class="stat-card blue">
                            <div class="stat-number" id="usersCount">0</div>
                            <div class="stat-label">Total Users</div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="stat-card green">
                            <div class="stat-number" id="activeUsers">0</div>
                            <div class="stat-label">Active Users</div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="stat-card orange">
                            <div class="stat-number" id="newUsers">0</div>
                            <div class="stat-label">New This Month</div>
                        </div>
                    </div>
                </div>
                <div class="premium-card">
                    <div class="card-body">
                        <div class="mb-3 text-end">
                            <button class="premium-btn btn-gradient-primary me-2" onclick="fetchUsers()">
                                <i class="fa-solid fa-download me-1"></i> Fetch (Fetch API)
                            </button>
                            <button class="premium-btn btn-gradient-success" onclick="fetchUsersAxios()">
                                <i class="fa-solid fa-download me-1"></i> Fetch (Axios)
                            </button>
                        </div>
                        <table id="usersTable" class="table table-hover align-middle w-100">
                            <thead>
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

            <!-- Pending Payments Tab -->
            <div class="tab-pane fade" id="pending">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="stat-card orange">
                            <div class="stat-number" id="pendingCount">0</div>
                            <div class="stat-label">Pending Payments</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="stat-card blue">
                            <div class="stat-number" id="pendingAmount">$0</div>
                            <div class="stat-label">Total Amount</div>
                        </div>
                    </div>
                </div>
                <div class="premium-card">
                    <div class="card-body">
                        <div class="mb-3 text-end">
                            <button class="premium-btn btn-gradient-warning" onclick="fetchPendingPayments()">
                                <i class="fa-solid fa-download me-1"></i> Fetch Pending Payments
                            </button>
                        </div>
                        <table id="pendingPaymentsTable" class="table table-hover align-middle w-100">
                            <thead>
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

            <!-- API Endpoints Tab -->
            <div class="tab-pane fade" id="endpoints">
                <div class="row">
                    <div class="col-md-6 mb-4">
                        <div class="premium-card">
                            <div class="card-header">
                                <i class="fa-solid fa-users me-2"></i>GET /users
                            </div>
                            <div class="card-body">
                                <p class="text-muted">Fetch all registered users from the external API.</p>
                                <div class="code-box">
<span class="method">const</span> response = <span class="method">await</span> fetch(<span class="string">'{{ $apiBaseUrl }}/users'</span>, {<br>
&nbsp;&nbsp;headers: {<br>
&nbsp;&nbsp;&nbsp;&nbsp;<span class="key">'Authorization'</span>: <span class="string">'Bearer {{ $apiToken }}'</span>,<br>
&nbsp;&nbsp;&nbsp;&nbsp;<span class="key">'Content-Type'</span>: <span class="string">'application/json'</span><br>
&nbsp;&nbsp;}<br>
});<br>
<span class="method">const</span> data = <span class="method">await</span> response.json();
                                </div>
                                <div class="code-box">
<span class="method">const</span> { data } = <span class="method">await</span> axios.get(<span class="string">'{{ $apiBaseUrl }}/users'</span>, {<br>
&nbsp;&nbsp;headers: { <span class="key">'Authorization'</span>: <span class="string">'Bearer {{ $apiToken }}'</span> }<br>
});
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-4">
                        <div class="premium-card">
                            <div class="card-header warning">
                                <i class="fa-solid fa-clock me-2"></i>GET /payments?status=pending
                            </div>
                            <div class="card-body">
                                <p class="text-muted">Fetch all pending payments from the external API.</p>
                                <div class="code-box">
<span class="method">const</span> response = <span class="method">await</span> fetch(<span class="string">'{{ $apiBaseUrl }}/payments?status=pending'</span>, {<br>
&nbsp;&nbsp;headers: {<br>
&nbsp;&nbsp;&nbsp;&nbsp;<span class="key">'Authorization'</span>: <span class="string">'Bearer {{ $apiToken }}'</span><br>
&nbsp;&nbsp;}<br>
});<br>
<span class="method">const</span> data = <span class="method">await</span> response.json();
                                </div>
                                <div class="code-box">
<span class="method">const</span> { data } = <span class="method">await</span> axios.get(<span class="string">'{{ $apiBaseUrl }}/payments?status=pending'</span>, {<br>
&nbsp;&nbsp;headers: { <span class="key">'Authorization'</span>: <span class="string">'Bearer {{ $apiToken }}'</span> }<br>
});
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
        ajax: {
            url: "{{ route('admin.api-data.index') }}",
            type: 'GET',
            data: { type: 'users' }
        },
        columns: [
            { data: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'name' },
            { data: 'email' },
            { data: 'phone' },
            { data: 'company' },
            { data: 'joined_at' },
            { data: 'status', orderable: false }
        ],
        drawCallback: function(settings) {
            const info = this.api().page.info();
            $('#usersCount').text(info.recordsTotal);
            $('#activeUsers').text(info.recordsTotal);
        }
    });

    pendingTable = $('#pendingPaymentsTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('admin.api-data.index') }}",
            type: 'GET',
            data: { type: 'pending' }
        },
        columns: [
            { data: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'company' },
            { data: 'plan' },
            { data: 'amount' },
            { data: 'method', orderable: false },
            { data: 'transaction_id' },
            { data: 'created_at' }
        ],
        drawCallback: function(settings) {
            const info = this.api().page.info();
            $('#pendingCount').text(info.recordsTotal);
        }
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
        const result = await response.json();
        console.log('Users:', result);
        
        if(result.data) {
            $('#usersCount').text(result.data.length);
            $('#activeUsers').text(result.data.length);
            const now = new Date();
            const thisMonth = result.data.filter(u => new Date(u.created_at) >= new Date(now.getFullYear(), now.getMonth(), 1)).length;
            $('#newUsers').text(thisMonth);
        }
        
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: 'User data fetched successfully. Check console for details.',
            confirmButtonColor: '#667eea'
        });
    } catch (error) {
        console.error('Error:', error);
        Swal.fire({
            icon: 'error',
            title: 'Error!',
            text: 'Failed to fetch users: ' + error.message,
            confirmButtonColor: '#f5576c'
        });
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
        
        if(response.data.data) {
            $('#usersCount').text(response.data.data.length);
            $('#activeUsers').text(response.data.data.length);
            const now = new Date();
            const thisMonth = response.data.data.filter(u => new Date(u.created_at) >= new Date(now.getFullYear(), now.getMonth(), 1)).length;
            $('#newUsers').text(thisMonth);
        }
        
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: 'User data fetched successfully (Axios). Check console for details.',
            confirmButtonColor: '#38ef7d'
        });
    } catch (error) {
        console.error('Error:', error);
        Swal.fire({
            icon: 'error',
            title: 'Error!',
            text: 'Failed to fetch users: ' + error.message,
            confirmButtonColor: '#f5576c'
        });
    }
}

async function fetchPendingPayments() {
    try {
        const response = await fetch(apiBaseUrl + '/payments?status=pending', {
            headers: {
                'Authorization': 'Bearer ' + apiToken,
            },
        });
        const result = await response.json();
        console.log('Pending Payments:', result);
        
        if(result.data) {
            $('#pendingCount').text(result.data.length);
            const total = result.data.reduce((sum, p) => sum + (parseFloat(p.amount) || 0), 0);
            $('#pendingAmount').text('$' + total.toFixed(2));
        }
        
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: 'Pending payments fetched successfully. Check console for details.',
            confirmButtonColor: '#f5576c'
        });
    } catch (error) {
        console.error('Error:', error);
        Swal.fire({
            icon: 'error',
            title: 'Error!',
            text: 'Failed to fetch pending payments: ' + error.message,
            confirmButtonColor: '#f5576c'
        });
    }
}
</script>
@endpush