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
                'subject' => '🚗 New Vehicle Requisition: {{requisition_number}}',
                'body' => <<<'HTML'
<table role="presentation" cellpadding="0" cellspacing="0" style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; max-width: 600px; margin: 0 auto; width: 100%; background-color: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.08);">
    <tr>
        <td style="background: linear-gradient(135deg, #1e3a5f 0%, #2d5a87 100%); padding: 30px 40px; text-align: center;">
            <h1 style="margin: 0 0 10px 0; color: #ffffff; font-size: 24px; font-weight: 700;">New Vehicle Requisition</h1>
            <p style="margin: 0; color: rgba(255,255,255,0.85); font-size: 14px;">Vehicle Management System</p>
        </td>
    </tr>
    <tr>
        <td style="padding: 30px 40px;">
            <p style="margin: 0 0 20px 0; color: #475569; font-size: 15px; line-height: 1.6;">
                A new vehicle requisition has been submitted and requires your approval.
            </p>
            
            <table role="presentation" cellpadding="0" cellspacing="0" style="width: 100%; border-collapse: collapse; margin: 20px 0; background-color: #f8fafc; border-radius: 8px; overflow: hidden;">
                <tr>
                    <td style="padding: 15px 20px; border-bottom: 1px solid #e2e8f0;">
                        <span style="color: #64748b; font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px;">Requisition Number</span>
                        <br>
                        <span style="color: #1e293b; font-size: 18px; font-weight: 700;">{{requisition_number}}</span>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 15px 20px; border-bottom: 1px solid #e2e8f0;">
                        <span style="color: #64748b; font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px;">Requested By</span>
                        <br>
                        <span style="color: #1e293b; font-size: 15px; font-weight: 600;">{{requester_name}}</span>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 15px 20px; border-bottom: 1px solid #e2e8f0;">
                        <span style="color: #64748b; font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px;">Department</span>
                        <br>
                        <span style="color: #1e293b; font-size: 15px;">{{department_name}}</span>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 15px 20px; border-bottom: 1px solid #e2e8f0;">
                        <span style="color: #64748b; font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px;">Pickup Location</span>
                        <br>
                        <span style="color: #1e293b; font-size: 15px;">{{pickup_location}}</span>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 15px 20px; border-bottom: 1px solid #e2e8f0;">
                        <span style="color: #64748b; font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px;">Drop-off Location</span>
                        <br>
                        <span style="color: #1e293b; font-size: 15px;">{{dropoff_location}}</span>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 15px 20px; border-bottom: 1px solid #e2e8f0;">
                        <span style="color: #64748b; font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px;">Date & Time</span>
                        <br>
                        <span style="color: #1e293b; font-size: 15px;">{{pickup_date}} at {{pickup_time}}</span>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 15px 20px; border-bottom: 1px solid #e2e8f0;">
                        <span style="color: #64748b; font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px;">Purpose</span>
                        <br>
                        <span style="color: #1e293b; font-size: 15px;">{{purpose}}</span>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 15px 20px;">
                        <span style="color: #64748b; font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px;">Passengers</span>
                        <br>
                        <span style="color: #1e293b; font-size: 15px;">{{passengers}} passengers</span>
                    </td>
                </tr>
            </table>
            
            <p style="margin: 25px 0 0 0; color: #475569; font-size: 15px; text-align: center;">
                Please review and take appropriate action.
            </p>
        </td>
    </tr>
    <tr>
        <td style="padding: 0 40px 30px 40px; text-align: center;">
            <a href="{{approval_url}}" style="display: inline-block; padding: 14px 35px; background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); color: #ffffff; text-decoration: none; font-size: 15px; font-weight: 600; border-radius: 8px; box-shadow: 0 4px 12px rgba(59, 130, 246, 0.35);">
                Review Requisition
            </a>
        </td>
    </tr>
    <tr>
        <td style="background-color: #f8fafc; padding: 25px 40px; text-align: center; border-top: 1px solid #e2e8f0;">
            <p style="margin: 0 0 8px 0; color: #64748b; font-size: 14px; font-weight: 600;">{{company_name}}</p>
            <p style="margin: 0; color: #94a3b8; font-size: 12px;">
                &copy; {{year}} {{company_name}}. All rights reserved.
            </p>
        </td>
    </tr>
