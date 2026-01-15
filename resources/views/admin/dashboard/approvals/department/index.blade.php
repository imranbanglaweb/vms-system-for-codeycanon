@extends('admin.dashboard.master')

@section('main_content')
<section role="main" class="content-body" style="background-color:#f1f4f8;">
<div class="container-fluid mt-4">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0 fw-bold"><i class="fa fa-tasks me-2"></i> Department Approval Panel</h3>

        <div class="d-flex gap-2 align-items-center">
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" id="darkModeToggle">
                <label class="form-check-label" for="darkModeToggle">Dark Mode</label>
            </div>
            <button id="infiniteToggle" class="btn btn-outline-secondary btn-sm">Infinite Scroll: Off</button>
        </div>
    </div>

    <div class="card shadow-lg border-0 mb-3">
        <div class="card-body">
            <!-- Filters bar -->
            <div class="row g-2 mb-3" id="filterBar">
                <div class="col-md-3">
                    <input type="text" id="searchBox" class="form-control" placeholder="Search requisition # or text">
                </div>
                <div class="col-md-2">
                    <select id="filterDepartment" class="form-select">
                        <option value="">All Departments</option>
                        @foreach($departments as $d)
                        <option value="{{ $d->id }}">{{ $d->department_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <select id="filterUnit" class="form-select">
                        <option value="">All Units</option>
                        @foreach($units as $u)
                        <option value="{{ $u->id }}">{{ $u->unit_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <select id="filterUser" class="form-select">
                        <option value="">All Requesters</option>
                        @foreach($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-1">
                    <select id="filterStatus" class="form-select">
                        <option value="">All Status</option>
                        <option value="Pending">Pending</option>
                        <option value="busy">busy</option>
                        <option value="Assigned">Assigned</option>
                        <option value="Approved">Approved</option>
                        <option value="Rejected">Rejected</option>
                    </select>
                </div>

                <div class="col-md-2 d-flex gap-2">
                    <input type="date" id="dateFrom" class="form-control">
                    <input type="date" id="dateTo" class="form-control">
                </div>

                <div class="col-12">
                    <button id="btnFilter" class="btn btn-primary btn-sm">Apply</button>
                    <button id="btnReset" class="btn btn-outline-secondary btn-sm">Reset</button>
                </div>
            </div>
<br>
<hr>
            <!-- DataTable -->
            <div class="table-responsive">
                <table id="requisitionTable" class="table table-striped table-hover align-middle w-100">
                    <thead class="bg-dark text-white sticky-top">
                        <tr>
                            <th>Req No</th>
                            <th>Requested By</th>
                            <th>Department</th>
                            <th>Unit</th>
                            <th>Passengers</th>
                            <th>Dept Status</th>
                            <th>Transp Status</th>
                            <th>Created At</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                </table>
            </div>

        </div>
    </div>
</div>

<!-- Review Modal (content loaded via AJAX) -->
<div class="modal fade" id="reviewModal" tabindex="-1">
  <div class="modal-dialog modal-xl modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title"><i class="fa fa-file-alt me-2"></i> Requisition Details</h5>
        <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body p-3" id="modalBody">
          <div class="text-center py-5">
              <div class="spinner-border text-primary"></div>
              <p class="mt-2">Loading details...</p>
          </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-success approveBtn" data-id="">Approve</button>
        <button class="btn btn-danger rejectBtn" data-id="">Reject</button>
        <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>


<!-- Required scripts: jQuery, Bootstrap already included in layout. Add DataTables + Buttons + Scroller + Echo/Pusher -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/scroller/2.1.1/css/scroller.dataTables.min.css">

<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>

<script src="https://cdn.datatables.net/scroller/2.1.1/js/dataTables.scroller.min.js"></script>

<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.colVis.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>

<!-- Laravel Echo + Pusher (optional real-time) -->
<script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
<script src="{{ asset('js/echo.js') }}"></script> <!-- if you have a compiled echo file; optional -->

<script>
$(function(){

    // Branding config
    const BRAND_TITLE = "Unique Group";
    const BRAND_FOOTER = "department of IT & SAP";

    // CSRF token for post
    $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' } });

    // Modal instance
    var reviewModalEl = document.getElementById('reviewModal');
    var reviewModal = new bootstrap.Modal(reviewModalEl);

    // DataTable initialization
    var infiniteMode = false;
    var table = $('#requisitionTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('department.approvals.ajax') }}",
            data: function(d){
                d.department_id = $('#filterDepartment').val();
                d.unit_id = $('#filterUnit').val();
                d.requested_by = $('#filterUser').val();
                d.status = $('#filterStatus').val();
                d.date_from = $('#dateFrom').val();
                d.date_to = $('#dateTo').val();
                d.search_text = $('#searchBox').val();
            }
        },
        deferRender: true,
        scroller: {
            loadingIndicator: true,
            displayBuffer: 10
        },
        scrollY: '55vh',
        scrollCollapse: true,
        columns: [
            { data: 'requisition_number', name: 'requisition_number', render: function(data, type, row){
                // highlight search match client-side
                var search = $('#searchBox').val();
                var display = data;
                if (search && data.toLowerCase().includes(search.toLowerCase())) {
                    var re = new RegExp('('+search+')', 'ig');
                    display = data.replace(re, '<mark>$1</mark>');
                }
                return `<div style="font-size:18px;font-weight:700;color:#0d6efd;">${display}</div>`;
            }},
            { data: 'requested_by', name: 'requestedBy.name' },
            { data: 'department', name: 'department.department_name' },
            { data: 'unit', name: 'unit.unit_name' },
            { data: 'number_of_passenger', name: 'number_of_passenger', render: function(d){ return `<span class="badge bg-success">${d||0}</span>`; }},
            { data: 'department_status_badge', name: 'department_status', render: function(d){
                return statusBadge(d);
            }},
            { data: 'transport_status_badge', name: 'transport_status', render: function(d){
                return statusBadge(d);
            }},
            { data: 'created_at', name: 'created_at' },
            { data: 'action', name: 'action', orderable:false, searchable:false, className: 'text-center' }
        ],
        order: [[7,'desc']],
        dom: 'Bfrtip',
        buttons: [
            { extend: 'colvis', text: 'Columns' },
            {
                extend: 'csv',
                title: BRAND_TITLE + ' - Requisitions',
                filename: 'requisitions',
                exportOptions: { columns: ':visible' },
                messageTop: BRAND_TITLE
            },
            {
                extend: 'excel',
                title: BRAND_TITLE + ' - Requisitions',
                filename: 'requisitions',
                exportOptions: { columns: ':visible' },
                messageTop: BRAND_TITLE,
                customize: function( xlsx ) {
                    // leave default, Excel branding is supported if needed via server lib
                }
            },
            {
                extend: 'pdf',
                title: BRAND_TITLE + ' - Requisitions',
                orientation: 'landscape',
                pageSize: 'A4',
                exportOptions: { columns: ':visible' },
                customize: function (doc) {
                    // add footer
                    doc.footer = (function(page, pages) {
                        return {
                            columns: [
                                { text: BRAND_FOOTER, alignment: 'left', margin: [40,0] },
                                { text: 'Page ' + page.toString() + ' of ' + pages.toString(), alignment: 'right', margin: [0,0,40] }
                            ],
                            fontSize: 9
                        };
                    });
                    // center title
                    doc.content[0].text = BRAND_TITLE + ' - Requisitions';
                }
            },
            { extend: 'print', text: 'Print', exportOptions: { columns: ':visible' } }
        ],
        lengthMenu: [[10,25,50,-1],[10,25,50,'All']],
        pageLength: 10,
        language: { processing: '<div class="spinner-border text-primary"></div>' },
        initComplete: function(){
            // sticky header class already added with thead sticky-top
        }
    });

    // status badge helper
    function statusBadge(value){
        if(!value) return '';
        var v = value.toLowerCase();
        var cls = 'badge bg-secondary';
        if (v === 'pending') cls = 'badge bg-warning text-dark';
        if (v === 'busy') cls = 'badge bg-info text-dark';
        if (v === 'assigned') cls = 'badge bg-secondary';
        if (v === 'approved') cls = 'badge bg-success';
        if (v === 'rejected') cls = 'badge bg-danger';
        return `<span class="${cls}">${value}</span>`;
    }

    // Filters: Apply / Reset
    $('#btnFilter').click(function(){ table.ajax.reload(); });
    $('#btnReset').click(function(){
        $('#filterDepartment, #filterUnit, #filterUser, #filterStatus, #dateFrom, #dateTo, #searchBox').val('');
        table.ajax.reload();
    });

    // Search on enter in search box
    $('#searchBox').on('keypress', function(e){
        if(e.which == 13) table.ajax.reload();
    });

    // Row click to open details (excluding clicking buttons)
    $('#requisitionTable tbody').on('click', 'tr', function(e){
        if ($(e.target).closest('a,button,input,select').length) return;
        var data = table.row(this).data();
        if(!data) return;
        openReviewModal(data);
    });

    // Review button click (action column)
    $(document).on('click', '.reviewRowBtn', function(e){
        e.preventDefault();
        var id = $(this).data('id');
        $.get("{{ url('department/approvals') }}/" + id, function(html){
            $('#modalBody').html(html);
            $('.approveBtn, .rejectBtn').data('id', id);
            reviewModal.show();
        }).fail(function(){ alert('Failed to load details.'); });
    });

    // Modal open helper
    function openReviewModal(data){
        $.get("{{ url('department/approvals') }}/" + data.id, function(html){
            $('#modalBody').html(html);
            $('.approveBtn, .rejectBtn').data('id', data.id);
            reviewModal.show();
        }).fail(function(){ alert('Failed to load details.'); });
    }

    // Approve / Reject functionality (modal buttons)
    $(document).on('click', '.approveBtn', function(){
        var id = $(this).data('id');
        $.post("{{ url('department/approvals') }}/" + id + "/approve", { })
            .done(function(res){
                alert(res.message);
                reviewModal.hide();
                table.ajax.reload(null, false);
            }).fail(function(){ alert('Failed to approve.'); });
    });

    $(document).on('click', '.rejectBtn', function(){
        var id = $(this).data('id');
        var remarks = $('#remarks').val() || '';
        if(!remarks.trim()){ alert('Remarks required to reject.'); return; }
        $.post("{{ url('department/approvals') }}/" + id + "/reject", { remarks: remarks })
            .done(function(res){
                alert(res.message);
                reviewModal.hide();
                table.ajax.reload(null, false);
            }).fail(function(){ alert('Failed to reject.'); });
    });

    // Infinite scroll toggle
    $('#infiniteToggle').click(function(){
        infiniteMode = !infiniteMode;
        if(infiniteMode){
            $(this).text('Infinite Scroll: On');
            table.settings()[0]._oScroller.s.dt.settings()[0].oFeatures.bPaginate = false;
            table.scroller().enable();
        } else {
            $(this).text('Infinite Scroll: Off');
            table.scroller().disable();
            table.page.len(10).draw('page');
        }
    });

    // Dark Mode toggle
    $('#darkModeToggle').change(function(){
        if(this.checked){
            $('body').addClass('bg-dark text-white');
            $('table').addClass('table-dark');
            $('.card').addClass('bg-dark text-white');
        } else {
            $('body').removeClass('bg-dark text-white');
            $('table').removeClass('table-dark');
            $('.card').removeClass('bg-dark text-white');
        }
    });

    // Real-time updates with Pusher (optional). Replace with your keys in .env and bootstrap Echo.
    try {
        Pusher.logToConsole = false;
        var pusher = new Pusher('{{ env('PUSHER_APP_KEY') }}', {
            cluster: '{{ env('PUSHER_APP_CLUSTER') }}',
            encrypted: true
        });
        var channel = pusher.subscribe('requisitions-channel');
        channel.bind('requisition-created', function(data) {
            // new requisition created: reload table
            table.ajax.reload(null, false);
        });
    } catch(e){
        // if Pusher not configured, fallback to periodic polling
        setInterval(function(){
            table.ajax.reload(null, false);
        }, 10000); // every 10s
    }

});
</script>
@endsection
