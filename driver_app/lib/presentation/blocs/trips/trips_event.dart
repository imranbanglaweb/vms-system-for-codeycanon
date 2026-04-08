import 'package:equatable/equatable.dart';
import '../../../data/models/trip_model.dart';

abstract class TripsEvent extends Equatable {
  @override
  List<Object?> get props => [];
}

class TripsLoadRequested extends TripsEvent {
  final int page;
  TripsLoadRequested({this.page = 1});
  @override
  List<Object?> get props => [page];
}

class TripStartRequested extends TripsEvent {
  final int tripId;
  TripStartRequested({required this.tripId});
  @override
  List<Object?> get props => [tripId];
}

class TripFinishRequested extends TripsEvent {
  final int tripId;
  TripFinishRequested({required this.tripId});
  @override
  List<Object?> get props => [tripId];
}

class TripEndRequested extends TripsEvent {
  final int tripId;
  TripEndRequested({required this.tripId});
  @override
  List<Object?> get props => [tripId];
}

abstract class TripsState extends Equatable {
  @override
  List<Object?> get props => [];
}

class TripsInitial extends TripsState {}

class TripsLoading extends TripsState {}

class TripsLoaded extends TripsState {
  final List<Trip> trips;
  final bool hasMore;
  final int currentPage;

  TripsLoaded({required this.trips, this.hasMore = false, this.currentPage = 1});

  @override
  List<Object?> get props => [trips, hasMore, currentPage];
}

class TripsUpdating extends TripsState {}

class TripActionSuccess extends TripsState {
  final String message;
  TripActionSuccess({required this.message});
  @override
  List<Object?> get props => [message];
}

class TripsError extends TripsState {
  final String message;
  TripsError({required this.message});
  @override
  List<Object?> get props => [message];
}