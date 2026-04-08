import 'package:flutter_bloc/flutter_bloc.dart';
import '../../../data/repositories/driver_repository.dart';
import 'trips_event.dart';

class TripsBloc extends Bloc<TripsEvent, TripsState> {
  final DriverRepository _repository;

  TripsBloc(this._repository) : super(TripsInitial()) {
    on<TripsLoadRequested>(_onLoadRequested);
    on<TripStartRequested>(_onStartTrip);
    on<TripFinishRequested>(_onFinishTrip);
    on<TripEndRequested>(_onEndTrip);
  }

  Future<void> _onLoadRequested(
    TripsLoadRequested event,
    Emitter<TripsState> emit,
  ) async {
    emit(TripsLoading());
    try {
      final trips = await _repository.getTrips(page: event.page);
      emit(TripsLoaded(trips: trips, hasMore: trips.length >= 10, currentPage: event.page));
    } catch (e) {
      emit(TripsError(message: e.toString()));
    }
  }

  Future<void> _onStartTrip(
    TripStartRequested event,
    Emitter<TripsState> emit,
  ) async {
    emit(TripsUpdating());
    try {
      await _repository.startTrip(event.tripId);
      emit(TripActionSuccess(message: 'Trip started successfully!'));
      add(TripsLoadRequested());
    } catch (e) {
      emit(TripsError(message: e.toString()));
    }
  }

  Future<void> _onFinishTrip(
    TripFinishRequested event,
    Emitter<TripsState> emit,
  ) async {
    emit(TripsUpdating());
    try {
      await _repository.finishTrip(event.tripId);
      emit(TripActionSuccess(message: 'Trip finished successfully!'));
      add(TripsLoadRequested());
    } catch (e) {
      emit(TripsError(message: e.toString()));
    }
  }

  Future<void> _onEndTrip(
    TripEndRequested event,
    Emitter<TripsState> emit,
  ) async {
    emit(TripsUpdating());
    try {
      await _repository.endTrip(event.tripId);
      emit(TripActionSuccess(message: 'Trip completed successfully!'));
      add(TripsLoadRequested());
    } catch (e) {
      emit(TripsError(message: e.toString()));
    }
  }
}