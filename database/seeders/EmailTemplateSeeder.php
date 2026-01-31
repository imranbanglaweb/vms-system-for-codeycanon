<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\EmailTemplate;

class EmailTemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        $templates = [
            // Requisition Created - sends to Department Head
            [
                'name' => 'Requisition Created Notification',
                'slug' => 'requisition-created',
                'subject' => 'New Vehicle Requisition: {{requisition_number}}',
                'body' => <<<'HTML'
<div style="font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto;">
    <div style="background-color: #3b82f6; color: white; padding: 20px; text-align: center;">
        <h1 style="margin: 0;">New Vehicle Requisition</h1>
    </div>
    
    <div style="padding: 20px; background-color: #f9fafb; border: 1px solid #e5e7eb;">
        <p>A new vehicle requisition has been submitted and requires your approval.</p>
        
        <table style="width: 100%; border-collapse: collapse; margin: 20px 0;">
            <tr>
                <td style="padding: 8px; border-bottom: 1px solid #e5e7eb; font-weight: bold;">Requisition Number:</td>
                <td style="padding: 8px; border-bottom: 1px solid #e5e7eb;">{{requisition_number}}</td>
            </tr>
            <tr>
                <td style="padding: 8px; border-bottom: 1px solid #e5e7eb; font-weight: bold;">Requested By:</td>
                <td style="padding: 8px; border-bottom: 1px solid #e5e7eb;">{{requester_name}}</td>
            </tr>
            <tr>
                <td style="padding: 8px; border-bottom: 1px solid #e5e7eb; font-weight: bold;">Department:</td>
                <td style="padding: 8px; border-bottom: 1px solid #e5e7eb;">{{department_name}}</td>
            </tr>
            <tr>
                <td style="padding: 8px; border-bottom: 1px solid #e5e7eb; font-weight: bold;">Pickup Location:</td>
                <td style="padding: 8px; border-bottom: 1px solid #e5e7eb;">{{pickup_location}}</td>
            </tr>
            <tr>
                <td style="padding: 8px; border-bottom: 1px solid #e5e7eb; font-weight: bold;">Drop-off Location:</td>
                <td style="padding: 8px; border-bottom: 1px solid #e5e7eb;">{{dropoff_location}}</td>
            </tr>
            <tr>
                <td style="padding: 8px; border-bottom: 1px solid #e5e7eb; font-weight: bold;">Date & Time:</td>
                <td style="padding: 8px; border-bottom: 1px solid #e5e7eb;">{{pickup_date}} at {{pickup_time}}</td>
            </tr>
            <tr>
                <td style="padding: 8px; border-bottom: 1px solid #e5e7eb; font-weight: bold;">Purpose:</td>
                <td style="padding: 8px; border-bottom: 1px solid #e5e7eb;">{{purpose}}</td>
            </tr>
            <tr>
                <td style="padding: 8px; border-bottom: 1px solid #e5e7eb; font-weight: bold;">Passengers:</td>
                <td style="padding: 8px; border-bottom: 1px solid #e5e7eb;">{{passengers}}</td>
            </tr>
            <tr>
                <td style="padding: 8px; border-bottom: 1px solid #e5e7eb; font-weight: bold;">Vehicle Type:</td>
                <td style="padding: 8px; border-bottom: 1px solid #e5e7eb;">{{vehicle_type}}</td>
            </tr>
        </table>
        
        <p>Please review and take appropriate action.</p>
        
        <div style="text-align: center; margin-top: 20px;">
            <a href="{{approval_url}}" style="background-color: #3b82f6; color: white; padding: 12px 24px; text-decoration: none; border-radius: 6px; display: inline-block;">
                Review Requisition
            </a>
        </div>
    </div>
    
    <div style="padding: 20px; text-align: center; color: #6b7280; font-size: 12px;">
        <p>{{company_name}}</p>
    </div>
</div>
HTML,
                'type' => EmailTemplate::TYPE_CREATED,
                'variables' => json_encode([
                    'requisition_number',
                    'requester_name',
                    'requester_email',
                    'department_name',
                    'pickup_location',
                    'dropoff_location',
                    'pickup_date',
                    'pickup_time',
                    'purpose',
                    'vehicle_type',
                    'passengers',
                    'status',
                    'approval_url',
                    'company_name'
                ]),
                'is_active' => true,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            
            // Department Approved - sends to Transport Head
            [
                'name' => 'Department Approval Notification',
                'slug' => 'department-approved',
                'subject' => 'Requisition Approved by Department: {{requisition_number}}',
                'body' => <<<'HTML'
<div style="font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto;">
    <div style="background-color: #10b981; color: white; padding: 20px; text-align: center;">
        <h1 style="margin: 0;">Department Approved</h1>
    </div>
    
    <div style="padding: 20px; background-color: #f9fafb; border: 1px solid #e5e7eb;">
        <p>A requisition has been approved by the department and is now ready for transport assignment.</p>
        
        <table style="width: 100%; border-collapse: collapse; margin: 20px 0;">
            <tr>
                <td style="padding: 8px; border-bottom: 1px solid #e5e7eb; font-weight: bold;">Requisition Number:</td>
                <td style="padding: 8px; border-bottom: 1px solid #e5e7eb;">{{requisition_number}}</td>
            </tr>
            <tr>
                <td style="padding: 8px; border-bottom: 1px solid #e5e7eb; font-weight: bold;">Requested By:</td>
                <td style="padding: 8px; border-bottom: 1px solid #e5e7eb;">{{requester_name}}</td>
            </tr>
            <tr>
                <td style="padding: 8px; border-bottom: 1px solid #e5e7eb; font-weight: bold;">Department:</td>
                <td style="padding: 8px; border-bottom: 1px solid #e5e7eb;">{{department_name}}</td>
            </tr>
            <tr>
                <td style="padding: 8px; border-bottom: 1px solid #e5e7eb; font-weight: bold;">Pickup Location:</td>
                <td style="padding: 8px; border-bottom: 1px solid #e5e7eb;">{{pickup_location}}</td>
            </tr>
            <tr>
                <td style="padding: 8px; border-bottom: 1px solid #e5e7eb; font-weight: bold;">Drop-off Location:</td>
                <td style="padding: 8px; border-bottom: 1px solid #e5e7eb;">{{dropoff_location}}</td>
            </tr>
            <tr>
                <td style="padding: 8px; border-bottom: 1px solid #e5e7eb; font-weight: bold;">Date & Time:</td>
                <td style="padding: 8px; border-bottom: 1px solid #e5e7eb;">{{pickup_date}} at {{pickup_time}}</td>
            </tr>
            <tr>
                <td style="padding: 8px; border-bottom: 1px solid #e5e7eb; font-weight: bold;">Purpose:</td>
                <td style="padding: 8px; border-bottom: 1px solid #e5e7eb;">{{purpose}}</td>
            </tr>
            <tr>
                <td style="padding: 8px; border-bottom: 1px solid #e5e7eb; font-weight: bold;">Passengers:</td>
                <td style="padding: 8px; border-bottom: 1px solid #e5e7eb;">{{passengers}}</td>
            </tr>
        </table>
        
        <p>Please assign a vehicle and driver to this requisition.</p>
        
        <div style="text-align: center; margin-top: 20px;">
            <a href="{{approval_url}}" style="background-color: #10b981; color: white; padding: 12px 24px; text-decoration: none; border-radius: 6px; display: inline-block;">
                Assign Vehicle & Driver
            </a>
        </div>
    </div>
    
    <div style="padding: 20px; text-align: center; color: #6b7280; font-size: 12px;">
        <p>{{company_name}}</p>
    </div>
</div>
HTML,
                'type' => EmailTemplate::TYPE_DEPT_APPROVED,
                'variables' => json_encode([
                    'requisition_number',
                    'requester_name',
                    'requester_email',
                    'department_name',
                    'pickup_location',
                    'dropoff_location',
                    'pickup_date',
                    'pickup_time',
                    'purpose',
                    'vehicle_type',
                    'passengers',
                    'status',
                    'approval_url',
                    'company_name'
                ]),
                'is_active' => true,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            
            // Transport Approved - sends to Employee, Driver, and Transport Head
            [
                'name' => 'Transport Approval Notification',
                'slug' => 'transport-approved',
                'subject' => 'Requisition Approved - Vehicle Assigned: {{requisition_number}}',
                'body' => <<<'HTML'
<div style="font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto;">
    <div style="background-color: #059669; color: white; padding: 20px; text-align: center;">
        <h1 style="margin: 0;">Requisition Approved</h1>
    </div>
    
    <div style="padding: 20px; background-color: #f9fafb; border: 1px solid #e5e7eb;">
        <p>Your vehicle requisition has been approved and a vehicle has been assigned.</p>
        
        <table style="width: 100%; border-collapse: collapse; margin: 20px 0;">
            <tr>
                <td style="padding: 8px; border-bottom: 1px solid #e5e7eb; font-weight: bold;">Requisition Number:</td>
                <td style="padding: 8px; border-bottom: 1px solid #e5e7eb;">{{requisition_number}}</td>
            </tr>
            <tr>
                <td style="padding: 8px; border-bottom: 1px solid #e5e7eb; font-weight: bold;">Pickup Location:</td>
                <td style="padding: 8px; border-bottom: 1px solid #e5e7eb;">{{pickup_location}}</td>
            </tr>
            <tr>
                <td style="padding: 8px; border-bottom: 1px solid #e5e7eb; font-weight: bold;">Drop-off Location:</td>
                <td style="padding: 8px; border-bottom: 1px solid #e5e7eb;">{{dropoff_location}}</td>
            </tr>
            <tr>
                <td style="padding: 8px; border-bottom: 1px solid #e5e7eb; font-weight: bold;">Date & Time:</td>
                <td style="padding: 8px; border-bottom: 1px solid #e5e7eb;">{{pickup_date}} at {{pickup_time}}</td>
            </tr>
            <tr>
                <td style="padding: 8px; border-bottom: 1px solid #e5e7eb; font-weight: bold;">Purpose:</td>
                <td style="padding: 8px; border-bottom: 1px solid #e5e7eb;">{{purpose}}</td>
            </tr>
            <tr>
                <td style="padding: 8px; border-bottom: 1px solid #e5e7eb; font-weight: bold;">Passengers:</td>
                <td style="padding: 8px; border-bottom: 1px solid #e5e7eb;">{{passengers}}</td>
            </tr>
            <tr>
                <td style="padding: 8px; border-bottom: 1px solid #e5e7eb; font-weight: bold;">Vehicle Type:</td>
                <td style="padding: 8px; border-bottom: 1px solid #e5e7eb;">{{vehicle_type}}</td>
            </tr>
        </table>
        
        <p>Your requisition is now confirmed. Please be ready at the pickup location at the scheduled time.</p>
        
        <div style="text-align: center; margin-top: 20px;">
            <a href="{{approval_url}}" style="background-color: #059669; color: white; padding: 12px 24px; text-decoration: none; border-radius: 6px; display: inline-block;">
                View Details
            </a>
        </div>
    </div>
    
    <div style="padding: 20px; text-align: center; color: #6b7280; font-size: 12px;">
        <p>{{company_name}}</p>
    </div>
</div>
HTML,
                'type' => EmailTemplate::TYPE_TRANSPORT_APPROVED,
                'variables' => json_encode([
                    'requisition_number',
                    'requester_name',
                    'requester_email',
                    'department_name',
                    'pickup_location',
                    'dropoff_location',
                    'pickup_date',
                    'pickup_time',
                    'purpose',
                    'vehicle_type',
                    'passengers',
                    'status',
                    'approval_url',
                    'company_name'
                ]),
                'is_active' => true,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        foreach ($templates as $template) {
            // Check if template already exists
            $existing = EmailTemplate::where('slug', $template['slug'])->first();
            if (!$existing) {
                EmailTemplate::create($template);
            }
        }
    }
}
