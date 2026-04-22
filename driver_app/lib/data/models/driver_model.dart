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
      id: json['id'] is int
          ? json['id']
          : int.tryParse(json['id']?.toString() ?? '0') ?? 0,
      driverName: json['driverName']?.toString() ??
          json['driver_name']?.toString() ??
          '',
      licenseNumber: json['licenseNumber']?.toString() ??
          json['license_number']?.toString(),
      licenseType:
          json['licenseType']?.toString() ?? json['license_type']?.toString(),
      mobile: json['mobile']?.toString(),
      nid: json['nid']?.toString(),
      presentAddress: json['present_address']?.toString(),
      permanentAddress: json['permanent_address']?.toString(),
      photograph: json['photograph']?.toString(),
      availabilityStatus: json['availabilityStatus']?.toString() ??
          json['availability_status']?.toString(),
      availabilityNotes: json['availability_notes']?.toString(),
      availableFrom: json['available_from'] != null
          ? DateTime.tryParse(json['available_from'].toString())
          : null,
      availableUntil: json['available_until'] != null
          ? DateTime.tryParse(json['available_until'].toString())
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
        id,
        driverName,
        licenseNumber,
        licenseType,
        mobile,
        nid,
        presentAddress,
        permanentAddress,
        photograph,
        availabilityStatus,
        availabilityNotes,
        availableFrom,
        availableUntil
      ];
}
