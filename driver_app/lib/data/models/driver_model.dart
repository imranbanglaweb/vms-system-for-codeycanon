import 'package:equatable/equatable.dart';

class Driver extends Equatable {
  final int id;
  final String driverName;
  final String? licenseNumber;
  final String? licenseType;
  final String? mobile;
  final String? nid;
  final String? presentAddress;
  final String? permanentAddress;
  final String? photograph;
  final String? availabilityStatus;
  final String? availabilityNotes;
  final DateTime? availableFrom;
  final DateTime? availableUntil;

  const Driver({
    required this.id,
    required this.driverName,
    this.licenseNumber,
    this.licenseType,
    this.mobile,
    this.nid,
    this.presentAddress,
    this.permanentAddress,
    this.photograph,
    this.availabilityStatus,
    this.availabilityNotes,
    this.availableFrom,
    this.availableUntil,
  });

  factory Driver.fromJson(Map<String, dynamic> json) {
    return Driver(
      id: json['id'] is int ? json['id'] : int.tryParse(json['id']?.toString() ?? '0') ?? 0,
      driverName: json['driver_name'] ?? '',
      licenseNumber: json['license_number'],
      licenseType: json['license_type'],
      mobile: json['mobile'],
      nid: json['nid'],
      presentAddress: json['present_address'],
      permanentAddress: json['permanent_address'],
      photograph: json['photograph'],
      availabilityStatus: json['availability_status'],
      availabilityNotes: json['availability_notes'],
      availableFrom: json['available_from'] != null 
          ? DateTime.tryParse(json['available_from']) 
          : null,
      availableUntil: json['available_until'] != null 
          ? DateTime.tryParse(json['available_until']) 
          : null,
    );
  }

  Map<String, dynamic> toJson() {
    return {
      'id': id,
      'driver_name': driverName,
      'license_number': licenseNumber,
      'license_type': licenseType,
      'mobile': mobile,
      'nid': nid,
      'present_address': presentAddress,
      'permanent_address': permanentAddress,
      'photograph': photograph,
      'availability_status': availabilityStatus,
      'availability_notes': availabilityNotes,
      'available_from': availableFrom?.toIso8601String(),
      'available_until': availableUntil?.toIso8601String(),
    };
  }

  @override
  List<Object?> get props => [
    id, driverName, licenseNumber, licenseType, mobile, nid,
    presentAddress, permanentAddress, photograph, availabilityStatus,
    availabilityNotes, availableFrom, availableUntil
  ];
}