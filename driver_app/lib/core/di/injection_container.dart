import 'package:get_it/get_it.dart';
import '../../data/datasources/api_client.dart';
import '../../data/repositories/driver_repository.dart';
import '../../presentation/blocs/auth/auth_bloc.dart';
import '../../presentation/blocs/dashboard/dashboard_bloc.dart';
import '../../presentation/blocs/trips/trips_bloc.dart';
import '../../presentation/blocs/fuel/fuel_bloc.dart';
import '../../presentation/blocs/profile/profile_bloc.dart';
import '../providers/settings_provider.dart';

final getIt = GetIt.instance;

void setupDependencies() {
  getIt.registerLazySingleton<ApiClient>(() => ApiClient());
  getIt.registerLazySingleton<DriverRepository>(
    () => DriverRepository(getIt<ApiClient>()),
  );

  getIt.registerLazySingleton<SettingsProvider>(
    () => SettingsProvider(getIt<DriverRepository>()),
  );

  getIt.registerFactory<AuthBloc>(
    () => AuthBloc(getIt<DriverRepository>()),
  );
  getIt.registerFactory<DashboardBloc>(
    () => DashboardBloc(getIt<DriverRepository>()),
  );
  getIt.registerFactory<TripsBloc>(
    () => TripsBloc(getIt<DriverRepository>()),
  );
  getIt.registerFactory<FuelBloc>(
    () => FuelBloc(getIt<DriverRepository>()),
  );
  getIt.registerFactory<ProfileBloc>(
    () => ProfileBloc(getIt<DriverRepository>()),
  );
}
