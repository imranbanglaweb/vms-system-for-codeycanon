<div class="modal-header bg-info">
    <h5 class="modal-title text-white">
        <i class="fa fa-file-text"></i> Document Details
    </h5>
    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>

<div class="modal-body">
    <!-- Document Info Tabs -->
    <ul class="nav nav-tabs" id="documentTabs" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="details-tab" data-toggle="tab" href="#details" role="tab">
                <i class="fa fa-info-circle"></i> Basic Info
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="location-tab" data-toggle="tab" href="#location" role="tab">
                <i class="fa fa-map-marker"></i> Location Details
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="dates-tab" data-toggle="tab" href="#dates" role="tab">
                <i class="fa fa-calendar"></i> Dates & Status
            </a>
        </li>
    </ul>

    <div class="tab-content mt-3" id="documentTabContent">
        <!-- Basic Info Tab -->
        <div class="tab-pane fade show active" id="details" role="tabpanel">
            <div class="card border-0">
                <div class="card-body p-0">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-sm table-details">
                                <tr>
                                    <th width="35%">Project</th>
                                    <td>
                                        <span class="badge badge-info">
                                            {{ optional($document->project)->project_name ?? 'N/A' }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Land</th>
                                    <td>
                                        <span class="badge badge-secondary">
                                            {{ optional($document->land)->name ?? 'N/A' }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Document Type</th>
                                    <td>
                                        <span class="badge badge-primary">
                                            {{ optional($document->documentType)->name ?? 'N/A' }}
                                        </span>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-sm table-details">
                                <tr>
                                    <th width="35%">Document Taker</th>
                                    <td>{{ $document->document_taker }}</td>
                                </tr>
                                <tr>
                                    <th>Witness Name</th>
                                    <td>{{ $document->witness_name }}</td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td>
                                        <span class="badge badge-{{ 
                                            $document->status === 'active' ? 'success' : 
                                            ($document->status === 'withdrawn' ? 'warning' : 
                                            ($document->status === 'returned' ? 'info' : 'secondary')) 
                                        }}">
                                            {{ ucfirst($document->status) }}
                                        </span>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div class="withdrawal-reason mt-3">
                        <h6 class="text-muted mb-2">Withdrawal Reason</h6>
                        <div class="p-3 bg-light rounded">
                            {{ $document->withdrawal_reason ?: 'No reason provided' }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Location Details Tab -->
        <div class="tab-pane fade" id="location" role="tabpanel">
            <div class="card border-0">
                <div class="card-body p-0">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="location-info p-3 bg-light rounded">
                                <h6 class="mb-3"><i class="fa fa-archive"></i> Vault Information</h6>
                                <table class="table table-sm table-details">
                                    <tr>
                                        <th width="35%">Vault Number</th>
                                        <td>{{ $document->vault_number }}</td>
                                    </tr>
                                    <tr>
                                        <th>Vault Location</th>
                                        <td>{{ $document->vault_location }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Dates & Status Tab -->
        <div class="tab-pane fade" id="dates" role="tabpanel">
            <div class="card border-0">
                <div class="card-body p-0">
                    <div class="timeline">
                        <div class="timeline-item">
                            <div class="timeline-marker bg-primary"></div>
                            <div class="timeline-content">
                                <h6 class="timeline-title">Document Created</h6>
                                <p class="timeline-date">{{ $document->created_at->format('d M Y, h:i A') }}</p>
                            </div>
                        </div>
                        <div class="timeline-item">
                            <div class="timeline-marker bg-warning"></div>
                            <div class="timeline-content">
                                <h6 class="timeline-title">Proposed Return Date</h6>
                                <p class="timeline-date">{{ $document->proposed_return_date->format('d M Y') }}</p>
                            </div>
                        </div>
                        @if($document->actual_return_date)
                        <div class="timeline-item">
                            <div class="timeline-marker bg-success"></div>
                            <div class="timeline-content">
                                <h6 class="timeline-title">Actually Returned</h6>
                                <p class="timeline-date">{{ $document->actual_return_date->format('d M Y') }}</p>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal-footer bg-light">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">
        <i class="fa fa-times"></i> Close
    </button>
    @if($document->status !== 'returned')
    <button type="button" class="btn btn-success" onclick="showReturnModal({{ $document->id }})">
        <i class="fa fa-undo"></i> Return Document
    </button>
    @endif
    <button type="button" class="btn btn-primary" onclick="editDocument({{ $document->id }})">
        <i class="fa fa-pencil"></i> Edit
    </button>
</div>

<style>
/* Tab styling */
.nav-tabs .nav-link {
    color: #495057;
    border: none;
    border-bottom: 2px solid transparent;
}

.nav-tabs .nav-link.active {
    color: #17a2b8;
    border-bottom: 2px solid #17a2b8;
}

/* Table styling */
.table-details {
    margin-bottom: 0;
}

.table-details th {
    background-color: #f8f9fa;
    font-weight: 600;
    border-top: none;
}

.table-details td {
    border-top: none;
}

/* Timeline styling */
.timeline {
    position: relative;
    padding: 20px 0;
}

.timeline-item {
    position: relative;
    padding-left: 40px;
    margin-bottom: 20px;
}

.timeline-marker {
    position: absolute;
    left: 0;
    width: 14px;
    height: 14px;
    border-radius: 50%;
    border: 2px solid #fff;
    box-shadow: 0 0 0 3px rgba(0,0,0,0.1);
}

.timeline-content {
    padding-bottom: 20px;
    border-bottom: 1px dashed #dee2e6;
}

.timeline-title {
    margin-bottom: 5px;
    color: #495057;
}

.timeline-date {
    font-size: 0.875rem;
    color: #6c757d;
    margin-bottom: 0;
}

/* Badge styling */
.badge {
    padding: 0.5em 0.75em;
    font-weight: 500;
}
</style>

<script>
$(document).ready(function() {
    // Initialize tabs
    $('#documentTabs a').click(function(e) {
        e.preventDefault();
        $(this).tab('show');
    });

    // Show first tab on load
    $('#documentTabs li:first-child a').tab('show');
});
</script> 