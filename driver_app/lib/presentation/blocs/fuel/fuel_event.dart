import 'package:equatable/equatable.dart';
import '../../../data/models/fuel_log_model.dart';
import '../../../data/models/vehicle_model.dart';

abstract class FuelEvent extends Equatable {
  @override
  List<Object?> get props => [];
}

class FuelLogsLoadRequested extends FuelEvent {
  final int page;
  FuelLogsLoadRequested({this.page = 1});
  @override
  List<Object?> get props => [page];
}

class FuelVehicleDataRequested extends FuelEvent {
  final int vehicleId;
  FuelVehicleDataRequested({required this.vehicleId});
  @override
  List<Object?> get props => [vehicleId];
}

class FuelLogSubmitRequested extends FuelEvent {
  final Map<String, dynamic> data;
  final String? imagePath;
  FuelLogSubmitRequested({required this.data, this.imagePath});
  @override
  List<Object?> get props => [data, imagePath];
}

class AssignedVehiclesLoadRequested extends FuelEvent {}


abstract class FuelState extends Equatable {
  @override
  List<Object?> get props => [];
}

class FuelInitial extends FuelState {}

class FuelLoading extends FuelState {}

class FuelLogsLoaded extends FuelState {
  final List<FuelLog> fuelLogs;
  final List<Vehicle> vehicles;
  final bool hasMore;
  final int currentPage;

  FuelLogsLoaded({
    required this.fuelLogs,
    this.vehicles = const [],
    this.hasMore = false,
    this.currentPage = 1,
  });

  @override
  List<Object?> get props => [fuelLogs, vehicles, hasMore, currentPage];
}

class FuelVehicleDataLoaded extends FuelState {
  final Map<String, dynamic> data;
  FuelVehicleDataLoaded({required this.data});
  @override
  List<Object?> get props => [data];
}

class FuelSubmitting extends FuelState {}

class FuelSubmitSuccess extends FuelState {
  final String message;
  final List<String>? warnings;
  FuelSubmitSuccess({required this.message, this.warnings});
  @override
  List<Object?> get props => [message, warnings];
}

class FuelError extends FuelState {
  final String message;
  FuelError({required this.message});
  @override
  List<Object?> get props => [message];
}