@extends('admin.dashboard.master')

@section('main_content')
<style>
    .text-secondary {
    color: #0088cc !important;
    font-size: 15px;
    font-weight: 700;
}
.text-dark {
    color: #000!important;
    font-size: 16px;
    font-weight: 600;
}
.table th,td{
    font-size: 15px!important;
    font-weight: 500!important;
}

.table th{
    font-size: 16px!important;
    font-weight: 500!important;
    color: #fff!important;
    background-color: #0088cc!important;
}
</style>
<section role="main" class="content-body" style="background-color:#fff;">
<div class="container">
<!-- 
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-primary">
            <i class="fa fa-shuttle-van me-2"></i> Transport Assignment
        </h2>
    </div> -->
<br>

    {{-- Notification --}}
    <div id="notification" class="mb-3"></div>

    {{-- Requisition Details Premium Card --}}
    <div class="card shadow-lg border-0 mb-5 rounded-4">
        <div class="card-body p-4">
       

        <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="text-primary">
                    <i class="fa fa-shuttle-van me-2"></i> Requisition Details
                </h2>
            </div>
            <hr>

            <div class="row g-4">

                {{-- Req No --}}
                <div class="col-md-2">
                    <div class="detail-box bg-light">
                        <span class="fw-bold fs-4 text-dark">Req No</span>
                        <div style="color:green;font-weight:bold" class="fs-5">{{ $requisition->requisition_number }}</div>
                    </div>
                </div>

                {{-- Requester --}}
                <div class="col-md-3">
                    <div class="detail-box bg-light p-3 rounded-3 border text-center">
                        <span class="fw-bold fs-4 text-dark">Requester</span>
                        <div class="fs-5 text-black"  style="color:blue;font-weight:bold" >{{ $requisition->requestedBy->name }}</div>
                    </div>
                </div>

                {{-- Department --}}
                <div class="col-md-4">
                    <div class="detail-box bg-info p-3 rounded-3 text-center">
                        <span class="fw-bold fs-4 text-white">Department</span>
                        <div class="fs-5 text-white">{{ $requisition->department->department_name }}</div>
                    </div>
                </div>

                {{-- Passenger count --}}
                <div class="col-md-3">
                    <div class="detail-box bg-success p-3 rounded-3 text-center">
                        <span class="fw-bold fs-4 text-white">Passengers</span>
                        <div class="fs-5 text-white">
                            {{ $requisition->number_of_passenger }}
                            @if($requisition->unit)
                                ({{ $requisition->unit->unit_name }})
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <br>
            <div class="row">
                {{-- Purpose --}}
                <div class="col-md-6">
                    <div class="detail-box bg-light p-3 rounded-3 border">
                        <span class="fs-4 text-dark">Purpose</span>
                        <div class="text-primary">{{ $requisition->purpose }}</div>
                    </div>
                </div>

                {{-- From  Location --}}
                <div class="col-md-3">
                    <div class="detail-box bg-light p-3 rounded-3 border">
                        <span class="fw-bold fs-4 text-dark">From Location</span>
                        <div class="bg-success" style="padding:5px">{{ $requisition->from_location }}</div>
                    </div>
                </div>
                {{-- to Location --}}
                <div class="col-md-3">
                    <div class="detail-box bg-light p-3 rounded-3 border">
                        <span class="fw-bold fs-4 text-dark">To Location</span>
                        <div class="bg-primary"  style="padding:5px">{{ $requisition->to_location }}</div>
                    </div>
                </div>
            </div>
            <br>
            <div class="row g-4">
                {{-- Created Date --}}
                <div class="col-md-4">
                    <div class="detail-box bg-light p-3 rounded-3 border">
                        <span class="fw-bold fs-4 text-dark">Created Date</span>
                        <div class="fs-5 text-dark">{{ $requisition->created_at->format('d M Y, h:i A') }}</div>
                    </div>
                </div>

                {{-- Assign Date --}}
                <div class="col-md-4">
                    <div class="detail-box bg-light p-3 rounded-3 border">
                        <span class="fw-bold fs-4 text-dark">Assign Date</span>
                        <div class="fs-5 text-muted">{{ $requisition->assign_date }}</div>
                    </div>
                </div>

                {{-- Required Date --}}
                <div class="col-md-4">
                    <div class="detail-box bg-light p-3 rounded-3 border">
                        <span class="fw-bold fs-4 text-dark">Required Date</span>
                        <div class="fs-5 text-muted">{{ $requisition->required_date }}</div>
                    </div>
                </div>

            </div>
        </div>
    </div>
<hr>
    {{-- Passenger List --}}
    <div class="card shadow-lg border-0 mb-5 rounded-4">
        <div class="card-body p-4">
            <h4 class="mb-4 text-secondary fw-bold">
                <i class="fa fa-users me-2"></i> Passenger List
            </h4>

            <table class="table table-bordered table-striped fs-5">
                <thead class="bg-dark text-white fs-5">
                    <tr>
                        <th style="width:60px;" class="text-center">#</th>
                        <th>Name</th>
                        <th>Designation</th>
                        <th>Department</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($requisition->passengers as $i => $p)
                    <tr>
                        <td class="text-center fw-bold">{{ $i+1 }}</td>
                        <td>{{ $p->employee->name }}</td>
                        <td>{{ $p->employee->designation }}</td>
                        <td>{{ $p->employee->department->department_name ?? 'N/A' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted fs-5">No passengers added.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

        </div>
    </div>

  

</div>



@endsection
