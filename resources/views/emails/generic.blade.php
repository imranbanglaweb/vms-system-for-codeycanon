<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Transport Management System') }}</title>
    <style>
        /* Reset styles */
        body, table, td, a { -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; }
        table, td { mso-table-lspace: 0pt; mso-table-rspace: 0pt; }
        img { -ms-interpolation-mode: bicubic; border: 0; height: auto; line-height: 100%; outline: none; text-decoration: none; }
        table { border-collapse: collapse !important; }
        body { height: 100% !important; margin: 0 !important; padding: 0 !important; width: 100% !important; }
        
        /* Mobile responsive */
        @media screen and (max-width: 600px) {
            .email-container { width: 100% !important; }
            .mobile-padding { padding: 15px !important; }
            .mobile-stack { display: block !important; width: 100% !important; }
        }
    </style>
</head>
<body style="margin: 0; padding: 0; background-color: #f4f6f8; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">
    
    <!-- Preheader -->
    <div style="display: none; max-height: 0; overflow: hidden;">
        {{ strip_tags($body) }}
    </div>

    <!-- Email Wrapper -->
    <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="background-color: #f4f6f8;">
        <tr>
            <td align="center" style="padding: 30px 10px;">
                
                <!-- Email Container -->
                <table role="presentation" cellspacing="0" cellpadding="0" border="0" class="email-container" style="width: 100%; max-width: 600px; background-color: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.08);">
                    
                    <!-- Header with Logo -->
                    <tr>
                        <td style="background: linear-gradient(135deg, #1e3a5f 0%, #2d5a87 100%); padding: 30px 40px; text-align: center;">
                            <!-- Logo -->
                            @if(config('app.logo') || file_exists(public_path('admin_resource/assets/images/'.config('app.name', 'logo').'.png')))
                                <img src="{{ config('app.logo') ?: asset('admin_resource/assets/images/' . strtolower(str_replace(' ', '-', config('app.name', 'logo'))) . '.png') }}" 
                                     alt="{{ config('app.name', 'Transport Management System') }}" 
                                     style="max-width: 180px; height: auto; display: inline-block;">
                            @else
                                <h1 style="margin: 0; color: #ffffff; font-size: 24px; font-weight: 600; letter-spacing: 0.5px;">
                                    {{ config('app.name', 'Transport Management System') }}
                                </h1>
                            @endif
                        </td>
                    </tr>
                    
                    <!-- Company Info Bar -->
                    <tr>
                        <td style="background-color: #f8fafc; padding: 12px 40px; border-bottom: 1px solid #e8ecf1;">
                            <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                                <tr>
                                    <td style="text-align: center; color: #64748b; font-size: 13px;">
                                        <span style="margin: 0 15px;"><i style="margin-right: 5px;">📧</i> {{ config('mail.from.address') }}</span>
                                        <span style="margin: 0 15px;"><i style="margin-right: 5px;">🌐</i> {{ config('app.url') }}</span>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    
                    <!-- Main Content -->
                    <tr>
                        <td class="mobile-padding" style="padding: 40px;">
                            <!-- Greeting -->
                            <h2 style="margin: 0 0 20px 0; color: #1e293b; font-size: 22px; font-weight: 600;">
                                Hello,
                            </h2>
                            
                            <!-- Body Content -->
                            <div style="color: #475569; font-size: 15px; line-height: 1.7;">
                                {!! $body !!}
                            </div>
                            
                            <!-- Divider -->
                            <div style="margin: 30px 0; border-top: 1px solid #e8ecf1;"></div>
                            
                            <!-- Action Button (if needed) -->
                            @isset($action_url)
                                <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                                    <tr>
                                        <td align="center" style="padding: 10px 0 20px 0;">
                                            <a href="{{ $action_url }}" 
                                               style="display: inline-block; padding: 14px 35px; background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); color: #ffffff; text-decoration: none; font-size: 15px; font-weight: 600; border-radius: 8px; box-shadow: 0 4px 12px rgba(59, 130, 246, 0.35);">
                                                {{ $action_text ?? 'Click Here' }}
                                            </a>
                                        </td>
                                    </tr>
                                </table>
                            @endisset
                            
                            <!-- Signature -->
                            <div style="margin-top: 25px; padding-top: 20px; border-top: 1px dashed #e8ecf1;">
                                <p style="margin: 0 0 5px 0; color: #1e293b; font-size: 15px; font-weight: 600;">
                                    Best regards,
                                </p>
                                <p style="margin: 0; color: #64748b; font-size: 14px;">
                                    The {{ config('app.name', 'Transport Management System') }} Team
                                </p>
                            </div>
                        </td>
                    </tr>
                    
                    <!-- Footer -->
                    <tr>
                        <td style="background-color: #f8fafc; padding: 25px 40px; border-top: 1px solid #e8ecf1;">
                            <!-- Social Links -->
                            <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                                <tr>
                                    <td align="center" style="padding-bottom: 15px;">
                                        <span style="color: #94a3b8; font-size: 12px;">
                                            Connect with us
                                        </span>
                                    </td>
                                </tr>
                            </table>
                            
                            <!-- Copyright -->
                            <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                                <tr>
                                    <td align="center">
                                        <p style="margin: 0 0 10px 0; color: #64748b; font-size: 13px;">
                                            &copy; {{ date('Y') }} {{ config('app.name', 'Transport Management System') }}. All rights reserved.
                                        </p>
                                        <p style="margin: 0; color: #94a3b8; font-size: 12px;">
                                            This email was sent to {{ isset($email) ? $email : 'your email address' }}.
                                            <br>
                                            <a href="{{ config('app.url') }}" style="color: #3b82f6; text-decoration: none;">Visit Website</a>
                                            | 
                                            <a href="#" style="color: #3b82f6; text-decoration: none;">Unsubscribe</a>
                                        </p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    
                </table>
                
                <!-- Email Footer Note -->
                <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="max-width: 600px;">
                    <tr>
                        <td align="center" style="padding: 20px; color: #94a3b8; font-size: 12px;">
                            <p style="margin: 0; line-height: 1.6;">
                                This is an automated message. Please do not reply directly to this email.
                            </p>
                        </td>
                    </tr>
                </table>
                
            </td>
        </tr>
    </table>
</body>
</html>
