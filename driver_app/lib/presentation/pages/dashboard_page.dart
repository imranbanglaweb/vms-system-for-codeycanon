import 'package:flutter/material.dart';
import 'package:flutter_bloc/flutter_bloc.dart';
import 'package:provider/provider.dart';
import 'package:intl/intl.dart';
import '../../core/theme/app_theme.dart';
import '../../core/providers/settings_provider.dart';
import '../blocs/dashboard/dashboard_bloc.dart';
import '../blocs/dashboard/dashboard_event.dart';
import '../widgets/trip_card.dart';
import '../widgets/stats_card.dart';

class DashboardPage extends StatelessWidget {
  const DashboardPage({super.key});

  @override
  Widget build(BuildContext context) {
    return Consumer<SettingsProvider>(
      builder: (context, settings, child) {
        return Scaffold(
          appBar: AppBar(
            title: Row(
              mainAxisSize: MainAxisSize.min,
              children: [
                Container(
                  padding: const EdgeInsets.all(6),
                  decoration: BoxDecoration(
                    color: Colors.white.withValues(alpha: 0.2),
                    borderRadius: BorderRadius.circular(8),
                  ),
                  child: settings.logoUrl != null
                      ? Image.network(
                          settings.logoUrl!,
                          width: 20,
                          height: 20,
                          fit: BoxFit.contain,
                          errorBuilder: (context, error, stack) =>
                              const Icon(Icons.directions_car, size: 20),
                        )
                      : const Icon(Icons.directions_car, size: 20),
                ),
                const SizedBox(width: 8),
                Text(settings.title),
              ],
            ),
            actions: [
              IconButton(
                icon: const Icon(Icons.refresh),
                onPressed: () {
                  context
                      .read<DashboardBloc>()
                      .add(DashboardRefreshRequested());
                },
              ),
            ],
          ),
          body: BlocBuilder<DashboardBloc, DashboardState>(
            builder: (context, state) {
              if (state is DashboardLoading) {
                return const Center(
                  child: Column(
                    mainAxisAlignment: MainAxisAlignment.center,
                    children: [
                      CircularProgressIndicator(
                        color: AppTheme.primaryColor,
                      ),
                      SizedBox(height: 16),
                      Text(
                        'Loading dashboard...',
                        style: TextStyle(color: AppTheme.textSecondary),
                      ),
                    ],
                  ),
                );
              }

              if (state is DashboardError) {
                return Center(
                  child: Column(
                    mainAxisAlignment: MainAxisAlignment.center,
                    children: [
                      const Icon(Icons.error_outline,
                          size: 64, color: AppTheme.errorColor),
                      const SizedBox(height: 16),
                      const Text('Error loading dashboard'),
                      const SizedBox(height: 8),
                      ElevatedButton(
                        onPressed: () {
                          context
                              .read<DashboardBloc>()
                              .add(DashboardLoadRequested());
                        },
                        child: const Text('Retry'),
                      ),
                    ],
                  ),
                );
              }

              if (state is DashboardLoaded) {
                final dashboard = state.dashboard;
                return RefreshIndicator(
                  onRefresh: () async {
                    context
                        .read<DashboardBloc>()
                        .add(DashboardRefreshRequested());
                  },
                  child: SingleChildScrollView(
                    physics: const AlwaysScrollableScrollPhysics(),
                    padding: const EdgeInsets.all(16),
                    child: Column(
                      crossAxisAlignment: CrossAxisAlignment.start,
                      children: [
                        if (dashboard.driver != null) ...[
                          _buildWelcomeCard(
                              context, dashboard.driver!.driverName),
                          const SizedBox(height: 16),
                        ],
                        _buildStatsRow(context, dashboard),
                        const SizedBox(height: 24),
                        if (dashboard.activeTrip != null) ...[
                          _buildSectionTitle(context, 'Active Trip'),
                          const SizedBox(height: 8),
                          TripCard(trip: dashboard.activeTrip!, isActive: true),
                          const SizedBox(height: 24),
                        ],
                        if (dashboard.todayTrips.isNotEmpty) ...[
                          _buildSectionTitle(context,
                              'Today\'s Trips (${dashboard.todayTrips.length})'),
                          const SizedBox(height: 8),
                          ...dashboard.todayTrips.take(3).map((trip) => Padding(
                                padding: const EdgeInsets.only(bottom: 8),
                                child: TripCard(trip: trip),
                              )),
                          const SizedBox(height: 24),
                        ],
                        if (dashboard.upcomingTrips.isNotEmpty) ...[
                          _buildSectionTitle(context, 'Upcoming Trips'),
                          const SizedBox(height: 8),
                          ...dashboard.upcomingTrips
                              .take(3)
                              .map((trip) => Padding(
                                    padding: const EdgeInsets.only(bottom: 8),
                                    child: TripCard(trip: trip),
                                  )),
                          const SizedBox(height: 24),
                        ],
                        if (dashboard.recentTrips.isNotEmpty) ...[
                          _buildSectionTitle(context, 'Recent Completed'),
                          const SizedBox(height: 8),
                          ...dashboard.recentTrips
                              .take(3)
                              .map((trip) => Padding(
                                    padding: const EdgeInsets.only(bottom: 8),
                                    child: TripCard(trip: trip),
                                  )),
                        ],
                        if (dashboard.todayTrips.isEmpty &&
                            dashboard.upcomingTrips.isEmpty &&
                            dashboard.recentTrips.isEmpty &&
                            dashboard.activeTrip == null)
                          _buildEmptyState(context),
                        const SizedBox(height: 16),
                      ],
                    ),
                  ),
                );
              }

              return const Center(child: Text('Welcome to VMS Driver'));
            },
          ),
        );
      },
    );
  }

