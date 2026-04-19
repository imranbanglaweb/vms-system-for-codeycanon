import 'package:flutter/material.dart';
import 'package:flutter_bloc/flutter_bloc.dart';
import 'package:provider/provider.dart';
import 'core/di/injection_container.dart';
import 'core/theme/app_theme.dart';
import 'core/providers/settings_provider.dart';
import 'presentation/blocs/auth/auth_bloc.dart';
import 'presentation/blocs/auth/auth_event.dart';
import 'presentation/blocs/dashboard/dashboard_bloc.dart';
import 'presentation/blocs/trips/trips_bloc.dart';
import 'presentation/blocs/fuel/fuel_bloc.dart';
import 'presentation/blocs/profile/profile_bloc.dart';
import 'presentation/pages/login_page.dart';
import 'presentation/pages/home_page.dart';

class VmsDriverApp extends StatelessWidget {
  const VmsDriverApp({super.key});

  @override
  Widget build(BuildContext context) {
    return MultiBlocProvider(
      providers: [
        BlocProvider<AuthBloc>(
          create: (_) => getIt<AuthBloc>()..add(AuthCheckRequested()),
        ),
        BlocProvider<DashboardBloc>(
          create: (_) => getIt<DashboardBloc>(),
        ),
        BlocProvider<TripsBloc>(
          create: (_) => getIt<TripsBloc>(),
        ),
        BlocProvider<FuelBloc>(
          create: (_) => getIt<FuelBloc>(),
        ),
        BlocProvider<ProfileBloc>(
          create: (_) => getIt<ProfileBloc>(),
        ),
      ],
      child: ChangeNotifierProvider.value(
        value: getIt<SettingsProvider>(),
        child: MaterialApp(
          title: 'VMS Driver',
          debugShowCheckedModeBanner: false,
          theme: AppTheme.lightTheme,
          home: BlocBuilder<AuthBloc, AuthState>(
            builder: (context, state) {
              if (state is AuthLoading || state is AuthInitial) {
                return const Scaffold(
                  body: Center(child: CircularProgressIndicator()),
                );
              }
              if (state is AuthAuthenticated) {
                return const HomePage();
              }
              return const LoginPage();
            },
          ),
        ),
      ),
    );
  }
}
