@forelse($requisitions as $requisition)
<tr>
    <td>{{ $loop->iteration + ($requisitions->currentPage() - 1) * $requisitions->perPage() }}</td>
    <td>
        <a href="{{ route('requisitions.show', $requisition->id) }}" 
         title="View Details">
           <strong>{{ $requisition->requisition_number ?? 'N/A' }}</strong>
            </a>
    </td>
    <td>
        <div class="d-flex align-items-center">
            <div>
                <h6 class="mb-0">{{ $requisition->requestedBy->name ?? 'Unknown Employee' }}</h6>
                <small class="text-strong">{{ $requisition->requestedBy->employee_code}}</small>
            </div>
        </div>
    </td>
    <td>
        <span class="badge bg-info">{{ $requisition->department->department_name ?? 'No Department' }}</span>
    </td>
    <td>
        <div>
            <strong>{{ $requisition->vehicle->vehicle_name ?? 'No Vehicle' }}</strong>
            @if($requisition->vehicle)
                <br><small class="text-muted">{{ $requisition->vehicle->license_plate }}</small>
            @endif
        </div>
    </td>
    <td>
        {{ $requisition->travel_date ? $requisition->travel_date->format('M d, Y') : 'N/A' }}
    </td>
    <td>
        {{ $requisition->return_date ? $requisition->return_date->format('M d, Y') : 'N/A' }}
    </td>

    <td>
        @if($requisition->status == 'Pending')
            <span class="badge bg-warning">Pending</span>
        @elseif($requisition->status == 'Approved')
            <span class="badge bg-success">Approved</span>
        @elseif($requisition->status == 'Rejected')
            <span class="badge bg-danger">Rejected</span>
        @else
            <span class="badge bg-secondary">Unknown</span>
        @endif
    </td>
    <td>
        <div class="btn-group" role="group">
            <a href="{{ route('requisitions.show', $requisition->id) }}" 
           class="btn btn-info btn-sm" title="View Details">
            <i class="fa fa-eye"></i>
        </a>
            <!-- @if($requisition->status == 'Pending')
                <button class="btn btn-sm btn-success approveRequest" 
                        data-id="{{ $requisition->id }}"
                        data-req-number="{{ $requisition->requisition_number }}">
                    <i class="fa fa-check"></i>
                </button>
                <button class="btn btn-sm btn-danger rejectRequest" 
                        data-id="{{ $requisition->id }}"
                        data-req-number="{{ $requisition->requisition_number }}">
                    <i class="fa fa-times"></i>
                </button>
                
            @elseif($requisition->status == 'Rejected')
                <button class="btn btn-sm btn-success approveRequest" 
                        data-id="{{ $requisition->id }}"
                        data-req-number="{{ $requisition->requisition_number }}">
                    <i class="fa fa-check"></i>
                </button>
                <button class="btn btn-sm btn-danger rejectRequest" 
                        data-id="{{ $requisition->id }}"
                        data-req-number="{{ $requisition->requisition_number }}">
                    <i class="fa fa-times"></i>
                </button>
            
                
            @elseif($requisition->status == 'Approved')
                <button class="btn btn-sm btn-success" disabled>
                    <i class="fa fa-check"></i>
                </button>
            @else
                <span class="text-muted small">Action taken</span>
            @endif -->
            
            <a href="{{ route('requisitions.edit', $requisition->id) }}" 
               class="btn btn-sm btn-primary" title="Edit">
                <i class="fa fa-edit"></i>
            </a>
            
            <button class="btn btn-sm btn-danger deleteItem" 
                    data-id="{{ $requisition->id }}"
                    data-req-number="{{ $requisition->requisition_number }}"
                    title="Delete">
                <i class="fa fa-minus"></i>
            </button>
        </div>
    </td>
</tr>
@empty
<tr>
    <td colspan="10" class="text-center py-4">
        <div class="text-muted">
            <i class="fa fa-inbox fa-3x mb-3"></i>
            <h5>No requisitions found</h5>
            <p>No requisitions match your search criteria.</p>
        </div>
    </td>
</tr>
@endforelse