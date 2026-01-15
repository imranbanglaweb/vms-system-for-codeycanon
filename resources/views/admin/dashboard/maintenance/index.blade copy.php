@extends('admin.dashboard.master')

@section('main_content')
<section role="main" class="content-body">
<div class="container mt-4">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold text-primary">Maintenance Records</h4>
        <a href="{{ route('maintenance.create') }}" class="btn btn-primary btn-sm">
            <i class="fa fa-plus"></i> Add Record
        </a>
    </div>

    <div class="card shadow-sm border-0 rounded-3">
        <div class="card-body">

            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Vehicle</th>
                        <th>Type</th>
                        <th>Vendor</th>
                        <th>Date</th>
                        <th>Cost</th>
                        <th>Performed By</th>
                        <th style="width:120px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($records as $item)
                    <tr>
                        <td>{{ $item->vehicle->name ?? 'N/A' }}</td>
                        <td>{{ $item->maintenanceType->name ?? 'N/A' }}</td>
                        <td>{{ $item->vendor->name ?? 'N/A' }}</td>
                        <td>{{ $item->performed_at ?? '--' }}</td>
                        <td>{{ number_format($item->cost,2) }}</td>
                        <td>{{ $item->performedBy->name ?? 'System' }}</td>
                        <td>
                            <a href="{{ route('maintenance-records.show',$item->id) }}" class="btn btn-sm btn-primary">
                                <i class="fa fa-eye"></i>
                            </a>
                            <a href="{{ route('maintenance-records.edit',$item->id) }}" class="btn btn-sm btn-warning">
                                <i class="fa fa-edit"></i>
                            </a>
                            <form action="{{ route('maintenance-records.destroy',$item->id) }}"
                                  method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-danger"
                                        onclick="return confirm('Delete record?')">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
    </div>
</div>
</section>
@endsection
