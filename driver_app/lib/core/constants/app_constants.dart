class ApiConstants {
  static const String baseUrl =
      'http://localhost/vms-system-for-codeycanon/api';
  static const String loginEndpoint = '/login';
  static const String settingsEndpoint = '/settings';
  static const String driverDashboard = '/driver/dashboard';
  static const String driverTrips = '/driver/trips';
  static const String driverSchedule = '/driver/schedule';
  static const String driverFuelLog = '/driver/fuel-log';
  static const String driverVehicle = '/driver/vehicle';
  static const String driverAvailability = '/driver/availability';
  static const String driverProfile = '/driver/profile';

  static const int connectTimeout = 30000;
  static const int receiveTimeout = 30000;
}

class StorageKeys {
  static const String authToken = 'auth_token';
  static const String driverId = 'driver_id';
  static const String driverName = 'driver_name';
  static const String driverEmail = 'driver_email';
  static const String appLogo = 'app_logo';
  static const String appTitle = 'app_title';
  static const String appDescription = 'app_description';
}

class AppStrings {
  static const String appName = 'VMS Driver';
  static const String defaultTitle = 'গাড়িবন্ধু ৩৬০';
  static const String defaultDescription = 'Fleet Management Solution';
  static const String login = 'Login';
  static const String logout = 'Logout';
  static const String dashboard = 'Dashboard';
  static const String trips = 'Trips';
  static const String fuelLog = 'Fuel Log';
  static const String profile = 'Profile';
  static const String schedule = 'Schedule';
  static const String vehicle = 'Vehicle';
  static const String availability = 'Availability';
  static const String settings = 'Settings';

  static const String email = 'Email';
  static const String password = 'Password';
  static const String loginButton = 'Sign In';

  static const String noTrips = 'No trips available';
  static const String noFuelLogs = 'No fuel logs available';
  static const String noVehicle = 'No vehicle assigned';

  static const String startTrip = 'Start Trip';
  static const String finishTrip = 'Finish Trip';
  static const String endTrip = 'End Trip';

  static const String addFuelLog = 'Add Fuel Log';
  static const String submit = 'Submit';
  static const String cancel = 'Cancel';

  static const String errorOccurred = 'An error occurred';
  static const String tryAgain = 'Try Again';
  static const String noInternet = 'No internet connection';
}

class StatusConstants {
  static const String pending = 'Pending';
  static const String approved = 'Approved';
  static const String inTransit = 'In Transit';
  static const String tripCompleted = 'Trip Completed';
  static const String completed = 'Completed';
  static const String cancelled = 'Cancelled';

  static const String available = 'available';
  static const String onLeave = 'on_leave';
  static const String unavailable = 'unavailable';
}
