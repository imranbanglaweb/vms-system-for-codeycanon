import 'package:equatable/equatable.dart';

class FuelLog extends Equatable {
  final int id;
  final int? driverId;
  final int? vehicleId;
  final String? vehicleName;
  final String? vehicleNumber;
  final DateTime? fuelDate;
  final String? fuelType;
  final double? quantity;
  final double? cost;
  final String? location;
  final String? receiptImage;
  final double? odometerReading;
  final String? notes;
  final DateTime? createdAt;

  const FuelLog({
    required this.id,
    this.driverId,
    this.vehicleId,
    this.vehicleName,
    this.vehicleNumber,
    this.fuelDate,
    this.fuelType,
    this.quantity,
    this.cost,
    this.location,
    this.receiptImage,
    this.odometerReading,
    this.notes,
    this.createdAt,
  });

  factory FuelLog.fromJson(Map<String, dynamic> json) {
    return FuelLog(
      id: json['id'] is int
          ? json['id']
          : int.tryParse(json['id']?.toString() ?? '0') ?? 0,
      driverId: json['driver_id'] is int
          ? json['driver_id']
          : json['driver_id'] != null
              ? int.tryParse(json['driver_id'].toString())
              : null,
      vehicleId: json['vehicle_id'] is int
          ? json['vehicle_id']
          : json['vehicle_id'] != null
              ? int.tryParse(json['vehicle_id'].toString())
              : null,
      vehicleName: json['vehicle_name']?.toString(),
      vehicleNumber: json['vehicle_number']?.toString(),
      fuelDate: json['fuel_date'] != null
          ? DateTime.tryParse(json['fuel_date'].toString())
          : null,
      fuelType: json['fuel_type']?.toString(),
      quantity: json['quantity'] != null
          ? double.tryParse(json['quantity'].toString())
          : null,
      cost: json['cost'] != null
          ? double.tryParse(json['cost'].toString())
          : null,
      location:
          json['location']?.toString() ?? json['fuel_station']?.toString(),
      receiptImage: json['receipt_image']?.toString(),
      odometerReading: json['odometer_reading'] != null
          ? double.tryParse(json['odometer_reading'].toString())
          : null,
      notes: json['notes']?.toString(),
      createdAt: json['created_at'] != null
          ? DateTime.tryParse(json['created_at'].toString())
          : null,
    );
  }

  Map<String, dynamic> toJson() {
    return {
      'vehicle_id': vehicleId,
      'fuel_date': fuelDate?.toIso8601String().split('T')[0],
      'fuel_quantity': quantity,
      'fuel_cost': cost,
      'fuel_type': fuelType,
      'fuel_station': location,
      'odometer_reading': odometerReading,
      'notes': notes,
    };
  }

  double? get costPerLiter {
    if (quantity != null && quantity! > 0 && cost != null) {
      return cost! / quantity!;
    }
    return null;
  }

  @override
  List<Object?> get props => [
        id,
        driverId,
        vehicleId,
        vehicleName,
        vehicleNumber,
        fuelDate,
        fuelType,
        quantity,
        cost,
        location,
        receiptImage,
        odometerReading,
        notes,
        createdAt
      ];
}
