# Email Templates Update - Admin-Friendly Interface

## Overview
The email template system has been updated to provide a more user-friendly interface with separate input boxes for different email components, making it easier for admins to manage templates without needing to understand complex HTML.

## Changes Made

### 1. **Views Updated**

#### `resources/views/admin/dashboard/email-templates/edit.blade.php`
- **Removed**: WYSIWYG editor (CKEditor/TinyMCE)
- **Added**: Simple textarea for Email Body (HTML content)
- **New Input Fields**:
  - **Greeting Message**: Separate input for greeting text (e.g., `Dear @@head_name,`)
  - **Main Content Text**: Textarea for main message body
  - **Email Body (HTML)**: Textarea for full HTML email template
  - **Footer Text**: Separate input for footer/closing message
  - **Available Variables Badge**: Shows all available variables for this template type

#### `resources/views/admin/dashboard/email-templates/create.blade.php`
- Same changes as edit page
- New separate input fields for greeting, content, and footer

### 2. **Controller Updated**

#### `app/Http/Controllers/EmailTemplateController.php`

**store() method**:
- Added validation for new fields: `greeting`, `content_text`, `footer_text`
- Automatically merges these fields into the `variables` JSON
- Stores greeting, content_text, and footer_text as separate keys in variables array

**update() method**:
- Same enhancements as store method
- Updates templates with new field handling

### 3. **Database Seeder Updated**

#### `database/seeders/EmailTemplateSeeder.php`

Updated the "Requisition Created Notification" template with:
```json
{
  "greeting": "Dear @@head_name,",
  "content_text": "A new vehicle requisition has been submitted from your department and requires your approval.",
  "footer_text": "Please review the requisition details and take appropriate action within your department.",
  "requisition_number": "Unique identifier for the requisition",
  "requester_name": "Name of person requesting vehicle",
  "requester_email": "Email of requester",
  "department_name": "Department requesting vehicle",
  "pickup_location": "Location where vehicle pickup",
  "dropoff_location": "Location for vehicle drop-off",
  "pickup_date": "Date of pickup",
  "pickup_time": "Time of pickup",
  "purpose": "Purpose of requisition",
  "passengers": "Number of passengers",
  "admin_logo_url": "Logo URL from admin settings",
  "admin_title": "Company title from admin settings",
  "company_name": "Company name from admin settings",
  "year": "Current year",
  "approval_url": "URL to approve requisition",
  "head_name": "Name of department head"
}
```

## How It Works

### For Admins
1. **Create/Edit Email Template**:
   - Fill in Template Name, Slug, Type, and Status
   - Fill in Email Subject
   - Use separate input boxes for:
     - Greeting Message
     - Main Content Text
     - Email Body (HTML)
     - Footer Text
   - Add any custom variables in the JSON field

2. **Using Variables**:
   - Use double `@@` symbol: `@@variable_name`
   - Example: `Dear @@requester_name,`
   - Badge shows all available variables

3. **Email Body**:
   - Can write raw HTML or use the template variables
   - Each template includes helpful variable references

### For Developers
- The `greeting`, `content_text`, and `footer_text` are stored in the `variables` JSON field
- These can be retrieved and used during email generation
- Example: `$template->variables['greeting']` returns `"Dear @@head_name,"`

## Available Template Variables

### Requisition-Related
- `@@requisition_number` - Unique identifier for requisition
- `@@requester_name` - Name of person requesting
- `@@requester_email` - Email of requester
- `@@department_name` - Department name
- `@@pickup_location` - Pickup location
- `@@dropoff_location` - Drop-off location
- `@@pickup_date` - Date of pickup
- `@@pickup_time` - Time of pickup
- `@@purpose` - Purpose of requisition
- `@@passengers` - Number of passengers
- `@@approval_url` - Link to approve requisition

### Admin Settings
- `@@admin_logo_url` - Logo from admin settings
- `@@admin_title` - Company title from settings
- `@@admin_description` - Company description from settings
- `@@company_name` - Company name
- `@@year` - Current year

## Migration Notes

If you had existing templates:
1. Run `php artisan migrate --seed` to apply the updated seeder
2. Or manually update template records to include greeting, content_text, and footer_text in the variables JSON

## Preview Feature

The preview function has been updated to:
- Validate logo URLs (prevent 404 errors from unprocessed template variables)
- Gracefully fall back if logo is unavailable
- Display email in modal iframe

## Next Steps for Codeycanon

Once Codeycanon integration is ready:
1. Template system can be enhanced with Codeycanon rendering
2. Variables can be dynamically generated from Codeycanon data
3. Rich HTML templates can be stored as Codeycanon partials
