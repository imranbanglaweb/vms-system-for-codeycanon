# VMS Driver Mobile App

A Flutter mobile application for drivers to manage their trips, fuel logs, and availability.

## Project Structure

```
driver_app/
├── lib/
│   ├── main.dart                    # App entry point
│   ├── app.dart                     # App configuration
│   ├── core/
│   │   ├── constants/               # App constants
│   │   ├── di/                      # Dependency injection
│   │   ├── theme/                   # App theme
│   │   └── utils/                   # Utilities
│   ├── data/
│   │   ├── datasources/             # API client
│   │   ├── models/                  # Data models
│   │   └── repositories/            # Data repositories
│   ├── domain/                     # Domain layer (entities, use cases)
│   └── presentation/
│       ├── blocs/                   # BLoC state management
│       ├── pages/                   # UI pages
│       └── widgets/                 # Reusable widgets
```

## Features

1. **Authentication** - Login with email/password, secure token storage
2. **Dashboard** - View today's trips, upcoming trips, active trip, and stats
3. **Trip Management** - View trips, start/finish/end trips
4. **Fuel Log** - Submit fuel entries with receipt photos
5. **Profile** - View driver info, update availability status

## Setup

1. Install Flutter dependencies:
   ```bash
   cd driver_app
   flutter pub get
   ```

2. Update API base URL in `lib/core/constants/app_constants.dart`

3. Run the app:
   ```bash
   flutter run
   ```

## Laravel Backend Requirements

The backend needs:
1. Laravel Sanctum for API token authentication
2. API routes defined in `routes/api.php`
3. Login endpoint returning token and driver data

### Run migrations if needed:
```bash
php artisan migrate
```

### Publish Sanctum config:
```bash
php artisan vendor:publish --provider="Laravel\Sanctum\Http\Providers\FoundationServiceProvider"
```