  Widget _buildWelcomeCard(BuildContext context, String driverName) {
    final now = DateTime.now();
    final greeting = now.hour < 12
        ? 'Good Morning'
        : (now.hour < 17 ? 'Good Afternoon' : 'Good Evening');

    return Card(
      child: Container(
        decoration: BoxDecoration(
          borderRadius: BorderRadius.circular(12),
          gradient: LinearGradient(
            colors: [
              AppTheme.primaryColor,
              AppTheme.primaryColor.withValues(alpha: 0.8)
            ],
            begin: Alignment.topLeft,
            end: Alignment.bottomRight,
          ),
        ),
        padding: const EdgeInsets.all(16),
        child: Row(
          children: [
            Container(
              padding: const EdgeInsets.all(12),
              decoration: BoxDecoration(
                color: Colors.white.withValues(alpha: 0.2),
                borderRadius: BorderRadius.circular(12),
              ),
              child: const Icon(Icons.directions_car,
                  color: Colors.white, size: 32),
            ),
            const SizedBox(width: 16),
            Expanded(
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  Text(
                    '$greeting,',
                    style: Theme.of(context)
                        .textTheme
                        .bodyMedium
                        ?.copyWith(color: Colors.white70),
                  ),
                  Text(
                    driverName,
                    style: Theme.of(context).textTheme.headlineSmall?.copyWith(
                          color: Colors.white,
                          fontWeight: FontWeight.bold,
                        ),
                  ),
                  Text(
                    DateFormat('EEEE, MMMM d, y').format(now),
                    style: Theme.of(context)
                        .textTheme
                        .bodySmall
                        ?.copyWith(color: Colors.white70),
                  ),
                ],
              ),
            ),
          ],
        ),
      ),
    );
  }

  Widget _buildStatsRow(BuildContext context, dashboard) {
    return Row(
      children: [
        Expanded(
          child: StatsCard(
            title: 'Pending',
            value: dashboard.pendingTripsCount.toString(),
            icon: Icons.pending_actions,
            color: AppTheme.warningColor,
          ),
        ),
        const SizedBox(width: 8),
        Expanded(
          child: StatsCard(
            title: 'Active',
            value: dashboard.activeTripsCount.toString(),
            icon: Icons.directions_car,
            color: AppTheme.secondaryColor,
          ),
        ),
        const SizedBox(width: 8),
        Expanded(
          child: StatsCard(
            title: 'Completed',
            value: dashboard.completedTripsCount.toString(),
            icon: Icons.check_circle,
            color: AppTheme.successColor,
          ),
        ),
      ],
    );
  }

  Widget _buildSectionTitle(BuildContext context, String title) {
    return Text(
      title,
      style: Theme.of(context).textTheme.titleLarge,
    );
  }

  Widget _buildEmptyState(BuildContext context) {
    return Center(
      child: Column(
        mainAxisAlignment: MainAxisAlignment.center,
        children: [
          const SizedBox(height: 48),
          Icon(
            Icons.directions_car_outlined,
            size: 64,
            color: AppTheme.textSecondary.withValues(alpha: 0.5),
          ),
          const SizedBox(height: 16),
          Text(
            'No trips assigned',
            style: Theme.of(context)
                .textTheme
                .titleMedium
                ?.copyWith(color: AppTheme.textSecondary),
          ),
          const SizedBox(height: 8),
          Text(
            'Your scheduled trips will appear here',
            style: Theme.of(context)
                .textTheme
                .bodyMedium
                ?.copyWith(color: AppTheme.textSecondary),
          ),
        ],
      ),
    );
  }
}
