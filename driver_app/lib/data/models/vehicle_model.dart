import 'package:equatable/equatable.dart';

class Vehicle extends Equatable {
  final int id;
  final String vehicleName;
  final String vehicleNumber;
  final String? vehicleType;
  final String? brand;
  final String? model;
  final String? color;
  final int? seatingCapacity;
  final String? status;
  final String? photograph;

  const Vehicle({
    required this.id,
    required this.vehicleName,
    required this.vehicleNumber,
    this.vehicleType,
    this.brand,
    this.model,
    this.color,
    this.seatingCapacity,
    this.status,
    this.photograph,
  });

  factory Vehicle.fromJson(Map<String, dynamic> json) {
    return Vehicle(
      id: json['id'] is int ? json['id'] : int.tryParse(json['id']?.toString() ?? '0') ?? 0,
      vehicleName: json['vehicle_name'] ?? '',
      vehicleNumber: json['vehicle_number'] ?? '',
      vehicleType: json['vehicle_type'],
      brand: json['brand'],
      model: json['model'],
      color: json['color'],
      seatingCapacity: json['seating_capacity'] is int 
          ? json['seating_capacity'] 
          : int.tryParse(json['seating_capacity']?.toString() ?? '0'),
      status: json['status'],
      photograph: json['photograph'],
    );
  }

  Map<String, dynamic> toJson() {
    return {
      'id': id,
      'vehicle_name': vehicleName,
      'vehicle_number': vehicleNumber,
      'vehicle_type': vehicleType,
      'brand': brand,
      'model': model,
      'color': color,
      'seating_capacity': seatingCapacity,
      'status': status,
      'photograph': photograph,
    };
  }

  @override
  List<Object?> get props => [
    id, vehicleName, vehicleNumber, vehicleType, brand, model,
    color, seatingCapacity, status, photograph
  ];
}