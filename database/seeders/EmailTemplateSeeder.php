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
<table role="presentation" cellpadding="0" cellspacing="0" style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; max-width: 650px; margin: 0 auto; width: 100%; background-color: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 10px 40px rgba(0,0,0,0.1);">
    {{-- HEADER with Admin Settings --}}
    <tr>
        <td style="background: linear-gradient(135deg, #1e3a5f 0%, #2d5a87 100%); padding: 35px 40px; text-align: center;">
            {{-- Admin Logo --}}
            <div style="margin-bottom: 15px;">
                <img src="{{admin_logo_url}}" alt="{{admin_title}}" style="max-width: 80px; max-height: 80px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.2);">
            </div>
            {{-- Admin Title --}}
            <h1 style="margin: 0 0 8px 0; color: #ffffff; font-size: 26px; font-weight: 700;">{{admin_title}}</h1>
            {{-- Admin Description --}}
            <p style="margin: 0; color: rgba(255,255,255,0.85); font-size: 14px;">{{admin_description}}</p>
        </td>
    </tr>
    {{-- MAIN CONTENT --}}
    <tr>
        <td style="padding: 35px 40px;">
            {{-- Greeting --}}
            <p style="margin: 0 0 25px 0; color: #1e293b; font-size: 18px; font-weight: 600;">
                Dear {{ head_name ?? 'Department Head' }},
            </p>
            
            <p style="margin: 0 0 25px 0; color: #475569; font-size: 15px; line-height: 1.7;">
                A new vehicle requisition has been submitted from your department and requires your approval.
            </p>
            
            {{-- Requester Info Badge --}}
            <div style="background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%); border-radius: 12px; padding: 20px; margin-bottom: 25px; border-left: 4px solid #0ea5e9;">
                <table role="presentation" cellpadding="0" cellspacing="0" style="width: 100%;">
                    <tr>
                        <td style="padding: 5px 0;">
                            <span style="color: #64748b; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px;">Requested By</span>
                            <br>
                            <span style="color: #0f172a; font-size: 16px; font-weight: 700;">{{requester_name}}</span>
                            <span style="color: #94a3b8; font-size: 13px; margin-left: 8px;">({{requester_email}})</span>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 8px 0 0 0;">
                            <span style="color: #64748b; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px;">Department</span>
                            <br>
                            <span style="color: #0f172a; font-size: 15px; font-weight: 600;">{{department_name}}</span>
                        </td>
                    </tr>
                </table>
            </div>
            
            {{-- Requisition Details --}}
            <table role="presentation" cellpadding="0" cellspacing="0" style="width: 100%; border-collapse: collapse; margin: 20px 0; background-color: #f8fafc; border-radius: 12px; overflow: hidden; border: 1px solid #e2e8f0;">
                <tr>
                    <td style="padding: 18px 20px; border-bottom: 1px solid #e2e8f0; background-color: #f1f5f9;">
                        <span style="color: #64748b; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px; font-weight: 600;">Requisition Number</span>
                    </td>
                    <td style="padding: 18px 20px; border-bottom: 1px solid #e2e8f0; text-align: right;">
                        <span style="color: #1e40af; font-size: 16px; font-weight: 700;">{{requisition_number}}</span>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 18px 20px; border-bottom: 1px solid #e2e8f0;">
                        <span style="color: #64748b; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px; font-weight: 600;">Pickup Location</span>
                    </td>
                    <td style="padding: 18px 20px; border-bottom: 1px solid #e2e8f0; text-align: right;">
                        <span style="color: #1e293b; font-size: 15px;">{{pickup_location}}</span>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 18px 20px; border-bottom: 1px solid #e2e8f0;">
                        <span style="color: #64748b; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px; font-weight: 600;">Drop-off Location</span>
                    </td>
                    <td style="padding: 18px 20px; border-bottom: 1px solid #e2e8f0; text-align: right;">
                        <span style="color: #1e293b; font-size: 15px;">{{dropoff_location}}</span>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 18px 20px; border-bottom: 1px solid #e2e8f0;">
                        <span style="color: #64748b; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px; font-weight: 600;">Date & Time</span>
                    </td>
                    <td style="padding: 18px 20px; border-bottom: 1px solid #e2e8f0; text-align: right;">
                        <span style="color: #1e293b; font-size: 15px;">{{pickup_date}} at {{pickup_time}}</span>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 18px 20px; border-bottom: 1px solid #e2e8f0;">
                        <span style="color: #64748b; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px; font-weight: 600;">Purpose</span>
                    </td>
                    <td style="padding: 18px 20px; border-bottom: 1px solid #e2e8f0; text-align: right;">
                        <span style="color: #1e293b; font-size: 15px;">{{purpose}}</span>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 18px 20px;">
                        <span style="color: #64748b; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px; font-weight: 600;">Passengers</span>
                    </td>
                    <td style="padding: 18px 20px; text-align: right;">
                        <span style="color: #1e293b; font-size: 15px;">{{passengers}} passengers</span>
                    </td>
                </tr>
            </table>
            
            {{-- CTA Button --}}
            <table role="presentation" cellpadding="0" cellspacing="0" style="width: 100%; margin-top: 30px;">
                <tr>
                    <td style="text-align: center;">
                        <a href="{{approval_url}}" style="display: inline-block; padding: 16px 40px; background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); color: #ffffff; text-decoration: none; font-size: 15px; font-weight: 600; border-radius: 10px; box-shadow: 0 6px 20px rgba(59, 130, 246, 0.4);">
                            Review & Approve Requisition
                        </a>
                    </td>
                </tr>
            </table>
            
            <p style="margin: 30px 0 0 0; color: #64748b; font-size: 14px; text-align: center; line-height: 1.6;">
                Please review the requisition details and take appropriate action within your department.
            </p>
        </td>
    </tr>
    {{-- FOOTER --}}
    <tr>
        <td style="background-color: #f8fafc; padding: 25px 40px; text-align: center; border-top: 1px solid #e2e8f0;">
            <p style="margin: 0 0 8px 0; color: #1e293b; font-size: 14px; font-weight: 600;">{{company_name}}</p>
            <p style="margin: 0; color: #94a3b8; font-size: 12px;">
                &copy; {{year}} {{company_name}}. All rights reserved.
            </p>
        </td>
    </tr>
