@forelse($requisitions as $requisition)
<tr>
    <td class="text-center" style="font-weight: 500; font-size: 0.95rem;">{{ $loop->iteration + ($requisitions->currentPage() - 1) * $requisitions->perPage() }}</td>
    <td>
        <a href="{{ route('requisitions.show', $requisition->id) }}" class="text-primary fw-semibold text-decoration-none" style="font-size: 0.95rem;">
            {{ $requisition->requisition_number ?? 'N/A' }}
        </a>
    </td>
    <td>
        <div class="d-flex align-items-center">
            <div class="flex-shrink-0">
                <div class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                    <span class="text-primary fw-bold" style="font-size: 0.95rem;">{{ substr($requisition->employee->name ?? 'U', 0, 1) }}</span>
                </div>
            </div>
            <div class="flex-grow-1 ms-3">
                <h6 class="mb-0 fw-semibold" style="font-size: 0.95rem;">{{ $requisition->employee->name ?? 'Unknown' }}</h6>
                <small class="text-muted" style="font-size: 0.8rem;">{{ $requisition->employee->employee_code ?? '' }}</small>
            </div>
        </div>
    </td>
    <td>
        <span class="badge bg-secondary bg-opacity-10 text-secondary" style="font-size: 0.8rem;">{{ $requisition->department->department_name ?? 'N/A' }}</span>
    </td>
    <td>
        <div class="d-flex align-items-center">
            <div class="text-end">
                <div class="fw-semibold" style="font-size: 0.95rem;">{{ $requisition->from_location }}</div>
                <div class="text-muted" style="font-size: 0.85rem;"><i class="fa fa-arrow-down fa-xs mx-1"></i>{{ $requisition->to_location }}</div>
            </div>
        </div>
    </td>
    <td style="font-size: 0.95rem;">
        <div class="fw-semibold">{{ $requisition->travel_date ? $requisition->travel_date->format('M d, Y') : 'N/A' }}</div>
        @if($requisition->travel_time)
            <small class="text-muted" style="font-size: 0.8rem;">{{ $requisition->travel_time->format('h:i A') }}</small>
        @endif
    </td>
    <td style="font-size: 0.95rem;">
        {{ $requisition->return_date ? $requisition->return_date->format('M d, Y') : 'N/A' }}
    </td>
    <td style="font-size: 0.95rem;">
        @if($requisition->vehicle)
            <div class="d-flex align-items-center">
                <div class="flex-shrink-0">
                    <i class="fa fa-car text-muted me-2" style="font-size: 1rem;"></i>
                </div>
                <div class="flex-grow-1">
                    <div class="fw-semibold" style="font-size: 0.95rem;">{{ $requisition->vehicle->vehicle_name }}</div>
                    <small class="text-muted" style="font-size: 0.8rem;">{{ $requisition->vehicle->license_plate }}</small>
                </div>
            </div>
        @else
            <span class="text-muted" style="font-size: 0.95rem;">Not Assigned</span>
        @endif
    </td>
    <td style="font-size: 0.9rem;">
        @if($requisition->department_status == 'Pending')
            <span class="badge bg-warning text-dark" style="font-size: 0.75rem;">Dept: Pending</span>
        @elseif($requisition->department_status == 'Approved')
            <span class="badge bg-info" style="font-size: 0.75rem;">Dept: Approved</span>
        @elseif($requisition->department_status == 'Rejected')
            <span class="badge bg-danger" style="font-size: 0.75rem;">Dept: Rejected</span>
        @else
            <span class="badge bg-secondary" style="font-size: 0.75rem;">{{ $requisition->department_status ?? 'N/A' }}</span>
        @endif
        
        @if($requisition->transport_status)
            <div class="mt-1">
                @if($requisition->transport_status == 'Pending')
                    <span class="badge bg-warning text-dark" style="font-size: 0.75rem;">Trans: Pending</span>
                @elseif($requisition->transport_status == 'Approved')
                    <span class="badge bg-success" style="font-size: 0.75rem;">Trans: Approved</span>
                @elseif($requisition->transport_status == 'Rejected')
                    <span class="badge bg-danger" style="font-size: 0.75rem;">Trans: Rejected</span>
                @else
                    <span class="badge bg-secondary" style="font-size: 0.75rem;">{{ $requisition->transport_status }}</span>
                @endif
            </div>
        @endif
    </td>
    <td style="font-size: 0.95rem;">
        @if($requisition->status == 'Pending')
            <span class="badge bg-warning text-dark" style="font-size: 0.8rem;">Pending</span>
        @elseif($requisition->status == 'Approved')
            <span class="badge bg-success" style="font-size: 0.8rem;">Approved</span>
        @elseif($requisition->status == 'Rejected')
            <span class="badge bg-danger" style="font-size: 0.8rem;">Rejected</span>
        @elseif($requisition->status == 'Completed')
            <span class="badge bg-dark" style="font-size: 0.8rem;">Completed</span>
        @else
            <span class="badge bg-secondary" style="font-size: 0.8rem;">{{ $requisition->status ?? 'Unknown' }}</span>
        @endif
    </td>
    <td class="text-center">
        <div class="btn-group btn-group-sm" role="group">
            <a href="{{ route('requisitions.show', $requisition->id) }}" class="btn btn-outline-info" title="View Details" style="font-size: 0.9rem;">
                <i class="fa fa-eye"></i>
            </a>
            
            @if(!in_array($requisition->status, ['Approved', 'Completed']))
            <a href="{{ route('requisitions.edit', $requisition->id) }}" class="btn btn-outline-primary" title="Edit" style="font-size: 0.9rem;">
                <i class="fa fa-edit"></i>
            </a>
            
            <button class="btn btn-outline-danger deleteItem" 
                    data-id="{{ $requisition->id }}"
                    data-req-number="{{ $requisition->requisition_number }}"
                    title="Delete"
                    style="font-size: 0.9rem;">
                <i class="fa fa-trash"></i>
            </button>
            @endif
        </div>
    </td>
</tr>
@empty
<tr>
    <td colspan="11" class="text-center py-5">
        <div class="text-muted">
            <div class="mb-3">
                <i class="fa fa-inbox fa-4x text-secondary opacity-25" style="font-size: 4rem;"></i>
            </div>
            <h5 class="fw-semibold mb-2" style="font-size: 1.1rem;">No requisitions found</h5>
            <p class="mb-3" style="font-size: 0.95rem;">No requisitions match your search criteria.</p>
            <a href="{{ route('requisitions.create') }}" class="btn btn-primary" style="font-size: 0.95rem;">
                <i class="fa fa-plus-circle me-1"></i>Create New Requisition
            </a>
        </div>
    </td>
</tr>
@endforelse
