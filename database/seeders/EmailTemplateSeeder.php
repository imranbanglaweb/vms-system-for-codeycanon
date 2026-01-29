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
        $adminId = 1;

        $templates = [
            // Requisition Created Template
            [
                'name' => 'Requisition Created',
                'slug' => 'requisition-created',
                'subject' => 'New Transport Requisition: {{requisition_number}}',
                'body' => <<<'HTML'
<h3>New Transport Requisition Created</h3>
<p>Dear {{recipient_name}},</p>
<p>A new transport requisition has been created and is awaiting your approval.</p>
<h4>Requisition Details:</h4>
<ul>
    <li><strong>Requisition Number:</strong> {{requisition_number}}</li>
    <li><strong>Requested By:</strong> {{requested_by}}</li>
    <li><strong>Department:</strong> {{department}}</li>
    <li><strong>Date:</strong> {{requisition_date}}</li>
    <li><strong>Purpose:</strong> {{purpose}}</li>
    <li><strong>Pickup Location:</strong> {{pickup_location}}</li>
    <li><strong>Destination:</strong> {{destination}}</li>
    <li><strong>Start Time:</strong> {{start_time}}</li>
    <li><strong>End Time:</strong> {{end_time}}</li>
</ul>
<p>Please login to the system to review and approve this requisition.</p>
<p>Best regards,<br>Vehicle Management System</p>
HTML,
                'type' => EmailTemplate::TYPE_CREATED,
                'variables' => json_encode([
                    'requisition_number',
                    'recipient_name',
                    'requested_by',
                    'department',
                    'requisition_date',
                    'purpose',
                    'pickup_location',
                    'destination',
                    'start_time',
                    'end_time'
                ]),
                'is_active' => true,
                'created_by' => $adminId,
                'updated_by' => $adminId,
                'created_at' => $now,
                'updated_at' => $now,
            ],

            // Department Approved Template
            [
                'name' => 'Department Approved',
                'slug' => 'department-approved',
                'subject' => 'Requisition {{requisition_number}} - Department Approved',
                'body' => <<<'HTML'
<h3>Requisition Department Approval</h3>
<p>Dear {{recipient_name}},</p>
<p>Good news! Your transport requisition has been approved by the department.</p>
<h4>Requisition Details:</h4>
<ul>
    <li><strong>Requisition Number:</strong> {{requisition_number}}</li>
    <li><strong>Requested By:</strong> {{requested_by}}</li>
    <li><strong>Department:</strong> {{department}}</li>
    <li><strong>Approval Date:</strong> {{approval_date}}</li>
    <li><strong>Approved By:</strong> {{approved_by}}</li>
    <li><strong>Purpose:</strong> {{purpose}}</li>
    <li><strong>Pickup Location:</strong> {{pickup_location}}</li>
    <li><strong>Destination:</strong> {{destination}}</li>
</ul>
<p>Your requisition is now pending transport approval. You will be notified once the final approval is complete.</p>
<p>Best regards,<br>Vehicle Management System</p>
HTML,
                'type' => EmailTemplate::TYPE_DEPT_APPROVED,
                'variables' => json_encode([
                    'requisition_number',
                    'recipient_name',
                    'requested_by',
                    'department',
                    'approval_date',
                    'approved_by',
                    'purpose',
                    'pickup_location',
                    'destination'
                ]),
                'is_active' => true,
                'created_by' => $adminId,
                'updated_by' => $adminId,
                'created_at' => $now,
                'updated_at' => $now,
            ],

            // Transport Approved Template
            [
                'name' => 'Transport Approved',
                'slug' => 'transport-approved',
                'subject' => 'Requisition {{requisition_number}} - Fully Approved',
                'body' => <<<'HTML'
<h3>Requisition Fully Approved</h3>
<p>Dear {{recipient_name}},</p>
<p>Excellent! Your transport requisition has been fully approved and is ready for scheduling.</p>
<h4>Requisition Details:</h4>
<ul>
    <li><strong>Requisition Number:</strong> {{requisition_number}}</li>
    <li><strong>Requested By:</strong> {{requested_by}}</li>
    <li><strong>Department:</strong> {{department}}</li>
    <li><strong>Final Approval Date:</strong> {{approval_date}}</li>
    <li><strong>Approved By:</strong> {{approved_by}}</li>
    <li><strong>Purpose:</strong> {{purpose}}</li>
    <li><strong>Pickup Location:</strong> {{pickup_location}}</li>
    <li><strong>Destination:</strong> {{destination}}</li>
    <li><strong>Start Time:</strong> {{start_time}}</li>
    <li><strong>End Time:</strong> {{end_time}}</li>
</ul>
<p>Vehicle and driver details will be assigned shortly. Please be ready at the scheduled pickup time.</p>
<p>Best regards,<br>Vehicle Management System</p>
HTML,
                'type' => EmailTemplate::TYPE_TRANSPORT_APPROVED,
                'variables' => json_encode([
                    'requisition_number',
                    'recipient_name',
                    'requested_by',
                    'department',
                    'approval_date',
                    'approved_by',
                    'purpose',
                    'pickup_location',
                    'destination',
                    'start_time',
                    'end_time'
                ]),
                'is_active' => true,
                'created_by' => $adminId,
                'updated_by' => $adminId,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        // Insert templates (check if they already exist to avoid duplicates)
        foreach ($templates as $template) {
            $exists = EmailTemplate::where('slug', $template['slug'])->exists();
            if (!$exists) {
                EmailTemplate::create($template);
            }
        }
    }
}
