import 'package:flutter_bloc/flutter_bloc.dart';
import '../../../data/repositories/driver_repository.dart';
import '../../../data/models/driver_model.dart';
import 'auth_event.dart';

class AuthBloc extends Bloc<AuthEvent, AuthState> {
  final DriverRepository _repository;

  AuthBloc(this._repository) : super(AuthInitial()) {
    on<AuthCheckRequested>(_onCheckRequested);
    on<AuthLoginRequested>(_onLoginRequested);
    on<AuthLogoutRequested>(_onLogoutRequested);
  }

  Future<void> _onCheckRequested(
    AuthCheckRequested event,
    Emitter<AuthState> emit,
  ) async {
    emit(AuthLoading());
    try {
      final isLoggedIn = await _repository.isLoggedIn();
      if (isLoggedIn) {
        final driver = await _repository.getProfile();
        emit(AuthAuthenticated(driver: driver));
      } else {
        emit(AuthUnauthenticated());
      }
    } catch (e) {
      emit(AuthUnauthenticated());
    }
  }

  Future<void> _onLoginRequested(
    AuthLoginRequested event,
    Emitter<AuthState> emit,
  ) async {
    emit(AuthLoading());
    try {
      final data = await _repository.login(event.email, event.password);
      final driver = data['driver'] != null 
          ? Driver.fromJson(data['driver']) 
          : Driver(id: 0, driverName: 'Driver');
      emit(AuthAuthenticated(driver: driver));
    } catch (e) {
      String errorMessage = e.toString();
      if (errorMessage.contains('Invalid credentials')) {
        errorMessage = 'Invalid email or password';
      } else if (errorMessage.contains('connection')) {
        errorMessage = 'Unable to connect to server';
      } else if (errorMessage.contains('SocketException')) {
        errorMessage = 'No internet connection';
      }
      emit(AuthError(message: errorMessage));
      await Future.delayed(const Duration(milliseconds: 100));
      emit(AuthUnauthenticated());
    }
  }

  Future<void> _onLogoutRequested(
    AuthLogoutRequested event,
    Emitter<AuthState> emit,
  ) async {
    emit(AuthLoading());
    try {
      await _repository.logout();
      emit(AuthUnauthenticated());
    } catch (e) {
      emit(AuthError(message: e.toString()));
    }
  }
}