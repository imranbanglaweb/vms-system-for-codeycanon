import 'package:flutter/material.dart';
import 'package:flutter_bloc/flutter_bloc.dart';
import 'package:intl/intl.dart';
import '../../core/theme/app_theme.dart';
import '../blocs/dashboard/dashboard_bloc.dart';
import '../blocs/dashboard/dashboard_event.dart';
import '../widgets/trip_card.dart';
import '../widgets/stats_card.dart';

class DashboardPage extends StatelessWidget {
  const DashboardPage({super.key});

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: const Text('Dashboard'),
        actions: [
          IconButton(
            icon: const Icon(Icons.refresh),
            onPressed: () {
              context.read<DashboardBloc>().add(DashboardRefreshRequested());
            },
          ),
        ],
      ),
      body: BlocBuilder<DashboardBloc, DashboardState>(
        builder: (context, state) {
          if (state is DashboardLoading) {
            return const Center(child: CircularProgressIndicator());
          }

          if (state is DashboardError) {
            return Center(
              child: Column(
                mainAxisAlignment: MainAxisAlignment.center,
                children: [
                  const Icon(Icons.error_outline, size: 64, color: AppTheme.errorColor),
                  const SizedBox(height: 16),
                  const Text('Error loading dashboard'),
                  const SizedBox(height: 8),
                  ElevatedButton(
                    onPressed: () {
                      context.read<DashboardBloc>().add(DashboardLoadRequested());
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
                context.read<DashboardBloc>().add(DashboardRefreshRequested());
              },
              child: SingleChildScrollView(
                physics: const AlwaysScrollableScrollPhysics(),
                padding: const EdgeInsets.all(16),
                child: Column(
                  crossAxisAlignment: CrossAxisAlignment.start,
                  children: [
                    if (dashboard.driver != null) ...[
                      _buildWelcomeCard(context, dashboard.driver!.driverName),
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
                      _buildSectionTitle(context, 'Today\'s Trips (${dashboard.todayTrips.length})'),
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
                      ...dashboard.upcomingTrips.take(3).map((trip) => Padding(
                        padding: const EdgeInsets.only(bottom: 8),
                        child: TripCard(trip: trip),
                      )),
                      const SizedBox(height: 24),
                    ],

                    if (dashboard.recentTrips.isNotEmpty) ...[
                      _buildSectionTitle(context, 'Recent Completed'),
                      const SizedBox(height: 8),
                      ...dashboard.recentTrips.take(3).map((trip) => Padding(
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
  }

  Widget _buildWelcomeCard(BuildContext context, String driverName) {
    final now = DateTime.now();
    final greeting = now.hour < 12 ? 'Good Morning' : (now.hour < 17 ? 'Good Afternoon' : 'Good Evening');

    return Card(
      child: Padding(
        padding: const EdgeInsets.all(16),
        child: Row(
          children: [
            const CircleAvatar(
              radius: 24,
              backgroundColor: AppTheme.primaryColor,
              child: Icon(Icons.person, color: Colors.white, size: 28),
            ),
            const SizedBox(width: 16),
            Expanded(
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  Text(
                    '$greeting,',
                    style: Theme.of(context).textTheme.bodyMedium?.copyWith(
                      color: AppTheme.textSecondary,
                    ),
                  ),
                  Text(
                    driverName,
                    style: Theme.of(context).textTheme.headlineSmall,
                  ),
                  Text(
                    DateFormat('EEEE, MMMM d, y').format(now),
                    style: Theme.of(context).textTheme.bodySmall,
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
            style: Theme.of(context).textTheme.titleMedium?.copyWith(
              color: AppTheme.textSecondary,
            ),
          ),
          const SizedBox(height: 8),
          Text(
            'Your scheduled trips will appear here',
            style: Theme.of(context).textTheme.bodyMedium?.copyWith(
              color: AppTheme.textSecondary,
            ),
          ),
        ],
      ),
    );
  }
}