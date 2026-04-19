import 'package:equatable/equatable.dart';

class Trip extends Equatable {
  final int id;
  final String requisitionNumber;
  final String? fromLocation;
  final String? toLocation;
  final DateTime? travelDate;
  final String? travelTime;
  final String? transportStatus;
  final String? status;
  final String? purpose;
  final int? assignedDriverId;
  final int? vehicleId;
  final String? vehicleName;
  final String? vehicleNumber;
  final List<Passenger> passengers;
  final String? requestedByName;

  const Trip({
    required this.id,
    required this.requisitionNumber,
    this.fromLocation,
    this.toLocation,
    this.travelDate,
    this.travelTime,
    this.transportStatus,
    this.status,
    this.purpose,
    this.assignedDriverId,
    this.vehicleId,
    this.vehicleName,
    this.vehicleNumber,
    this.passengers = const [],
    this.requestedByName,
  });

  factory Trip.fromJson(Map<String, dynamic> json) {
    return Trip(
      id: json['id'] is int
          ? json['id']
          : int.tryParse(json['id']?.toString() ?? '0') ?? 0,
      requisitionNumber: json['requisition_number']?.toString() ??
          json['id']?.toString() ??
          '',
      fromLocation: json['from_location']?.toString(),
      toLocation: json['to_location']?.toString(),
      travelDate: json['travel_date'] != null
          ? DateTime.tryParse(json['travel_date'].toString())
          : null,
      travelTime: json['travel_time']?.toString(),
      transportStatus: json['transport_status']?.toString(),
      status: json['status']?.toString(),
      purpose: json['purpose']?.toString(),
      assignedDriverId: json['assigned_driver_id'] is int
          ? json['assigned_driver_id']
          : json['assigned_driver_id'] != null
              ? int.tryParse(json['assigned_driver_id'].toString())
              : null,
      vehicleId: json['vehicle_id'] is int
          ? json['vehicle_id']
          : json['vehicle_id'] != null
              ? int.tryParse(json['vehicle_id'].toString())
              : null,
      vehicleName: json['vehicle_name']?.toString() ??
          (json['assigned_vehicle'] is Map
              ? json['assigned_vehicle']['vehicle_name']?.toString()
              : null),
      vehicleNumber: json['vehicle_number']?.toString() ??
          (json['assigned_vehicle'] is Map
              ? json['assigned_vehicle']['vehicle_number']?.toString()
              : null),
      passengers: json['passengers'] != null
          ? (json['passengers'] as List)
              .map((p) => Passenger.fromJson(p as Map<String, dynamic>))
              .toList()
          : [],
      requestedByName: json['requested_by_name']?.toString() ??
          json['requestedBy']?['name']?.toString(),
    );
  }

  bool get isPending => transportStatus == 'Pending';
  bool get isApproved => transportStatus == 'Approved';
  bool get isInTransit => transportStatus == 'In Transit';
  bool get isCompleted =>
      transportStatus == 'Completed' || status == 'Completed';
  bool get isToday {
    if (travelDate == null) return false;
    final now = DateTime.now();
    return travelDate!.year == now.year &&
        travelDate!.month == now.month &&
        travelDate!.day == now.day;
  }

  @override
  List<Object?> get props => [
        id,
        requisitionNumber,
        fromLocation,
        toLocation,
        travelDate,
        travelTime,
        transportStatus,
        status,
        purpose,
        assignedDriverId,
        vehicleId,
        vehicleName,
        vehicleNumber,
        passengers,
        requestedByName
      ];
}

class Passenger extends Equatable {
  final int id;
  final String? name;
  final String? employeeCode;
  final String? department;

  const Passenger({
    required this.id,
    this.name,
    this.employeeCode,
    this.department,
  });

  factory Passenger.fromJson(Map<String, dynamic> json) {
    return Passenger(
      id: json['id'] is int
          ? json['id']
          : int.tryParse(json['id']?.toString() ?? '0') ?? 0,
      name: json['name']?.toString(),
      employeeCode: json['employee_code']?.toString(),
      department: json['department']?.toString(),
    );
  }

  @override
  List<Object?> get props => [id, name, employeeCode, department];
}
