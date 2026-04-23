import 'package:flutter/material.dart';
import 'package:flutter_bloc/flutter_bloc.dart';
import '../../core/theme/app_theme.dart';
import '../blocs/dashboard/dashboard_bloc.dart';
import '../blocs/dashboard/dashboard_event.dart';
import 'schedule_page.dart';

class TripStatusPage extends StatefulWidget {
  const TripStatusPage({super.key});

  @override
  State<TripStatusPage> createState() => _TripStatusPageState();
}

class _TripStatusPageState extends State<TripStatusPage> {
  @override
  void initState() {
    super.initState();
    WidgetsBinding.instance.addPostFrameCallback((_) {
      context.read<DashboardBloc>().add(DashboardLoadRequested());
    });
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: const Text('Trip Status'),
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
                  const Icon(Icons.error_outline,
                      size: 64, color: AppTheme.errorColor),
                  const SizedBox(height: 16),
                  const Text('Error loading trip status'),
                  const SizedBox(height: 8),
                  ElevatedButton(
                    onPressed: () {
                      context
                          .read<DashboardBloc>()
                          .add(DashboardRefreshRequested());
                    },
                    child: const Text('Retry'),
                  ),
                ],
              ),
            );
          }

          if (state is DashboardLoaded) {
            final dashboard = state.dashboard;
            final activeTrips = dashboard.assignedTrips
                .where((trip) =>
                    trip.status?.toLowerCase() != 'completed' &&
                    (trip.transportStatus == 'Approved' ||
                        trip.transportStatus == 'Pending' ||
                        trip.transportStatus == 'In Transit'))
                .toList();

            if (activeTrips.isEmpty) {
              return _buildNoActiveTrips(context);
            }

            return _buildActiveTripsList(context, activeTrips);
          }

          return const Center(child: Text('Loading trip status...'));
        },
      ),
    );
  }

  Widget _buildNoActiveTrips(BuildContext context) {
    return Center(
      child: Column(
        mainAxisAlignment: MainAxisAlignment.center,
        children: [
          Icon(
            Icons.directions_car_outlined,
            size: 80,
            color: AppTheme.textSecondary.withValues(alpha: 0.5),
          ),
          const SizedBox(height: 24),
          Text(
            'No Active Trips',
            style: Theme.of(context).textTheme.headlineSmall?.copyWith(
                  color: AppTheme.textSecondary,
                  fontWeight: FontWeight.w600,
                ),
          ),
          const SizedBox(height: 8),
          Text(
            'You have no trips that can be started or ended at this time.',
            textAlign: TextAlign.center,
            style: Theme.of(context).textTheme.bodyMedium?.copyWith(
                  color: AppTheme.textSecondary,
                ),
          ),
          const SizedBox(height: 24),
          ElevatedButton.icon(
            onPressed: () {
              // Navigate to schedule to see upcoming trips
              Navigator.of(context).push(
                MaterialPageRoute(builder: (_) => const SchedulePage()),
              );
            },
            icon: const Icon(Icons.schedule),
            label: const Text('View Schedule'),
          ),
        ],
      ),
    );
  }

  Widget _buildActiveTripsList(BuildContext context, List trips) {
    return RefreshIndicator(
      onRefresh: () async {
        context.read<DashboardBloc>().add(DashboardRefreshRequested());
      },
      child: ListView(
        padding: const EdgeInsets.all(16),
        children: [
          Text(
            'Active Trips',
            style: Theme.of(context).textTheme.titleLarge?.copyWith(
                  fontWeight: FontWeight.w600,
                ),
          ),
          const SizedBox(height: 8),
          Text(
            'Trips that can be started or ended',
            style: Theme.of(context).textTheme.bodyMedium?.copyWith(
                  color: AppTheme.textSecondary,
                ),
          ),
          const SizedBox(height: 16),
          ...trips.map((trip) => Padding(
                padding: const EdgeInsets.only(bottom: 12),
                child: _buildTripStatusCard(context, trip),
              )),
        ],
      ),
    );
  }

  Widget _buildTripStatusCard(BuildContext context, trip) {
    final canStart =
        trip.transportStatus == 'Approved' || trip.transportStatus == 'Pending';
    final canEnd = trip.transportStatus == 'In Transit';

    return Card(
      child: Padding(
        padding: const EdgeInsets.all(16),
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            Row(
              children: [
                Container(
                  padding: const EdgeInsets.all(8),
                  decoration: BoxDecoration(
                    color: canStart
                        ? AppTheme.successColor.withValues(alpha: 0.1)
                        : canEnd
                            ? AppTheme.warningColor.withValues(alpha: 0.1)
                            : AppTheme.primaryColor.withValues(alpha: 0.1),
                    borderRadius: BorderRadius.circular(8),
                  ),
                  child: Icon(
                    canStart
                        ? Icons.play_arrow
                        : canEnd
                            ? Icons.stop
                            : Icons.directions_car,
                    color: canStart
                        ? AppTheme.successColor
                        : canEnd
                            ? AppTheme.warningColor
                            : AppTheme.primaryColor,
                  ),
                ),
                const SizedBox(width: 12),
                Expanded(
                  child: Column(
                    crossAxisAlignment: CrossAxisAlignment.start,
                    children: [
                      Text(
                        'Trip #${trip.requisitionNumber ?? trip.id}',
                        style: const TextStyle(
                          fontWeight: FontWeight.w600,
                          fontSize: 16,
                        ),
                      ),
                      Text(
                        '${trip.fromLocation ?? 'N/A'} → ${trip.toLocation ?? 'N/A'}',
                        style: TextStyle(
                          color: AppTheme.textSecondary,
                          fontSize: 14,
                        ),
                      ),
                      Text(
                        '${trip.travelDate ?? 'N/A'} • ${trip.numberOfPassengers ?? 0} passengers',
                        style: TextStyle(
                          color: AppTheme.textSecondary,
                          fontSize: 12,
                        ),
                      ),
                    ],
                  ),
                ),
                Container(
                  padding:
                      const EdgeInsets.symmetric(horizontal: 8, vertical: 4),
                  decoration: BoxDecoration(
                    color: _getStatusColor(trip.transportStatus)
                        .withValues(alpha: 0.1),
                    borderRadius: BorderRadius.circular(12),
                  ),
                  child: Text(
                    _formatStatus(trip.transportStatus),
                    style: TextStyle(
                      color: _getStatusColor(trip.transportStatus),
                      fontSize: 12,
                      fontWeight: FontWeight.w600,
                    ),
                  ),
                ),
              ],
            ),
            const SizedBox(height: 16),
            if (canStart)
              SizedBox(
                width: double.infinity,
                child: ElevatedButton.icon(
                  onPressed: () => _startTrip(context, trip),
                  icon: const Icon(Icons.play_arrow),
                  label: const Text('Start Trip'),
                  style: ElevatedButton.styleFrom(
                    backgroundColor: AppTheme.successColor,
                  ),
                ),
              )
            else if (canEnd)
              Row(
                children: [
                  Expanded(
                    child: OutlinedButton.icon(
                      onPressed: () => _finishTrip(context, trip),
                      icon: const Icon(Icons.check_circle_outline),
                      label: const Text('Finish Trip'),
                    ),
                  ),
                  const SizedBox(width: 8),
                  Expanded(
                    child: ElevatedButton.icon(
                      onPressed: () => _endTrip(context, trip),
                      icon: const Icon(Icons.stop),
                      label: const Text('End Trip'),
                      style: ElevatedButton.styleFrom(
                        backgroundColor: AppTheme.primaryColor,
                      ),
                    ),
                  ),
                ],
              ),
          ],
        ),
      ),
    );
  }

  Color _getStatusColor(String? status) {
    if (status == null) return AppTheme.textSecondary;
    switch (status.toLowerCase()) {
      case 'pending':
        return AppTheme.warningColor;
      case 'approved':
        return AppTheme.primaryColor;
      case 'in transit':
        return AppTheme.secondaryColor;
      default:
        return AppTheme.textSecondary;
    }
  }

  String _formatStatus(String? status) {
    if (status == null) return 'Unknown';
    switch (status.toLowerCase()) {
      case 'pending':
        return 'Pending';
      case 'approved':
        return 'Approved';
      case 'in transit':
        return 'In Transit';
      default:
        return status;
    }
  }

  void _startTrip(BuildContext context, trip) {
    // TODO: Implement trip start API call
    ScaffoldMessenger.of(context).showSnackBar(
      SnackBar(
        content: const Text('Trip started successfully'),
        backgroundColor: AppTheme.successColor,
      ),
    );
    // Refresh data
    context.read<DashboardBloc>().add(DashboardRefreshRequested());
  }

  void _finishTrip(BuildContext context, trip) {
    // TODO: Implement trip finish API call
    ScaffoldMessenger.of(context).showSnackBar(
      const SnackBar(
        content: Text('Trip finished successfully'),
        backgroundColor: AppTheme.primaryColor,
      ),
    );
    // Refresh data
    context.read<DashboardBloc>().add(DashboardRefreshRequested());
  }

  void _endTrip(BuildContext context, trip) {
    // TODO: Implement trip end API call
    ScaffoldMessenger.of(context).showSnackBar(
      const SnackBar(
        content: Text('Trip ended successfully'),
        backgroundColor: AppTheme.primaryColor,
      ),
    );
    // Refresh data
    context.read<DashboardBloc>().add(DashboardRefreshRequested());
  }
}