</table>
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
                    'company_name',
                    'year'
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
                'subject' => '✅ Requisition Approved: {{requisition_number}}',
                'body' => <<<'HTML'
<table role="presentation" cellpadding="0" cellspacing="0" style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; max-width: 600px; margin: 0 auto; width: 100%; background-color: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.08);">
    <tr>
        <td style="background: linear-gradient(135deg, #059669 0%, #10b981 100%); padding: 30px 40px; text-align: center;">
            <h1 style="margin: 0 0 10px 0; color: #ffffff; font-size: 24px; font-weight: 700;">Department Approved</h1>
            <p style="margin: 0; color: rgba(255,255,255,0.85); font-size: 14px;">Ready for Transport Assignment</p>
        </td>
    </tr>
    <tr>
        <td style="padding: 30px 40px;">
            <p style="margin: 0 0 20px 0; color: #475569; font-size: 15px; line-height: 1.6;">
                A requisition has been approved by the department and is now ready for vehicle and driver assignment.
            </p>
            
            <table role="presentation" cellpadding="0" cellspacing="0" style="width: 100%; border-collapse: collapse; margin: 20px 0; background-color: #f8fafc; border-radius: 8px; overflow: hidden;">
                <tr>
                    <td style="padding: 15px 20px; border-bottom: 1px solid #e2e8f0;">
                        <span style="color: #64748b; font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px;">Requisition Number</span>
                        <br>
                        <span style="color: #059669; font-size: 18px; font-weight: 700;">{{requisition_number}}</span>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 15px 20px; border-bottom: 1px solid #e2e8f0;">
                        <span style="color: #64748b; font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px;">Requested By</span>
                        <br>
                        <span style="color: #1e293b; font-size: 15px; font-weight: 600;">{{requester_name}}</span>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 15px 20px; border-bottom: 1px solid #e2e8f0;">
                        <span style="color: #64748b; font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px;">Department</span>
                        <br>
                        <span style="color: #1e293b; font-size: 15px;">{{department_name}}</span>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 15px 20px;">
                        <span style="color: #64748b; font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px;">Trip Details</span>
                        <br>
                        <span style="color: #1e293b; font-size: 15px;">{{pickup_location}} → {{dropoff_location}}</span>
                        <br>
                        <span style="color: #64748b; font-size: 13px;">{{pickup_date}} at {{pickup_time}}</span>
                    </td>
                </tr>
            </table>
            
            <p style="margin: 25px 0 0 0; color: #475569; font-size: 15px; text-align: center;">
                Please assign a vehicle and driver to this requisition.
            </p>
        </td>
    </tr>
    <tr>
        <td style="padding: 0 40px 30px 40px; text-align: center;">
            <a href="{{approval_url}}" style="display: inline-block; padding: 14px 35px; background: linear-gradient(135deg, #059669 0%, #10b981 100%); color: #ffffff; text-decoration: none; font-size: 15px; font-weight: 600; border-radius: 8px; box-shadow: 0 4px 12px rgba(5, 150, 105, 0.35);">
                Assign Vehicle & Driver
            </a>
        </td>
    </tr>
    <tr>
        <td style="background-color: #f8fafc; padding: 25px 40px; text-align: center; border-top: 1px solid #e2e8f0;">
            <p style="margin: 0 0 8px 0; color: #64748b; font-size: 14px; font-weight: 600;">{{company_name}}</p>
            <p style="margin: 0; color: #94a3b8; font-size: 12px;">
                &copy; {{year}} {{company_name}}. All rights reserved.
            </p>
        </td>
    </tr>
</table>
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
                    'company_name',
                    'year'
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
                'subject' => '🎉 Requisition Confirmed: {{requisition_number}}',
                'body' => <<<'HTML'
