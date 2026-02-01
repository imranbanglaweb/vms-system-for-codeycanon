<?php

namespace App\Services;

use App\Models\EmailLog;
use App\Models\EmailTemplate;
use App\Models\Requisition;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Database\Eloquent\Model;

/**
 * EmailService - Handles dynamic email notifications for requisition workflow
 * 
 * This service is used by:
 * - SendRequisitionStatusEmail listener
 * - DepartmentApprovalController
 * - TransportApprovalController
 * - RequisitionObserver
 */
class EmailService
{
    /**
     * @var \Illuminate\Contracts\Mail\Mailer
     */
    protected $mailer;

    /**
     * @var EmailTemplate
     */
    protected $emailTemplate;

    /**
     * @var EmailLog
     */
    protected $emailLog;

    /**
     * Create a new EmailService instance
     *
     * @param \Illuminate\Contracts\Mail\Mailer $mailer
     * @param EmailTemplate $emailTemplate
     * @param EmailLog $emailLog
     */
    public function __construct(
        \Illuminate\Contracts\Mail\Mailer $mailer,
        EmailTemplate $emailTemplate,
        EmailLog $emailLog
    ) {
        $this->mailer = $mailer;
        $this->emailTemplate = $emailTemplate;
        $this->emailLog = $emailLog;
    }

    /**
     * Send email when requisition is created (to Department Head)
     *
     * @param Requisition $requisition
     * @param string|null $customEmail Optional custom email recipient
     * @return bool
     */
    public function sendRequisitionCreated(Requisition $requisition, ?string $customEmail = null): bool
    {
        // If custom email is provided, use it instead of default recipients
        if (!empty($customEmail)) {
            $recipients = [$customEmail];
        } else {
            $recipients = $this->getRecipients('created', $requisition);
        }
        
        if (empty($recipients)) {
            Log::warning('EmailService: No recipients found for requisition created notification', [
                'requisition_id' => $requisition->id,
                'custom_email' => $customEmail
            ]);
            return false;
        }

        $data = $this->prepareTemplateData($requisition);
        $data['status'] = 'Pending';

        return $this->sendTemplatedEmail(
            EmailTemplate::TYPE_CREATED,
            $recipients,
            $data
        );
    }

    /**
     * Send email when Department Head approves (to Transport Head)
     *
     * @param Requisition $requisition
     * @return bool
     */
    public function sendDepartmentApproved(Requisition $requisition): bool
    {
        $recipients = $this->getRecipients('dept_approved', $requisition);
        
        if (empty($recipients)) {
            Log::warning('EmailService: No recipients found for department approved notification', [
                'requisition_id' => $requisition->id
            ]);
            return false;
        }

        $data = $this->prepareTemplateData($requisition);
        $data['status'] = 'Department Approved';

        return $this->sendTemplatedEmail(
            EmailTemplate::TYPE_DEPT_APPROVED,
            $recipients,
            $data
        );
    }

    /**
     * Send email when Transport approves (to Requester, Driver, Transport Head)
     *
     * @param Requisition $requisition
     * @return bool
     */
    public function sendTransportApproved(Requisition $requisition): bool
    {
        $recipients = $this->getRecipients('transport_approved', $requisition);
        
        if (empty($recipients)) {
            Log::warning('EmailService: No recipients found for transport approved notification', [
                'requisition_id' => $requisition->id
            ]);
            return false;
        }

        $data = $this->prepareTemplateData($requisition);
        $data['status'] = 'Transport Approved';

        return $this->sendTemplatedEmail(
            EmailTemplate::TYPE_TRANSPORT_APPROVED,
            $recipients,
            $data
        );
    }

    /**
     * Generic method for sending templated emails
     *
     * @param string $templateType
     * @param array $recipients
     * @param array $data
     * @return bool
     */
    public function sendTemplatedEmail(string $templateType, array $recipients, array $data): bool
    {
        $template = $this->getTemplate($templateType);

        if (!$template) {
            $this->logEmail(
                null,
                implode(', ', $recipients),
                'Template Not Found',
                'Template type: ' . $templateType,
                EmailLog::STATUS_FAILED
            );
            Log::error('EmailService: Email template not found', ['type' => $templateType]);
            return false;
        }

        $rendered = $this->renderTemplate($template, $data);
        $subject = $rendered['subject'];
        $body = $rendered['body'];

        $success = true;

        foreach ($recipients as $recipient) {
            try {
                $this->mailer->to($recipient)->send(new \App\Mail\GenericMailable($subject, $body));
                
                $this->logEmail(
                    $template->id,
                    $recipient,
                    $subject,
                    $body,
                    EmailLog::STATUS_SENT
                );
            } catch (\Exception $e) {
                $success = false;
                
                $this->logEmail(
                    $template->id,
                    $recipient,
                    $subject,
                    $body,
                    EmailLog::STATUS_FAILED
                );

                Log::error('EmailService: Failed to send email', [
                    'recipient' => $recipient,
                    'template_type' => $templateType,
                    'error' => $e->getMessage()
                ]);
            }
        }

        return $success;
    }

    /**
     * Find active template by type
     *
     * @param string $type
     * @param bool $isActive
     * @return EmailTemplate|null
     */
    public function getTemplate(string $type, bool $isActive = true): ?EmailTemplate
    {
        $query = EmailTemplate::where('type', $type);

        if ($isActive) {
            $query->where('is_active', true);
        }

        return $query->first();
    }

    /**
     * Replace template variables with data
     *
     * @param EmailTemplate $template
     * @param array $data
     * @return array
     */
    public function renderTemplate(EmailTemplate $template, array $data): array
    {
        return $template->render($data);
    }

