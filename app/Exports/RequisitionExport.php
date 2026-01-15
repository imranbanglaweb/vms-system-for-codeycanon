<?php

namespace App\Exports;

use App\Models\Requisition;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class RequisitionExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Requisition::with('requestedBy','vehicle','driver')
            ->get()
            ->map(function($r){
                return [
                    'ID'            => $r->id,
                    'Employee'      => $r->requestedBy->name ?? '',
                    'Department'    => $r->requestedBy->department ?? '',
                    'Vehicle'       => $r->vehicle->vehicle_name ?? '',
                    'Driver'        => $r->driver->driver_name ?? '',
                    'Travel Date'   => $r->travel_date,
                    'Return Date'   => $r->return_date,
                    'Purpose'       => $r->purpose,
                    'Status'        => $r->status,
                ];
            });
    }

    public function headings(): array
    {
        return [
            'ID','Employee','Department','Vehicle',
            'Driver','Travel Date','Return Date',
            'Purpose','Status'
        ];
    }
}