<table role="presentation" cellpadding="0" cellspacing="0" style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; max-width: 600px; margin: 0 auto; width: 100%; background-color: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.08);">
    <tr>
        <td style="background: linear-gradient(135deg, #7c3aed 0%, #8b5cf6 100%); padding: 30px 40px; text-align: center;">
            <h1 style="margin: 0 0 10px 0; color: #ffffff; font-size: 24px; font-weight: 700;">Requisition Confirmed!</h1>
            <p style="margin: 0; color: rgba(255,255,255,0.85); font-size: 14px;">Vehicle & Driver Assigned</p>
        </td>
    </tr>
    <tr>
        <td style="padding: 30px 40px;">
            <p style="margin: 0 0 20px 0; color: #475569; font-size: 15px; line-height: 1.6;">
                Great news! Your vehicle requisition has been approved and a vehicle has been assigned. Please be ready at the pickup location at the scheduled time.
            </p>
            
            <table role="presentation" cellpadding="0" cellspacing="0" style="width: 100%; border-collapse: collapse; margin: 20px 0; background: linear-gradient(135deg, #f5f3ff 0%, #ede9fe 100%); border-radius: 12px; overflow: hidden;">
                <tr>
                    <td style="padding: 20px;">
                        <table role="presentation" cellpadding="0" cellspacing="0" style="width: 100%;">
                            <tr>
                                <td style="padding: 10px 0; border-bottom: 1px solid #ddd6fe;">
                                    <span style="color: #7c3aed; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px; font-weight: 600;">Requisition #</span>
                                    <br>
                                    <span style="color: #1e293b; font-size: 18px; font-weight: 700;">{{requisition_number}}</span>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 10px 0; border-bottom: 1px solid #ddd6fe;">
                                    <span style="color: #7c3aed; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px; font-weight: 600;">From</span>
                                    <br>
                                    <span style="color: #1e293b; font-size: 15px;">{{pickup_location}}</span>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 10px 0; border-bottom: 1px solid #ddd6fe;">
                                    <span style="color: #7c3aed; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px; font-weight: 600;">To</span>
                                    <br>
                                    <span style="color: #1e293b; font-size: 15px;">{{dropoff_location}}</span>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 10px 0; border-bottom: 1px solid #ddd6fe;">
                                    <span style="color: #7c3aed; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px; font-weight: 600;">When</span>
                                    <br>
                                    <span style="color: #1e293b; font-size: 15px;">{{pickup_date}} at {{pickup_time}}</span>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 10px 0;">
                                    <span style="color: #7c3aed; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px; font-weight: 600;">Purpose</span>
                                    <br>
                                    <span style="color: #1e293b; font-size: 15px;">{{purpose}}</span>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
            
            <div style="background-color: #fef3c7; border-left: 4px solid #f59e0b; padding: 15px 20px; border-radius: 0 8px 8px 0; margin: 20px 0;">
                <p style="margin: 0; color: #92400e; font-size: 14px;">
                    <strong>⚠️ Important:</strong> Please be ready at the pickup location 10 minutes before the scheduled time.
                </p>
            </div>
        </td>
    </tr>
    <tr>
        <td style="padding: 0 40px 30px 40px; text-align: center;">
            <a href="{{approval_url}}" style="display: inline-block; padding: 14px 35px; background: linear-gradient(135deg, #7c3aed 0%, #8b5cf6 100%); color: #ffffff; text-decoration: none; font-size: 15px; font-weight: 600; border-radius: 8px; box-shadow: 0 4px 12px rgba(124, 58, 237, 0.35);">
                View Full Details
            </a>
        </td>
    </tr>
    <tr>
        <td style="background-color: #f8fafc; padding: 25px 40px; text-align: center; border-top: 1px solid #e2e8f0;">
            <p style="margin: 0 0 8px 0; color: #64748b; font-size: 14px; font-weight: 600;">{{company_name}}</p>
            <p style="margin: 0; color: #94a3b8; font-size: 12px;">
                &copy; {{year}} {{company_name}}. All rights reserved.
            </p>
        </td>
    </tr>
</table>
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
                    'company_name',
                    'year'
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
            } else {
                // Update existing template with new design
                $existing->update([
                    'subject' => $template['subject'],
                    'body' => $template['body'],
                    'variables' => $template['variables'],
                    'is_active' => $template['is_active'],
                    'updated_by' => 1,
                    'updated_at' => $now,
                ]);
            }
        }
    }
}
