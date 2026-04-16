import 'package:flutter_bloc/flutter_bloc.dart';
import '../../../data/repositories/driver_repository.dart';
import 'dashboard_event.dart';

class DashboardBloc extends Bloc<DashboardEvent, DashboardState> {
  final DriverRepository _repository;

  DashboardBloc(this._repository) : super(DashboardInitial()) {
    on<DashboardLoadRequested>(_onLoadRequested);
    on<DashboardRefreshRequested>(_onRefreshRequested);
  }

  Future<void> _onLoadRequested(
    DashboardLoadRequested event,
    Emitter<DashboardState> emit,
  ) async {
    emit(DashboardLoading());
    try {
      final dashboard = await _repository.getDashboard();
      emit(DashboardLoaded(dashboard: dashboard));
    } catch (e) {
      emit(DashboardError(message: e.toString()));
    }
  }

  Future<void> _onRefreshRequested(
    DashboardRefreshRequested event,
    Emitter<DashboardState> emit,
  ) async {
    try {
      final dashboard = await _repository.getDashboard();
      emit(DashboardLoaded(dashboard: dashboard));
    } catch (e) {
      emit(DashboardError(message: e.toString()));
    }
  }
}