</table>
HTML,
                'type' => EmailTemplate::TYPE_CREATED,
                'variables' => json_encode([
                    'greeting' => 'Dear @@head_name,',
                    'content_text' => 'A new vehicle requisition has been submitted from your department and requires your approval.',
                    'footer_text' => 'Please review the requisition details and take appropriate action within your department.',
                    'requisition_number' => 'Unique identifier for the requisition',
                    'requester_name' => 'Name of person requesting vehicle',
                    'requester_email' => 'Email of requester',
                    'department_name' => 'Department requesting vehicle',
                    'pickup_location' => 'Location where vehicle pickup',
                    'dropoff_location' => 'Location for vehicle drop-off',
                    'pickup_date' => 'Date of pickup',
                    'pickup_time' => 'Time of pickup',
                    'purpose' => 'Purpose of requisition',
                    'passengers' => 'Number of passengers',
                    'admin_logo_url' => 'Logo URL from admin settings',
                    'admin_title' => 'Company title from admin settings',
                    'company_name' => 'Company name from admin settings',
                    'year' => 'Current year',
                    'approval_url' => 'URL to approve requisition',
                    'head_name' => 'Name of department head'
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
                'subject' => 'Requisition Approved by {{department_name}}: {{requisition_number}}',
                'body' => <<<'HTML'
<table role="presentation" cellpadding="0" cellspacing="0" style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; max-width: 650px; margin: 0 auto; width: 100%; background-color: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 10px 40px rgba(0,0,0,0.1);">
    {{-- HEADER with Admin Settings --}}
    <tr>
        <td style="background: linear-gradient(135deg, #059669 0%, #10b981 100%); padding: 35px 40px; text-align: center;">
            {{-- Admin Logo --}}
            <div style="margin-bottom: 15px;">
                <img src="{{admin_logo_url}}" alt="{{admin_title}}" style="max-width: 80px; max-height: 80px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.2);">
            </div>
            {{-- Admin Title --}}
            <h1 style="margin: 0 0 8px 0; color: #ffffff; font-size: 26px; font-weight: 700;">{{admin_title}}</h1>
            {{-- Admin Description --}}
            <p style="margin: 0; color: rgba(255,255,255,0.85); font-size: 14px;">{{admin_description}}</p>
        </td>
    </tr>
    {{-- MAIN CONTENT --}}
    <tr>
        <td style="padding: 35px 40px;">
            {{-- Success Header --}}
            <div style="text-align: center; margin-bottom: 30px;">
                <div style="display: inline-block; width: 70px; height: 70px; background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%); border-radius: 50%; line-height: 70px; font-size: 32px; margin-bottom: 15px;">&#10004;</div>
                <h2 style="margin: 0 0 10px 0; color: #059669; font-size: 24px; font-weight: 700;">Department Approved</h2>
                <p style="margin: 0; color: #64748b; font-size: 15px;">Ready for Transport Assignment</p>
            </div>
            
            <p style="margin: 0 0 25px 0; color: #475569; font-size: 15px; line-height: 1.7;">
                A requisition has been approved by <strong style="color: #059669;">{{department_name}}</strong> department and is now ready for vehicle and driver assignment.
            </p>
            
            {{-- Approval Info Badge --}}
            <div style="background: linear-gradient(135deg, #ecfdf5 0%, #d1fae5 100%); border-radius: 12px; padding: 20px; margin-bottom: 25px; border-left: 4px solid #10b981;">
                <table role="presentation" cellpadding="0" cellspacing="0" style="width: 100%;">
                    <tr>
                        <td style="padding: 5px 0;">
                            <span style="color: #059669; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px; font-weight: 600;">Approved By</span>
                            <br>
                            <span style="color: #0f172a; font-size: 16px; font-weight: 700;">{{approved_by_name}}</span>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 8px 0 0 0;">
                            <span style="color: #059669; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px; font-weight: 600;">Department</span>
                            <br>
                            <span style="color: #0f172a; font-size: 15px; font-weight: 600;">{{department_name}}</span>
                        </td>
                    </tr>
                </table>
            </div>
            
            {{-- Requisition Details --}}
            <table role="presentation" cellpadding="0" cellspacing="0" style="width: 100%; border-collapse: collapse; margin: 20px 0; background-color: #f8fafc; border-radius: 12px; overflow: hidden; border: 1px solid #e2e8f0;">
                <tr>
                    <td style="padding: 18px 20px; border-bottom: 1px solid #e2e8f0; background-color: #f1f5f9;">
                        <span style="color: #64748b; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px; font-weight: 600;">Requisition Number</span>
                    </td>
                    <td style="padding: 18px 20px; border-bottom: 1px solid #e2e8f0; text-align: right;">
                        <span style="color: #059669; font-size: 16px; font-weight: 700;">{{requisition_number}}</span>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 18px 20px; border-bottom: 1px solid #e2e8f0;">
                        <span style="color: #64748b; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px; font-weight: 600;">Requested By</span>
                    </td>
                    <td style="padding: 18px 20px; border-bottom: 1px solid #e2e8f0; text-align: right;">
                        <span style="color: #1e293b; font-size: 15px;">{{requester_name}}</span>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 18px 20px; border-bottom: 1px solid #e2e8f0;">
                        <span style="color: #64748b; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px; font-weight: 600;">Trip Details</span>
                    </td>
                    <td style="padding: 18px 20px; border-bottom: 1px solid #e2e8f0; text-align: right;">
                        <span style="color: #1e293b; font-size: 15px;">{{pickup_location}} &rarr; {{dropoff_location}}</span>
                        <br>
                        <span style="color: #94a3b8; font-size: 13px;">{{pickup_date}} at {{pickup_time}}</span>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 18px 20px;">
                        <span style="color: #64748b; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px; font-weight: 600;">Purpose</span>
                    </td>
                    <td style="padding: 18px 20px; text-align: right;">
                        <span style="color: #1e293b; font-size: 15px;">{{purpose}}</span>
                    </td>
                </tr>
            </table>
            
            {{-- CTA Button --}}
            <table role="presentation" cellpadding="0" cellspacing="0" style="width: 100%; margin-top: 30px;">
                <tr>
                    <td style="text-align: center;">
                        <a href="{{approval_url}}" style="display: inline-block; padding: 16px 40px; background: linear-gradient(135deg, #059669 0%, #10b981 100%); color: #ffffff; text-decoration: none; font-size: 15px; font-weight: 600; border-radius: 10px; box-shadow: 0 6px 20px rgba(5, 150, 105, 0.4);">
                            Assign Vehicle & Driver
                        </a>
                    </td>
                </tr>
            </table>
            
            <p style="margin: 30px 0 0 0; color: #64748b; font-size: 14px; text-align: center; line-height: 1.6;">
                Please assign a vehicle and driver to complete this requisition.
            </p>
        </td>
    </tr>
    {{-- FOOTER --}}
    <tr>
        <td style="background-color: #f8fafc; padding: 25px 40px; text-align: center; border-top: 1px solid #e2e8f0;">
            <p style="margin: 0 0 8px 0; color: #1e293b; font-size: 14px; font-weight: 600;">{{company_name}}</p>
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
                    'year',
                    'approved_by_name',
                    'approved_by_email',
                    'admin_title',
                    'admin_description',
                    'admin_logo_url'
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
                'subject' => 'Requisition Confirmed: {{requisition_number}}',
                'body' => <<<'HTML'
<table role="presentation" cellpadding="0" cellspacing="0" style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; max-width: 650px; margin: 0 auto; width: 100%; background-color: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 10px 40px rgba(0,0,0,0.1);">
    {{-- HEADER with Admin Settings --}}
    <tr>
        <td style="background: linear-gradient(135deg, #7c3aed 0%, #8b5cf6 100%); padding: 35px 40px; text-align: center;">
            {{-- Admin Logo --}}
            <div style="margin-bottom: 15px;">
                <img src="{{admin_logo_url}}" alt="{{admin_title}}" style="max-width: 80px; max-height: 80px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.2);">
            </div>
            {{-- Admin Title --}}
            <h1 style="margin: 0 0 8px 0; color: #ffffff; font-size: 26px; font-weight: 700;">{{admin_title}}</h1>
            {{-- Admin Description --}}
            <p style="margin: 0; color: rgba(255,255,255,0.85); font-size: 14px;">{{admin_description}}</p>
        </td>
    </tr>
    {{-- MAIN CONTENT --}}
    <tr>
        <td style="padding: 35px 40px;">
            {{-- Success Header --}}
            <div style="text-align: center; margin-bottom: 30px;">
                <div style="display: inline-block; width: 70px; height: 70px; background: linear-gradient(135deg, #ede9fe 0%, #ddd6fe 100%); border-radius: 50%; line-height: 70px; font-size: 32px; margin-bottom: 15px;">&#127881;</div>
                <h2 style="margin: 0 0 10px 0; color: #7c3aed; font-size: 24px; font-weight: 700;">Requisition Confirmed!</h2>
                <p style="margin: 0; color: #64748b; font-size: 15px;">Vehicle & Driver Assigned</p>
            </div>
            
            <p style="margin: 0 0 25px 0; color: #475569; font-size: 15px; line-height: 1.7;">
                Great news! Your vehicle requisition has been approved and a vehicle has been assigned. Please be ready at the pickup location at the scheduled time.
            </p>
            
            {{-- Trip Details Card --}}
            <table role="presentation" cellpadding="0" cellspacing="0" style="width: 100%; border-collapse: collapse; margin: 20px 0; background: linear-gradient(135deg, #f5f3ff 0%, #ede9fe 100%); border-radius: 16px; overflow: hidden; border: 1px solid #ddd6fe;">
                <tr>
                    <td style="padding: 25px;">
                        <table role="presentation" cellpadding="0" cellspacing="0" style="width: 100%;">
                            <tr>
                                <td style="padding: 12px 0; border-bottom: 1px solid #ddd6fe;">
                                    <span style="color: #7c3aed; font-size: 11px; text-transform: uppercase; letter-spacing: 1px; font-weight: 700;">Requisition #</span>
                                    <br>
                                    <span style="color: #1e293b; font-size: 20px; font-weight: 700;">{{requisition_number}}</span>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 12px 0; border-bottom: 1px solid #ddd6fe;">
                                    <span style="color: #7c3aed; font-size: 11px; text-transform: uppercase; letter-spacing: 1px; font-weight: 700;">From</span>
                                    <br>
                                    <span style="color: #1e293b; font-size: 16px;">{{pickup_location}}</span>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 12px 0; border-bottom: 1px solid #ddd6fe;">
                                    <span style="color: #7c3aed; font-size: 11px; text-transform: uppercase; letter-spacing: 1px; font-weight: 700;">To</span>
                                    <br>
                                    <span style="color: #1e293b; font-size: 16px;">{{dropoff_location}}</span>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 12px 0; border-bottom: 1px solid #ddd6fe;">
                                    <span style="color: #7c3aed; font-size: 11px; text-transform: uppercase; letter-spacing: 1px; font-weight: 700;">When</span>
                                    <br>
                                    <span style="color: #1e293b; font-size: 16px;">{{pickup_date}} at {{pickup_time}}</span>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 12px 0; border-bottom: 1px solid #ddd6fe;">
                                    <span style="color: #7c3aed; font-size: 11px; text-transform: uppercase; letter-spacing: 1px; font-weight: 700;">Purpose</span>
                                    <br>
                                    <span style="color: #1e293b; font-size: 16px;">{{purpose}}</span>
                                </td>
                            </tr>
                            {{#if vehicle_assigned}}
                            <tr>
                                <td style="padding: 12px 0; border-bottom: 1px solid #ddd6fe;">
                                    <span style="color: #7c3aed; font-size: 11px; text-transform: uppercase; letter-spacing: 1px; font-weight: 700;">Vehicle</span>
                                    <br>
                                    <span style="color: #1e293b; font-size: 16px;">{{vehicle_assigned}}</span>
                                </td>
                            </tr>
                            {{/if}}
                            {{#if driver_assigned}}
                            <tr>
                                <td style="padding: 12px 0; border-bottom: 1px solid #ddd6fe;">
                                    <span style="color: #7c3aed; font-size: 11px; text-transform: uppercase; letter-spacing: 1px; font-weight: 700;">Driver</span>
                                    <br>
                                    <span style="color: #1e293b; font-size: 16px;">{{driver_assigned}}</span>
                                </td>
                            </tr>
                            {{/if}}
                            {{#if driver_phone}}
                            <tr>
                                <td style="padding: 12px 0;">
                                    <span style="color: #7c3aed; font-size: 11px; text-transform: uppercase; letter-spacing: 1px; font-weight: 700;">Driver Contact</span>
                                    <br>
                                    <span style="color: #1e293b; font-size: 16px;">{{driver_phone}}</span>
                                </td>
                            </tr>
                            {{/if}}
                        </table>
                    </td>
                </tr>
            </table>
            
            {{-- Important Notice --}}
            <div style="background-color: #fef3c7; border-left: 4px solid #f59e0b; padding: 18px 22px; border-radius: 0 12px 12px 0; margin: 25px 0;">
                <p style="margin: 0; color: #92400e; font-size: 14px; line-height: 1.6;">
                    <strong style="font-size: 15px;">&#9888; Important Reminder:</strong><br>
                    Please be ready at the pickup location <strong>10 minutes before</strong> the scheduled time. Contact your driver if you have any questions.
                </p>
            </div>
            
            {{-- CTA Button --}}
            <table role="presentation" cellpadding="0" cellspacing="0" style="width: 100%; margin-top: 30px;">
                <tr>
                    <td style="text-align: center;">
                        <a href="{{approval_url}}" style="display: inline-block; padding: 16px 40px; background: linear-gradient(135deg, #7c3aed 0%, #8b5cf6 100%); color: #ffffff; text-decoration: none; font-size: 15px; font-weight: 600; border-radius: 10px; box-shadow: 0 6px 20px rgba(124, 58, 237, 0.4);">
                            View Full Details
                        </a>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    {{-- FOOTER --}}
    <tr>
        <td style="background-color: #f8fafc; padding: 25px 40px; text-align: center; border-top: 1px solid #e2e8f0;">
            <p style="margin: 0 0 8px 0; color: #1e293b; font-size: 14px; font-weight: 600;">{{company_name}}</p>
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
                    'year',
                    'vehicle_assigned',
                    'driver_assigned',
                    'driver_phone',
                    'admin_title',
                    'admin_description',
                    'admin_logo_url'
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
                    'name' => $template['name'],
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
