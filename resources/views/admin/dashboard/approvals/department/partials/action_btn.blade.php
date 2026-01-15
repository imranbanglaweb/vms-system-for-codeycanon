<!-- <a href="{javascript:void(0)}" class="btn btn-sm btn-outline-primary reviewRowBtn" data-id="{{ $r->id }}"> -->
@php
$isApproved = ($r->department_status === 'Approved');
@endphp


@if(!empty($isApproved))
<button disable class="btn btn-info btn-sm">
    <i class="fa fa-eye me-1"></i> Review
</button>
@ELSE
<a href="{{ route('department.approvals.show', $r->id) }}" class="btn btn-secondary btn-sm">
    <i class="fa fa-eye me-1"></i> View
</a> 
@ENDIF
