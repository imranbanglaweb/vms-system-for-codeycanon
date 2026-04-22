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
                        _buildWelcomeBanner(context, dashboard),
                        const SizedBox(height: 16),
                        _buildStatsRow(context, dashboard),
                        const SizedBox(height: 24),
                        _buildQuickLinks(context),
                        const SizedBox(height: 24),
                        if (dashboard.activeTrip != null) ...[
                          _buildSectionTitle(context, 'Active Trip'),
                          const SizedBox(height: 8),
                          TripCard(trip: dashboard.activeTrip!, isActive: true),
                          const SizedBox(height: 24),
                        ],
                        if (dashboard.assignedTrips.isNotEmpty) ...[
                          _buildSectionTitle(context,
                              'Active Trips (${dashboard.assignedTrips.length})'),
                          const SizedBox(height: 8),
                          ...dashboard.assignedTrips
                              .take(3)
                              .map((trip) => Padding(
                                    padding: const EdgeInsets.only(bottom: 8),
                                    child: TripCard(trip: trip),
                                  )),
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
                            dashboard.activeTrip == null &&
                            dashboard.assignedTrips.isEmpty)
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

  Widget _buildWelcomeBanner(BuildContext context, dashboard) {
    final now = DateTime.now();
    final greeting = now.hour < 12
        ? 'Good Morning'
        : (now.hour < 17 ? 'Good Afternoon' : 'Good Evening');

    String driverName = 'Driver';
    String availabilityStatus = 'available';

    if (dashboard.driver != null) {
      driverName = dashboard.driver!.driverName ?? 'Driver';
      availabilityStatus = dashboard.driver!.availabilityStatus ?? 'available';
    }

    final isAvailable = availabilityStatus == 'available';
    final isOnLeave = availabilityStatus == 'on_leave';

    return Container(
      decoration: BoxDecoration(
        borderRadius: BorderRadius.circular(12),
        gradient: const LinearGradient(
          colors: [Color(0xFF1a1a2e), Color(0xFF16213e)],
          begin: Alignment.topLeft,
          end: Alignment.bottomRight,
        ),
      ),
      padding: const EdgeInsets.all(16),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          Row(
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
                      style:
                          Theme.of(context).textTheme.headlineSmall?.copyWith(
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
              Container(
                padding:
                    const EdgeInsets.symmetric(horizontal: 14, vertical: 6),
                decoration: BoxDecoration(
                  borderRadius: BorderRadius.circular(20),
                  color: isAvailable
                      ? AppTheme.successColor
                      : isOnLeave
                          ? AppTheme.errorColor
                          : AppTheme.warningColor,
                ),
                child: Row(
                  mainAxisSize: MainAxisSize.min,
                  children: [
                    Container(
                      width: 8,
                      height: 8,
                      decoration: const BoxDecoration(
                        color: Colors.white,
                        shape: BoxShape.circle,
                      ),
                    ),
                    const SizedBox(width: 6),
                    Text(
                      _formatStatus(availabilityStatus),
                      style: const TextStyle(
                        color: Colors.white,
                        fontWeight: FontWeight.w600,
                        fontSize: 13,
                      ),
                    ),
                  ],
                ),
              ),
            ],
          ),
        ],
      ),
    );
  }

  String _formatStatus(String status) {
    if (status == 'available') return 'Available';
    if (status == 'on_leave') return 'On Leave';
    if (status == 'unavailable') return 'Unavailable';
    return status.substring(0, 1).toUpperCase() + status.substring(1);
  }

  Widget _buildStatsRow(BuildContext context, dashboard) {
    return Row(
      children: [
        Expanded(
          child: StatsCard(
            title: 'Pending Trips',
            value: dashboard.pendingTripsCount.toString(),
            icon: Icons.pending_actions,
            color: AppTheme.warningColor,
          ),
        ),
        const SizedBox(width: 8),
        Expanded(
          child: StatsCard(
            title: 'In Transit',
            value: dashboard.activeTripsCount.toString(),
            icon: Icons.directions_car,
            color: AppTheme.secondaryColor,
          ),
        ),
        const SizedBox(width: 8),
        Expanded(
          child: StatsCard(
            title: 'Completed Today',
            value: dashboard.completedTripsCount.toString(),
            icon: Icons.check_circle,
            color: AppTheme.successColor,
          ),
        ),
        const SizedBox(width: 8),
        Expanded(
          child: StatsCard(
            title: 'Total Assigned',
            value: dashboard.assignedTrips.length.toString(),
            icon: Icons.calendar_today,
            color: Colors.grey,
          ),
        ),
      ],
    );
  }

  Widget _buildQuickLinks(BuildContext context) {
    return Column(
      crossAxisAlignment: CrossAxisAlignment.start,
      children: [
        _buildSectionTitle(context, 'Quick Actions'),
        const SizedBox(height: 12),
        Row(
          children: [
            Expanded(
              child: _buildQuickLinkCard(
                context,
                icon: Icons.map_outlined,
                title: 'Live Map',
                subtitle: 'GPS Tracking',
                onTap: () {},
              ),
            ),
            const SizedBox(width: 8),
            Expanded(
              child: _buildQuickLinkCard(
                context,
                icon: Icons.playlist_add_check,
                title: 'Trip Status',
                subtitle: 'Start/End trips',
                onTap: () {},
              ),
            ),
            const SizedBox(width: 8),
            Expanded(
              child: _buildQuickLinkCard(
                context,
                icon: Icons.calendar_today_outlined,
                title: 'Schedule',
                subtitle: 'View upcoming',
                onTap: () {},
              ),
            ),
          ],
        ),
        const SizedBox(height: 8),
        Row(
          children: [
            Expanded(
              child: _buildQuickLinkCard(
                context,
                icon: Icons.list_alt_outlined,
                title: 'My Trips',
                subtitle: 'All trips',
                onTap: () {},
              ),
            ),
            const SizedBox(width: 8),
            Expanded(
              child: _buildQuickLinkCard(
                context,
                icon: Icons.access_time_outlined,
                title: 'Availability',
                subtitle: 'Update status',
                onTap: () {},
              ),
            ),
            const SizedBox(width: 8),
            Expanded(
              child: _buildQuickLinkCard(
                context,
                icon: Icons.local_gas_station_outlined,
                title: 'Fuel Log',
                subtitle: 'Log fuel',
                onTap: () {},
              ),
            ),
            const SizedBox(width: 8),
            Expanded(
              child: _buildQuickLinkCard(
                context,
                icon: Icons.directions_car_outlined,
                title: 'My Vehicle',
                subtitle: 'View details',
                onTap: () {},
              ),
            ),
          ],
        ),
      ],
    );
  }

  Widget _buildQuickLinkCard(
    BuildContext context, {
    required IconData icon,
    required String title,
    required String subtitle,
    required VoidCallback onTap,
  }) {
    return InkWell(
      onTap: onTap,
      borderRadius: BorderRadius.circular(12),
      child: Container(
        padding: const EdgeInsets.symmetric(vertical: 16, horizontal: 8),
        decoration: BoxDecoration(
          color: Colors.white,
          borderRadius: BorderRadius.circular(12),
          border: Border.all(color: AppTheme.borderColor),
        ),
        child: Column(
          children: [
            Icon(icon, size: 24, color: AppTheme.primaryColor),
            const SizedBox(height: 6),
            Text(
              title,
              style: const TextStyle(
                fontWeight: FontWeight.w600,
                fontSize: 12,
                color: AppTheme.textPrimary,
              ),
              textAlign: TextAlign.center,
            ),
            Text(
              subtitle,
              style: const TextStyle(
                fontSize: 10,
                color: AppTheme.textSecondary,
              ),
              textAlign: TextAlign.center,
            ),
          ],
        ),
      ),
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