    /**
     * Log email to email_logs table
     *
     * @param int|null $templateId
     * @param string $recipient
     * @param string $subject
     * @param string $body
     * @param string $status
     * @return EmailLog
     */
    public function logEmail(
        ?int $templateId,
        string $recipient,
        string $subject,
        string $body,
        string $status
    ): EmailLog {
        return EmailLog::create([
            'requisition_id' => null, // Will be set if available in context
            'recipient_email' => $recipient,
            'subject' => $subject,
            'body' => $body,
            'status' => $status,
            'sent_at' => $status === EmailLog::STATUS_SENT ? now() : null,
            'created_by' => auth()->id() ?? 1,
            'updated_by' => auth()->id() ?? 1
        ]);
    }

    /**
     * Get recipients based on notification type
     *
     * @param string $type
     * @param Requisition $requisition
     * @return array
     */
    public function getRecipients(string $type, Requisition $requisition): array
    {
        $recipients = [];

        switch ($type) {
            case 'created':
                // Send to Department Head
                $recipients = $this->getDepartmentHeadEmails($requisition);
                break;

            case 'dept_approved':
                // Send to Transport Head
                $recipients = $this->getTransportHeadEmails($requisition);
                break;

            case 'transport_approved':
                // Send to Requester, Driver, and Transport Head
                $recipients = array_merge(
                    $this->getRequesterEmails($requisition),
                    $this->getDriverEmails($requisition),
                    $this->getTransportHeadEmails($requisition)
                );
                break;

            default:
                Log::warning('EmailService: Unknown recipient type', ['type' => $type]);
        }

        return array_filter(array_unique($recipients));
    }

    /**
     * Get requester emails
     *
     * @param Requisition $requisition
     * @return array
     */
    protected function getRequesterEmails(Requisition $requisition): array
    {
        $emails = [];

        $requester = $requisition->requestedBy;
        if ($requester && !empty($requester->email)) {
            $emails[] = $requester->email;
        }

        return $emails;
    }

    /**
     * Get Department Head emails
     *
     * @param Requisition $requisition
     * @return array
     */
    protected function getDepartmentHeadEmails(Requisition $requisition): array
    {
        $emails = [];

        // Get department head from department relationship
        $department = $requisition->department;
        if ($department) {
            // Use the model's accessor which has fallback logic
            $headEmail = $department->head_email;
            if (!empty($headEmail)) {
                $emails[] = $headEmail;
            }
        }

        // Fallback: Also check for users with department_head user_type in the same department
        if (empty($emails)) {
            $departmentId = $requisition->department_id;
            if ($departmentId) {
                $headUsers = \App\Models\User::where('department_id', $departmentId)
                    ->where('user_type', 'department_head')
                    ->where('email', '!=', '')
                    ->pluck('email')
                    ->toArray();
                
                $emails = array_merge($emails, $headUsers);
            }
        }

        return array_filter(array_unique($emails));
    }

    /**
     * Get Transport Head emails
     *
     * @param Requisition $requisition
     * @return array
     */
    protected function getTransportHeadEmails(Requisition $requisition): array
    {
        $emails = [];

        // Get transport admin/head from the requisition
        $transportAdmin = $requisition->transportAdmin;
        if ($transportAdmin && !empty($transportAdmin->email)) {
            $emails[] = $transportAdmin->email;
        }

        // You might also want to query for users with transport admin role
        // This is an alternative approach
        $transportAdmins = \App\Models\User::whereHas('roles', function ($query) {
            $query->where('name', 'Transport_Head');
        })->where('email', '!=', '')->pluck('email')->toArray();

        return array_merge($emails, $transportAdmins);
    }

    /**
     * Get Driver emails
     *
     * @param Requisition $requisition
     * @return array
     */
    protected function getDriverEmails(Requisition $requisition): array
    {
        $emails = [];

        $driver = $requisition->assignedDriver ?? $requisition->driver;
        if ($driver && !empty($driver->email)) {
            $emails[] = $driver->email;
        }

        return $emails;
    }

    /**
     * Prepare template data from requisition
     *
     * @param Requisition $requisition
     * @return array
     */
    protected function prepareTemplateData(Requisition $requisition): array
    {
        $requester = $requisition->requestedBy;
        $department = $requisition->department;
        $driver = $requisition->assignedDriver ?? $requisition->driver;
        $vehicle = $requisition->assignedVehicle ?? $requisition->vehicle;

        return [
            'requisition_number' => $requisition->requisition_number ?? 'N/A',
            'requester_name' => $requester ? ($requester->name ?? $requester->first_name . ' ' . $requester->last_name) : 'N/A',
            'requester_email' => $requester->email ?? 'N/A',
            'department_name' => $department ? ($department->name ?? 'N/A') : 'N/A',
            'pickup_location' => $requisition->from_location ?? 'N/A',
            'dropoff_location' => $requisition->to_location ?? 'N/A',
            'pickup_date' => $requisition->travel_date ? $requisition->travel_date->format('Y-m-d') : 'N/A',
            'pickup_time' => $requisition->travel_time ? $requisition->travel_time->format('H:i') : 'N/A',
            'purpose' => $requisition->purpose ?? 'N/A',
            'vehicle_type' => $vehicle ? ($vehicle->vehicle_type ?? $vehicle->name) : ($requisition->vehicle_type ?? 'N/A'),
            'passengers' => (string)($requisition->number_of_passenger ?? $requisition->total_passenger_count ?? 0),
            'status' => $requisition->status ?? 'N/A',
            'approval_url' => route('requisitions.show', $requisition->id),
            'company_name' => config('app.name', 'Transport Management System'),
        ];
    }
}
