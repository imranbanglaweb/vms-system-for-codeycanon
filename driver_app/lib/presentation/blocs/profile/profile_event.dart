import 'package:equatable/equatable.dart';

abstract class ProfileEvent extends Equatable {
  @override
  List<Object?> get props => [];
}

class ProfileLoadRequested extends ProfileEvent {}

class AvailabilityUpdateRequested extends ProfileEvent {
  final String status;
  final String? notes;
  final String? availableFrom;
  final String? availableUntil;

  AvailabilityUpdateRequested({
    required this.status,
    this.notes,
    this.availableFrom,
    this.availableUntil,
  });

  @override
  List<Object?> get props => [status, notes, availableFrom, availableUntil];
}

abstract class ProfileState extends Equatable {
  @override
  List<Object?> get props => [];
}

class ProfileInitial extends ProfileState {}

class ProfileLoading extends ProfileState {}

class ProfileLoaded extends ProfileState {
  final dynamic driver;
  final dynamic vehicle;

  ProfileLoaded({required this.driver, this.vehicle});

  @override
  List<Object?> get props => [driver, vehicle];
}

class ProfileUpdating extends ProfileState {}

class ProfileUpdateSuccess extends ProfileState {
  final String message;
  ProfileUpdateSuccess({required this.message});
  @override
  List<Object?> get props => [message];
}

class ProfileError extends ProfileState {
  final String message;
  ProfileError({required this.message});
  @override
  List<Object?> get props => [message];
}
