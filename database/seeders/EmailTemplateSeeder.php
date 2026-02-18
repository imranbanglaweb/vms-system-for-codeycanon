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
            // Maintenance Requisition Created - sends to Department Head
            [
                'name' => 'Maintenance Requisition Created Notification',
                'slug' => 'maintenance-requisition-created',
                'subject' => 'New Maintenance Requisition: {{requisition_number}}',
                'body' => <<<'HTML'
<table role="presentation" cellpadding="0" cellspacing="0" style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; max-width: 650px; margin: 0 auto; width: 100%; background-color: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 10px 40px rgba(0,0,0,0.1);">
    <tr>
        <td style="background: #dc2626; background: linear-gradient(135deg, #dc2626 0%, #ef4444 100%); padding: 40px 40px; text-align: center;">
            <div style="margin-bottom: 15px;">
                <img src="{{admin_logo_url}}" alt="{{admin_title}}" width="80" style="max-width: 80px; height: auto; border-radius: 12px; display: inline-block;">
            </div>
            <h1 style="margin: 0 0 8px 0; color: #ffffff; font-size: 28px; font-weight: 700; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; text-shadow: 0 1px 2px rgba(0,0,0,0.1);">{{admin_title}}</h1>
            <p style="margin: 0; color: #ffffff; font-size: 14px; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; opacity: 0.9;">{{admin_description}}</p>
        </td>
    </tr>
    <tr>
        <td style="padding: 35px 40px;">
            <p style="margin: 0 0 25px 0; color: #1e293b; font-size: 18px; font-weight: 600; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">
                Dear {{head_name}},
            </p>
            
            <p style="margin: 0 0 25px 0; color: #475569; font-size: 15px; line-height: 1.7; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">
                A new maintenance requisition has been submitted from your department and requires your approval.
            </p>
            
            <div style="background: #fef2f2; border: 1px solid #fecaca; border-radius: 12px; padding: 20px; margin-bottom: 25px; border-left: 4px solid #dc2626;">
                <table role="presentation" cellpadding="0" cellspacing="0" style="width: 100%;">
                    <tr>
                        <td style="padding: 5px 0;">
                            <span style="color: #64748b; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px; font-weight: 600;">Requested By</span>
                            <br>
                            <span style="color: #0f172a; font-size: 16px; font-weight: 700;">{{requester_name}}</span>
                            <span style="color: #64748b; font-size: 13px; margin-left: 8px;">({{requester_email}})</span>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 8px 0 0 0;">
                            <span style="color: #64748b; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px; font-weight: 600;">Department</span>
                            <br>
                            <span style="color: #0f172a; font-size: 15px; font-weight: 600;">{{department_name}}</span>
                        </td>
                    </tr>
                </table>
            </div>
            
            <table role="presentation" cellpadding="0" cellspacing="0" style="width: 100%; border-collapse: collapse; margin: 20px 0; background-color: #f8fafc; border-radius: 12px; overflow: hidden; border: 1px solid #e2e8f0;">
                <tr>
                    <td style="padding: 18px 20px; border-bottom: 1px solid #e2e8f0; background-color: #f1f5f9;">
                        <span style="color: #64748b; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px; font-weight: 600;">Requisition Number</span>
                    </td>
                    <td style="padding: 18px 20px; border-bottom: 1px solid #e2e8f0; text-align: right;">
                        <span style="color: #dc2626; font-size: 16px; font-weight: 700;">{{requisition_number}}</span>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 18px 20px; border-bottom: 1px solid #e2e8f0;">
                        <span style="color: #64748b; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px; font-weight: 600;">Vehicle</span>
                    </td>
                    <td style="padding: 18px 20px; border-bottom: 1px solid #e2e8f0; text-align: right;">
                        <span style="color: #1e293b; font-size: 15px;">{{vehicle_name}}</span>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 18px 20px; border-bottom: 1px solid #e2e8f0;">
                        <span style="color: #64748b; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px; font-weight: 600;">Maintenance Type</span>
                    </td>
                    <td style="padding: 18px 20px; border-bottom: 1px solid #e2e8f0; text-align: right;">
                        <span style="color: #1e293b; font-size: 15px;">{{maintenance_type}}</span>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 18px 20px; border-bottom: 1px solid #e2e8f0;">
                        <span style="color: #64748b; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px; font-weight: 600;">Priority</span>
                    </td>
                    <td style="padding: 18px 20px; border-bottom: 1px solid #e2e8f0; text-align: right;">
                        <span style="color: #1e293b; font-size: 15px;">{{priority}}</span>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 18px 20px;">
                        <span style="color: #64748b; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px; font-weight: 600;">Description</span>
                    </td>
                    <td style="padding: 18px 20px; text-align: right;">
                        <span style="color: #1e293b; font-size: 15px;">{{description}}</span>
                    </td>
                </tr>
            </table>
            
            <table role="presentation" cellpadding="0" cellspacing="0" style="width: 100%; margin-top: 30px;">
                <tr>
                    <td style="text-align: center;">
                        <a href="{{approval_url}}" style="display: inline-block; padding: 16px 40px; background: #dc2626; background: linear-gradient(135deg, #dc2626 0%, #ef4444 100%); color: #ffffff; text-decoration: none; font-size: 15px; font-weight: 600; border-radius: 10px; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">Review & Approve Requisition</a>
                    </td>
                </tr>
            </table>
            
            <p style="margin: 30px 0 0 0; color: #64748b; font-size: 14px; text-align: center; line-height: 1.6; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">
                Please review the requisition details and take appropriate action within your department.
            </p>
        </td>
    </tr>
    <tr>
        <td style="background-color: #f8fafc; padding: 25px 40px; text-align: center; border-top: 1px solid #e2e8f0;">
            <p style="margin: 0 0 8px 0; color: #1e293b; font-size: 14px; font-weight: 600; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">{{company_name}}</p>
            <p style="margin: 0; color: #94a3b8; font-size: 12px; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">
                &copy; {{year}} {{company_name}}. All rights reserved.
            </p>
        </td>
    </tr>
</table>
HTML,
                'type' => 'maintenance_created',
                'variables' => json_encode([
                    'admin_title' => 'Company title from admin settings',
                    'admin_description' => 'Description from admin settings',
                    'admin_logo_url' => 'Logo URL from admin settings',
                    'company_name' => 'Company name from config',
                    'year' => 'Current year',
                    'requisition_number' => 'Unique identifier for the requisition',
                    'requester_name' => 'Name of person requesting maintenance',
                    'requester_email' => 'Email of requester',
                    'department_name' => 'Department requesting maintenance',
                    'vehicle_name' => 'Vehicle name or registration number',
                    'maintenance_type' => 'Type of maintenance required',
                    'priority' => 'Priority level',
                    'description' => 'Description of maintenance needed',
                    'head_name' => 'Name of department head',
                    'approval_url' => 'URL to approve requisition'
                ], JSON_PRETTY_PRINT),
                'is_active' => true,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            
            // Maintenance Department Approved - sends to Transport Head
            [
                'name' => 'Maintenance Department Approval Notification',
                'slug' => 'maintenance-department-approved',
                'subject' => 'Maintenance Approved by {{department_name}}: {{requisition_number}}',
                'body' => <<<'HTML'
<table role="presentation" cellpadding="0" cellspacing="0" style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; max-width: 650px; margin: 0 auto; width: 100%; background-color: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 10px 40px rgba(0,0,0,0.1);">
    <tr>
        <td style="background: #059669; background: linear-gradient(135deg, #059669 0%, #10b981 100%); padding: 40px 40px; text-align: center;">
            <div style="margin-bottom: 15px;">
                <img src="{{admin_logo_url}}" alt="{{admin_title}}" width="80" style="max-width: 80px; height: auto; border-radius: 12px; display: inline-block;">
            </div>
            <h1 style="margin: 0 0 8px 0; color: #ffffff; font-size: 28px; font-weight: 700; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; text-shadow: 0 1px 2px rgba(0,0,0,0.1);">{{admin_title}}</h1>
            <p style="margin: 0; color: #ffffff; font-size: 14px; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; opacity: 0.9;">{{admin_description}}</p>
        </td>
    </tr>
    <tr>
        <td style="padding: 35px 40px;">
            <div style="text-align: center; margin-bottom: 30px;">
                <div style="display: inline-block; width: 70px; height: 70px; background: #d1fae5; border-radius: 50%; line-height: 70px; font-size: 32px; margin-bottom: 15px;">&#10004;</div>
                <h2 style="margin: 0 0 10px 0; color: #059669; font-size: 24px; font-weight: 700; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">Department Approved</h2>
                <p style="margin: 0; color: #64748b; font-size: 15px; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">Ready for Maintenance Scheduling</p>
            </div>
            
            <p style="margin: 0 0 25px 0; color: #475569; font-size: 15px; line-height: 1.7; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">
                A maintenance requisition has been approved by <strong style="color: #059669;">{{department_name}}</strong> department and is now ready for maintenance scheduling.
            </p>
            
            <div style="background: #ecfdf5; border: 1px solid #6ee7b7; border-radius: 12px; padding: 20px; margin-bottom: 25px; border-left: 4px solid #10b981;">
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
                        <span style="color: #64748b; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px; font-weight: 600;">Vehicle</span>
                    </td>
                    <td style="padding: 18px 20px; border-bottom: 1px solid #e2e8f0; text-align: right;">
                        <span style="color: #1e293b; font-size: 15px;">{{vehicle_name}}</span>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 18px 20px; border-bottom: 1px solid #e2e8f0;">
                        <span style="color: #64748b; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px; font-weight: 600;">Maintenance Type</span>
                    </td>
                    <td style="padding: 18px 20px; border-bottom: 1px solid #e2e8f0; text-align: right;">
                        <span style="color: #1e293b; font-size: 15px;">{{maintenance_type}}</span>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 18px 20px;">
                        <span style="color: #64748b; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px; font-weight: 600;">Description</span>
                    </td>
                    <td style="padding: 18px 20px; text-align: right;">
                        <span style="color: #1e293b; font-size: 15px;">{{description}}</span>
                    </td>
                </tr>
            </table>
            
            <table role="presentation" cellpadding="0" cellspacing="0" style="width: 100%; margin-top: 30px;">
                <tr>
                    <td style="text-align: center;">
                        <a href="{{approval_url}}" style="display: inline-block; padding: 16px 40px; background: #059669; background: linear-gradient(135deg, #059669 0%, #10b981 100%); color: #ffffff; text-decoration: none; font-size: 15px; font-weight: 600; border-radius: 10px; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">Schedule Maintenance</a>
                    </td>
                </tr>
            </table>
            
            <p style="margin: 30px 0 0 0; color: #64748b; font-size: 14px; text-align: center; line-height: 1.6; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">
                Please schedule the maintenance work for this vehicle.
            </p>
        </td>
    </tr>
    <tr>
        <td style="background-color: #f8fafc; padding: 25px 40px; text-align: center; border-top: 1px solid #e2e8f0;">
            <p style="margin: 0 0 8px 0; color: #1e293b; font-size: 14px; font-weight: 600; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">{{company_name}}</p>
            <p style="margin: 0; color: #94a3b8; font-size: 12px; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">
                &copy; {{year}} {{company_name}}. All rights reserved.
            </p>
        </td>
    </tr>
</table>
HTML,
                'type' => 'maintenance_dept_approved',
                'variables' => json_encode([
                    'admin_title' => 'Company title from admin settings',
                    'admin_description' => 'Description from admin settings',
                    'admin_logo_url' => 'Logo URL from admin settings',
                    'company_name' => 'Company name from config',
                    'year' => 'Current year',
                    'requisition_number' => 'Unique identifier for the requisition',
                    'requester_name' => 'Name of person requesting maintenance',
                    'department_name' => 'Department requesting maintenance',
                    'vehicle_name' => 'Vehicle name or registration number',
                    'maintenance_type' => 'Type of maintenance required',
                    'description' => 'Description of maintenance needed',
                    'status' => 'Current status',
                    'approval_url' => 'URL to approve requisition',
                    'approved_by_name' => 'Name of person who approved'
                ], JSON_PRETTY_PRINT),
                'is_active' => true,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            
            // Maintenance Transport Approved - sends to Employee, Department Head and Transport Head
            [
                'name' => 'Maintenance Transport Approval Notification',
                'slug' => 'maintenance-transport-approved',
                'subject' => 'Maintenance Confirmed: {{requisition_number}}',
                'body' => <<<'HTML'
<table role="presentation" cellpadding="0" cellspacing="0" style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; max-width: 650px; margin: 0 auto; width: 100%; background-color: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 10px 40px rgba(0,0,0,0.1);">
    <tr>
        <td style="background: #7c3aed; background: linear-gradient(135deg, #7c3aed 0%, #8b5cf6 100%); padding: 40px 40px; text-align: center;">
            <div style="margin-bottom: 15px;">
                <img src="{{admin_logo_url}}" alt="{{admin_title}}" width="80" style="max-width: 80px; height: auto; border-radius: 12px; display: inline-block;">
            </div>
            <h1 style="margin: 0 0 8px 0; color: #ffffff; font-size: 28px; font-weight: 700; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; text-shadow: 0 1px 2px rgba(0,0,0,0.1);">{{admin_title}}</h1>
            <p style="margin: 0; color: #ffffff; font-size: 14px; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; opacity: 0.9;">{{admin_description}}</p>
        </td>
    </tr>
    <tr>
        <td style="padding: 35px 40px;">
            <div style="text-align: center; margin-bottom: 30px;">
                <div style="display: inline-block; width: 70px; height: 70px; background: #ede9fe; border-radius: 50%; line-height: 70px; font-size: 32px; margin-bottom: 15px;">&#127881;</div>
                <h2 style="margin: 0 0 10px 0; color: #7c3aed; font-size: 24px; font-weight: 700; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">Maintenance Confirmed!</h2>
                <p style="margin: 0; color: #64748b; font-size: 15px; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">Maintenance Scheduled</p>
            </div>
            
            <p style="margin: 0 0 25px 0; color: #475569; font-size: 15px; line-height: 1.7; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">
                Great news! Your maintenance requisition has been approved and scheduled.
            </p>
            
            <table role="presentation" cellpadding="0" cellspacing="0" style="width: 100%; border-collapse: collapse; margin: 20px 0; background: #f5f3ff; border-radius: 16px; overflow: hidden; border: 1px solid #ddd6fe;">
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
                                    <span style="color: #7c3aed; font-size: 11px; text-transform: uppercase; letter-spacing: 1px; font-weight: 700;">Vehicle</span>
                                    <br>
                                    <span style="color: #1e293b; font-size: 16px;">{{vehicle_name}}</span>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 12px 0; border-bottom: 1px solid #ddd6fe;">
                                    <span style="color: #7c3aed; font-size: 11px; text-transform: uppercase; letter-spacing: 1px; font-weight: 700;">Maintenance Type</span>
                                    <br>
                                    <span style="color: #1e293b; font-size: 16px;">{{maintenance_type}}</span>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 12px 0; border-bottom: 1px solid #ddd6fe;">
                                    <span style="color: #7c3aed; font-size: 11px; text-transform: uppercase; letter-spacing: 1px; font-weight: 700;">Scheduled Date</span>
                                    <br>
                                    <span style="color: #1e293b; font-size: 16px;">{{scheduled_date}}</span>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 12px 0; border-bottom: 1px solid #ddd6fe;">
                                    <span style="color: #7c3aed; font-size: 11px; text-transform: uppercase; letter-spacing: 1px; font-weight: 700;">Description</span>
                                    <br>
                                    <span style="color: #1e293b; font-size: 16px;">{{description}}</span>
                                </td>
                            </tr>
                            {{#if estimated_cost}}
                            <tr>
                                <td style="padding: 12px 0;">
                                    <span style="color: #7c3aed; font-size: 11px; text-transform: uppercase; letter-spacing: 1px; font-weight: 700;">Estimated Cost</span>
                                    <br>
                                    <span style="color: #1e293b; font-size: 16px;">{{estimated_cost}}</span>
                                </td>
                            </tr>
                            {{/if}}
                        </table>
                    </td>
                </tr>
            </table>
            
            <div style="background: #fef3c7; border: 1px solid #fcd34d; border-left: 4px solid #f59e0b; padding: 18px 22px; border-radius: 0 12px 12px 0; margin: 25px 0;">
                <p style="margin: 0; color: #92400e; font-size: 14px; line-height: 1.6; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">
                    <strong style="font-size: 15px;">&#9888; Important Reminder:</strong><br>
                    Please ensure the vehicle is available at the scheduled time for maintenance.
                </p>
            </div>
            
            <table role="presentation" cellpadding="0" cellspacing="0" style="width: 100%; margin-top: 30px;">
                <tr>
                    <td style="text-align: center;">
                        <a href="{{approval_url}}" style="display: inline-block; padding: 16px 40px; background: #7c3aed; background: linear-gradient(135deg, #7c3aed 0%, #8b5cf6 100%); color: #ffffff; text-decoration: none; font-size: 15px; font-weight: 600; border-radius: 10px; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">View Full Details</a>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td style="background-color: #f8fafc; padding: 25px 40px; text-align: center; border-top: 1px solid #e2e8f0;">
            <p style="margin: 0 0 8px 0; color: #1e293b; font-size: 14px; font-weight: 600; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">{{company_name}}</p>
            <p style="margin: 0; color: #94a3b8; font-size: 12px; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">
                &copy; {{year}} {{company_name}}. All rights reserved.
            </p>
        </td>
    </tr>
</table>
HTML,
                'type' => 'maintenance_transport_approved',
                'variables' => json_encode([
                    'admin_title' => 'Company title from admin settings',
                    'admin_description' => 'Description from admin settings',
                    'admin_logo_url' => 'Logo URL from admin settings',
                    'company_name' => 'Company name from config',
                    'year' => 'Current year',
                    'requisition_number' => 'Unique identifier for the requisition',
                    'requester_name' => 'Name of person requesting maintenance',
                    'department_name' => 'Department requesting maintenance',
                    'vehicle_name' => 'Vehicle name or registration number',
                    'maintenance_type' => 'Type of maintenance required',
                    'description' => 'Description of maintenance needed',
                    'scheduled_date' => 'Scheduled maintenance date',
                    'estimated_cost' => 'Estimated cost of maintenance',
                    'status' => 'Current status',
                    'approval_url' => 'URL to view requisition'
                ], JSON_PRETTY_PRINT),
                'is_active' => true,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            
            // Requisition Created - sends to Department Head
            [
                'name' => 'Requisition Created Notification',
                'slug' => 'requisition-created',
                'subject' => 'New Vehicle Requisition: {{requisition_number}}',
                'body' => <<<'HTML'
<table role="presentation" cellpadding="0" cellspacing="0" style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; max-width: 650px; margin: 0 auto; width: 100%; background-color: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 10px 40px rgba(0,0,0,0.1);">
    <tr>
        <td style="background: #1e3a5f; background: linear-gradient(135deg, #1e3a5f 0%, #2d5a87 100%); padding: 40px 40px; text-align: center;">
            <div style="margin-bottom: 15px;">
                <img src="{{admin_logo_url}}" alt="{{admin_title}}" width="80" style="max-width: 80px; height: auto; border-radius: 12px; display: inline-block;">
            </div>
            <h1 style="margin: 0 0 8px 0; color: #ffffff; font-size: 28px; font-weight: 700; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; text-shadow: 0 1px 2px rgba(0,0,0,0.1);">{{admin_title}}</h1>
            <p style="margin: 0; color: #ffffff; font-size: 14px; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; opacity: 0.9;">{{admin_description}}</p>
        </td>
    </tr>
    <tr>
        <td style="padding: 35px 40px;">
            <p style="margin: 0 0 25px 0; color: #1e293b; font-size: 18px; font-weight: 600; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">
                Dear {{head_name}},
            </p>
            
            <p style="margin: 0 0 25px 0; color: #475569; font-size: 15px; line-height: 1.7; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">
                A new vehicle requisition has been submitted from your department and requires your approval.
            </p>
            
            <div style="background: #f0f9ff; border: 1px solid #bae6fd; border-radius: 12px; padding: 20px; margin-bottom: 25px; border-left: 4px solid #0284c7;">
                <table role="presentation" cellpadding="0" cellspacing="0" style="width: 100%;">
                    <tr>
                        <td style="padding: 5px 0;">
                            <span style="color: #64748b; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px; font-weight: 600;">Requested By</span>
                            <br>
                            <span style="color: #0f172a; font-size: 16px; font-weight: 700;">{{requester_name}}</span>
                            <span style="color: #64748b; font-size: 13px; margin-left: 8px;">({{requester_email}})</span>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 8px 0 0 0;">
                            <span style="color: #64748b; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px; font-weight: 600;">Department</span>
                            <br>
                            <span style="color: #0f172a; font-size: 15px; font-weight: 600;">{{department_name}}</span>
                        </td>
                    </tr>
                </table>
            </div>
            
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
            
            <table role="presentation" cellpadding="0" cellspacing="0" style="width: 100%; margin-top: 30px;">
                <tr>
                    <td style="text-align: center;">
                        <a href="{{approval_url}}" style="display: inline-block; padding: 16px 40px; background: #3b82f6; background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); color: #ffffff; text-decoration: none; font-size: 15px; font-weight: 600; border-radius: 10px; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">Review & Approve Requisition</a>
                    </td>
                </tr>
            </table>
            
            <p style="margin: 30px 0 0 0; color: #64748b; font-size: 14px; text-align: center; line-height: 1.6; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">
                Please review the requisition details and take appropriate action within your department.
            </p>
        </td>
    </tr>
    <tr>
        <td style="background-color: #f8fafc; padding: 25px 40px; text-align: center; border-top: 1px solid #e2e8f0;">
            <p style="margin: 0 0 8px 0; color: #1e293b; font-size: 14px; font-weight: 600; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">{{company_name}}</p>
            <p style="margin: 0; color: #94a3b8; font-size: 12px; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">
                &copy; {{year}} {{company_name}}. All rights reserved.
            </p>
        </td>
    </tr>
</table>
HTML,
                'type' => EmailTemplate::TYPE_CREATED,
                'variables' => json_encode([
                    'admin_title' => 'Company title from admin settings',
                    'admin_description' => 'Description from admin settings',
                    'admin_logo_url' => 'Logo URL from admin settings',
                    'company_name' => 'Company name from config',
                    'year' => 'Current year',
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
                    'head_name' => 'Name of department head',
                    'approval_url' => 'URL to approve requisition'
                ], JSON_PRETTY_PRINT),
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
    <tr>
        <td style="background: #059669; background: linear-gradient(135deg, #059669 0%, #10b981 100%); padding: 40px 40px; text-align: center;">
            <div style="margin-bottom: 15px;">
                <img src="{{admin_logo_url}}" alt="{{admin_title}}" width="80" style="max-width: 80px; height: auto; border-radius: 12px; display: inline-block;">
            </div>
            <h1 style="margin: 0 0 8px 0; color: #ffffff; font-size: 28px; font-weight: 700; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; text-shadow: 0 1px 2px rgba(0,0,0,0.1);">{{admin_title}}</h1>
            <p style="margin: 0; color: #ffffff; font-size: 14px; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; opacity: 0.9;">{{admin_description}}</p>
        </td>
    </tr>
    <tr>
        <td style="padding: 35px 40px;">
            <div style="text-align: center; margin-bottom: 30px;">
                <div style="display: inline-block; width: 70px; height: 70px; background: #d1fae5; border-radius: 50%; line-height: 70px; font-size: 32px; margin-bottom: 15px;">&#10004;</div>
                <h2 style="margin: 0 0 10px 0; color: #059669; font-size: 24px; font-weight: 700; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">Department Approved</h2>
                <p style="margin: 0; color: #64748b; font-size: 15px; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">Ready for Transport Assignment</p>
            </div>
            
            <p style="margin: 0 0 25px 0; color: #475569; font-size: 15px; line-height: 1.7; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">
                A requisition has been approved by <strong style="color: #059669;">{{department_name}}</strong> department and is now ready for vehicle and driver assignment.
            </p>
            
            <div style="background: #ecfdf5; border: 1px solid #6ee7b7; border-radius: 12px; padding: 20px; margin-bottom: 25px; border-left: 4px solid #10b981;">
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
                        <span style="color: #1e293b; font-size: 15px;">{{pickup_location}} to {{dropoff_location}}</span>
                        <br>
                        <span style="color: #64748b; font-size: 13px;">{{pickup_date}} at {{pickup_time}}</span>
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
            
            <table role="presentation" cellpadding="0" cellspacing="0" style="width: 100%; margin-top: 30px;">
                <tr>
                    <td style="text-align: center;">
                        <a href="{{approval_url}}" style="display: inline-block; padding: 16px 40px; background: #059669; background: linear-gradient(135deg, #059669 0%, #10b981 100%); color: #ffffff; text-decoration: none; font-size: 15px; font-weight: 600; border-radius: 10px; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">Assign Vehicle & Driver</a>
                    </td>
                </tr>
            </table>
            
            <p style="margin: 30px 0 0 0; color: #64748b; font-size: 14px; text-align: center; line-height: 1.6; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">
                Please assign a vehicle and driver to complete this requisition.
            </p>
        </td>
    </tr>
    <tr>
        <td style="background-color: #f8fafc; padding: 25px 40px; text-align: center; border-top: 1px solid #e2e8f0;">
            <p style="margin: 0 0 8px 0; color: #1e293b; font-size: 14px; font-weight: 600; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">{{company_name}}</p>
            <p style="margin: 0; color: #94a3b8; font-size: 12px; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">
                &copy; {{year}} {{company_name}}. All rights reserved.
            </p>
        </td>
    </tr>
</table>
HTML,
                'type' => EmailTemplate::TYPE_DEPT_APPROVED,
                'variables' => json_encode([
                    'admin_title' => 'Company title from admin settings',
                    'admin_description' => 'Description from admin settings',
                    'admin_logo_url' => 'Logo URL from admin settings',
                    'company_name' => 'Company name from config',
                    'year' => 'Current year',
                    'requisition_number' => 'Unique identifier for the requisition',
                    'requester_name' => 'Name of person requesting vehicle',
                    'department_name' => 'Department requesting vehicle',
                    'pickup_location' => 'Location where vehicle pickup',
                    'dropoff_location' => 'Location for vehicle drop-off',
                    'pickup_date' => 'Date of pickup',
                    'pickup_time' => 'Time of pickup',
                    'purpose' => 'Purpose of requisition',
                    'status' => 'Current status',
                    'approval_url' => 'URL to approve requisition',
                    'approved_by_name' => 'Name of person who approved'
                ], JSON_PRETTY_PRINT),
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
    <tr>
        <td style="background: #7c3aed; background: linear-gradient(135deg, #7c3aed 0%, #8b5cf6 100%); padding: 40px 40px; text-align: center;">
            <div style="margin-bottom: 15px;">
                <img src="{{admin_logo_url}}" alt="{{admin_title}}" width="80" style="max-width: 80px; height: auto; border-radius: 12px; display: inline-block;">
            </div>
            <h1 style="margin: 0 0 8px 0; color: #ffffff; font-size: 28px; font-weight: 700; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; text-shadow: 0 1px 2px rgba(0,0,0,0.1);">{{admin_title}}</h1>
            <p style="margin: 0; color: #ffffff; font-size: 14px; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; opacity: 0.9;">{{admin_description}}</p>
        </td>
    </tr>
    <tr>
        <td style="padding: 35px 40px;">
            <div style="text-align: center; margin-bottom: 30px;">
                <div style="display: inline-block; width: 70px; height: 70px; background: #ede9fe; border-radius: 50%; line-height: 70px; font-size: 32px; margin-bottom: 15px;">&#127881;</div>
                <h2 style="margin: 0 0 10px 0; color: #7c3aed; font-size: 24px; font-weight: 700; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">Requisition Confirmed!</h2>
                <p style="margin: 0; color: #64748b; font-size: 15px; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">Vehicle & Driver Assigned</p>
            </div>
            
            <p style="margin: 0 0 25px 0; color: #475569; font-size: 15px; line-height: 1.7; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">
                Great news! Your vehicle requisition has been approved and a vehicle has been assigned. Please be ready at the pickup location at the scheduled time.
            </p>
            
            <table role="presentation" cellpadding="0" cellspacing="0" style="width: 100%; border-collapse: collapse; margin: 20px 0; background: #f5f3ff; border-radius: 16px; overflow: hidden; border: 1px solid #ddd6fe;">
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
            
            <div style="background: #fef3c7; border: 1px solid #fcd34d; border-left: 4px solid #f59e0b; padding: 18px 22px; border-radius: 0 12px 12px 0; margin: 25px 0;">
                <p style="margin: 0; color: #92400e; font-size: 14px; line-height: 1.6; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">
                    <strong style="font-size: 15px;">&#9888; Important Reminder:</strong><br>
                    Please be ready at the pickup location <strong>10 minutes before</strong> the scheduled time. Contact your driver if you have any questions.
                </p>
            </div>
            
            <table role="presentation" cellpadding="0" cellspacing="0" style="width: 100%; margin-top: 30px;">
                <tr>
                    <td style="text-align: center;">
                        <a href="{{approval_url}}" style="display: inline-block; padding: 16px 40px; background: #7c3aed; background: linear-gradient(135deg, #7c3aed 0%, #8b5cf6 100%); color: #ffffff; text-decoration: none; font-size: 15px; font-weight: 600; border-radius: 10px; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">View Full Details</a>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td style="background-color: #f8fafc; padding: 25px 40px; text-align: center; border-top: 1px solid #e2e8f0;">
            <p style="margin: 0 0 8px 0; color: #1e293b; font-size: 14px; font-weight: 600; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">{{company_name}}</p>
            <p style="margin: 0; color: #94a3b8; font-size: 12px; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">
                &copy; {{year}} {{company_name}}. All rights reserved.
            </p>
        </td>
    </tr>
</table>
HTML,
                'type' => EmailTemplate::TYPE_TRANSPORT_APPROVED,
                'variables' => json_encode([
                    'admin_title' => 'Company title from admin settings',
                    'admin_description' => 'Description from admin settings',
                    'admin_logo_url' => 'Logo URL from admin settings',
                    'company_name' => 'Company name from config',
                    'year' => 'Current year',
                    'requisition_number' => 'Unique identifier for the requisition',
                    'requester_name' => 'Name of person requesting vehicle',
                    'department_name' => 'Department requesting vehicle',
                    'pickup_location' => 'Location where vehicle pickup',
                    'dropoff_location' => 'Location for vehicle drop-off',
                    'pickup_date' => 'Date of pickup',
                    'pickup_time' => 'Time of pickup',
                    'purpose' => 'Purpose of requisition',
                    'passengers' => 'Number of passengers',
                    'status' => 'Current status',
                    'approval_url' => 'URL to approve requisition',
                    'vehicle_assigned' => 'Assigned vehicle name',
                    'driver_assigned' => 'Assigned driver name',
                    'driver_phone' => 'Driver contact number'
                ], JSON_PRETTY_PRINT),
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
                // Update existing template
                $existing->update($template);
            }
        }
    }
}
