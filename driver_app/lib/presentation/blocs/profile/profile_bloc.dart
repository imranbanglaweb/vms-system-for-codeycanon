import 'package:flutter/foundation.dart';
import 'package:flutter_bloc/flutter_bloc.dart';
import '../../../data/repositories/driver_repository.dart';
import 'profile_event.dart';

class ProfileBloc extends Bloc<ProfileEvent, ProfileState> {
  final DriverRepository _repository;

  ProfileBloc(this._repository) : super(ProfileInitial()) {
    on<ProfileLoadRequested>(_onLoadRequested);
    on<AvailabilityUpdateRequested>(_onUpdateRequested);
  }

  Future<void> _onLoadRequested(
    ProfileLoadRequested event,
    Emitter<ProfileState> emit,
  ) async {
    emit(ProfileLoading());
    try {
      final driver = await _repository.getProfile();
      final vehicle = await _repository.getVehicle();
      debugPrint('ProfileBloc - driver: $driver, vehicle: $vehicle');
      emit(ProfileLoaded(driver: driver, vehicle: vehicle));
    } catch (e) {
      debugPrint('ProfileBloc error: $e');
      emit(ProfileError(message: e.toString()));
    }
  }

  Future<void> _onUpdateRequested(
    AvailabilityUpdateRequested event,
    Emitter<ProfileState> emit,
  ) async {
    emit(ProfileUpdating());
    try {
      await _repository.updateAvailability({
        'availability_status': event.status,
        'availability_notes': event.notes,
        'available_from': event.availableFrom,
        'available_until': event.availableUntil,
      });
      emit(ProfileUpdateSuccess(message: 'Availability updated successfully!'));
      add(ProfileLoadRequested());
    } catch (e) {
      emit(ProfileError(message: e.toString()));
    }
  }
}