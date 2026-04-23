import 'package:equatable/equatable.dart';
import 'driver_model.dart';
import 'trip_model.dart';
import 'vehicle_model.dart';

class DriverDashboard extends Equatable {
  final Driver? driver;
  final List<Trip> todayTrips;
  final List<Trip> upcomingTrips;
  final List<Trip> recentTrips;
  final List<Trip> assignedTrips;
  final Trip? activeTrip;
  final int pendingTripsCount;
  final int activeTripsCount;
  final int completedTripsCount;
  final Map<String, dynamic>? lastVehicle;

  const DriverDashboard({
    this.driver,
    this.todayTrips = const [],
    this.upcomingTrips = const [],
    this.recentTrips = const [],
    this.assignedTrips = const [],
    this.activeTrip,
    this.pendingTripsCount = 0,
    this.activeTripsCount = 0,
    this.completedTripsCount = 0,
    this.lastVehicle,
  });

  factory DriverDashboard.fromJson(Map<String, dynamic> json) {
    return DriverDashboard(
      driver: json['driver'] != null ? Driver.fromJson(json['driver']) : null,
      todayTrips: json['todayTrips'] != null
          ? (json['todayTrips'] as List)
              .map((t) => Trip.fromJson(t as Map<String, dynamic>))
              .toList()
          : [],
      upcomingTrips: json['upcomingTrips'] != null
          ? (json['upcomingTrips'] as List)
              .map((t) => Trip.fromJson(t as Map<String, dynamic>))
              .toList()
          : [],
      recentTrips: json['recentTrips'] != null
          ? (json['recentTrips'] as List)
              .map((t) => Trip.fromJson(t as Map<String, dynamic>))
              .toList()
          : [],
      assignedTrips: json['assignedTrips'] != null
          ? (json['assignedTrips'] as List)
              .map((t) => Trip.fromJson(t as Map<String, dynamic>))
              .toList()
          : [],
      activeTrip: json['activeTrip'] != null
          ? Trip.fromJson(json['activeTrip'] as Map<String, dynamic>)
          : null,
      pendingTripsCount: json['pendingTripsCount'] ?? 0,
      activeTripsCount: json['activeTripsCount'] ?? 0,
      completedTripsCount: json['completedTripsCount'] ?? 0,
      lastVehicle: json['lastVehicle'] as Map<String, dynamic>?,
    );
  }

  @override
  List<Object?> get props => [
        driver,
        todayTrips,
        upcomingTrips,
        recentTrips,
        assignedTrips,
        activeTrip,
        pendingTripsCount,
        activeTripsCount,
        completedTripsCount,
        lastVehicle
      ];
}

class DriverVehicle extends Equatable {
  final Vehicle? vehicle;
  final List<dynamic> maintenanceRecords;

  const DriverVehicle({
    this.vehicle,
    this.maintenanceRecords = const [],
  });

  factory DriverVehicle.fromJson(Map<String, dynamic> json) {
    return DriverVehicle(
      vehicle:
          json['vehicle'] != null ? Vehicle.fromJson(json['vehicle']) : null,
      maintenanceRecords: json['maintenanceRecords'] != null
          ? List<dynamic>.from(json['maintenanceRecords'])
          : [],
    );
  }

  @override
  List<Object?> get props => [vehicle, maintenanceRecords];
}
