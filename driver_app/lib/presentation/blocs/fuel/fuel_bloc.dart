import 'package:flutter_bloc/flutter_bloc.dart';
import '../../../data/repositories/driver_repository.dart';
import 'fuel_event.dart';

class FuelBloc extends Bloc<FuelEvent, FuelState> {
  final DriverRepository _repository;

  FuelBloc(this._repository) : super(FuelInitial()) {
    on<FuelLogsLoadRequested>(_onLoadRequested);
    on<FuelVehicleDataRequested>(_onVehicleDataRequested);
    on<FuelLogSubmitRequested>(_onSubmitRequested);
    on<AssignedVehiclesLoadRequested>(_onVehiclesLoadRequested);
  }

  Future<void> _onLoadRequested(
    FuelLogsLoadRequested event,
    Emitter<FuelState> emit,
  ) async {
    emit(FuelLoading());
    try {
      final fuelLogs = await _repository.getFuelLogs(page: event.page);
      final vehicles = await _repository.getAssignedVehicles();
      emit(FuelLogsLoaded(
        fuelLogs: fuelLogs,
        vehicles: vehicles,
        hasMore: fuelLogs.length >= 10,
        currentPage: event.page,
      ));
    } catch (e) {
      emit(FuelError(message: e.toString()));
    }
  }

  Future<void> _onVehicleDataRequested(
    FuelVehicleDataRequested event,
    Emitter<FuelState> emit,
  ) async {
    try {
      final data = await _repository.getVehicleFuelData(event.vehicleId);
      emit(FuelVehicleDataLoaded(data: data));
    } catch (e) {
      emit(FuelError(message: e.toString()));
    }
  }

  Future<void> _onSubmitRequested(
    FuelLogSubmitRequested event,
    Emitter<FuelState> emit,
  ) async {
    emit(FuelSubmitting());
    try {
      await _repository.submitFuelLog(event.data, event.imagePath);
      emit(FuelSubmitSuccess(message: 'Fuel log submitted successfully!'));
    } catch (e) {
      emit(FuelError(message: e.toString()));
    }
  }

  Future<void> _onVehiclesLoadRequested(
    AssignedVehiclesLoadRequested event,
    Emitter<FuelState> emit,
  ) async {
    try {
      final vehicles = await _repository.getAssignedVehicles();
      emit(FuelLogsLoaded(fuelLogs: const [], vehicles: vehicles));
    } catch (e) {
      emit(FuelError(message: e.toString()));
    }
  }
}