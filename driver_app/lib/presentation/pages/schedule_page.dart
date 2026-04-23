import 'package:flutter/material.dart';
import 'package:flutter_bloc/flutter_bloc.dart';
import '../../core/theme/app_theme.dart';
import '../blocs/dashboard/dashboard_bloc.dart';
import '../blocs/dashboard/dashboard_event.dart';
import 'trip_status_page.dart';

class SchedulePage extends StatefulWidget {
  const SchedulePage({super.key});

  @override
  State<SchedulePage> createState() => _SchedulePageState();
}

class _SchedulePageState extends State<SchedulePage> {
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
        title: const Text('Schedule'),
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
                  const Text('Error loading schedule'),
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
            final upcomingTrips = dashboard.upcomingTrips;

            if (upcomingTrips.isEmpty) {
              return _buildNoUpcomingTrips(context);
            }

            return _buildScheduleList(context, upcomingTrips);
          }

          return const Center(child: Text('Loading schedule...'));
        },
      ),
    );
  }

  Widget _buildNoUpcomingTrips(BuildContext context) {
    return Center(
      child: Column(
        mainAxisAlignment: MainAxisAlignment.center,
        children: [
          Icon(
            Icons.calendar_today_outlined,
            size: 80,
            color: AppTheme.textSecondary.withValues(alpha: 0.5),
          ),
          const SizedBox(height: 24),
          Text(
            'No Upcoming Trips',
            style: Theme.of(context).textTheme.headlineSmall?.copyWith(
                  color: AppTheme.textSecondary,
                  fontWeight: FontWeight.w600,
                ),
          ),
          const SizedBox(height: 8),
          Text(
            'You have no scheduled trips at this time.',
            textAlign: TextAlign.center,
            style: Theme.of(context).textTheme.bodyMedium?.copyWith(
                  color: AppTheme.textSecondary,
                ),
          ),
          const SizedBox(height: 24),
          ElevatedButton.icon(
            onPressed: () {
              // Navigate to trip status to see active trips
              Navigator.of(context).push(
                MaterialPageRoute(builder: (_) => const TripStatusPage()),
              );
            },
            icon: const Icon(Icons.directions_car),
            label: const Text('Check Active Trips'),
          ),
        ],
      ),
    );
  }

  Widget _buildScheduleList(BuildContext context, List trips) {
    // Group trips by date
    final groupedTrips = <String, List>{};
    for (final trip in trips) {
      final date = trip.travelDate?.split(' ')[0] ?? 'Unknown Date';
      if (!groupedTrips.containsKey(date)) {
        groupedTrips[date] = [];
      }
      groupedTrips[date]!.add(trip);
    }

    final sortedDates = groupedTrips.keys.toList()..sort();

    return RefreshIndicator(
      onRefresh: () async {
        context.read<DashboardBloc>().add(DashboardRefreshRequested());
      },
      child: ListView(
        padding: const EdgeInsets.all(16),
        children: [
          Text(
            'Upcoming Schedule',
            style: Theme.of(context).textTheme.titleLarge?.copyWith(
                  fontWeight: FontWeight.w600,
                ),
          ),
          const SizedBox(height: 8),
          Text(
            'Your scheduled trips for the coming days',
            style: Theme.of(context).textTheme.bodyMedium?.copyWith(
                  color: AppTheme.textSecondary,
                ),
          ),
          const SizedBox(height: 24),
          ...sortedDates.map(
              (date) => _buildDateSection(context, date, groupedTrips[date]!)),
        ],
      ),
    );
  }

  Widget _buildDateSection(BuildContext context, String date, List trips) {
    final displayDate = _formatDisplayDate(date);

    return Column(
      crossAxisAlignment: CrossAxisAlignment.start,
      children: [
        Container(
          padding: const EdgeInsets.symmetric(horizontal: 12, vertical: 8),
          decoration: BoxDecoration(
            color: AppTheme.primaryColor.withValues(alpha: 0.1),
            borderRadius: BorderRadius.circular(8),
          ),
          child: Row(
            children: [
              Icon(
                Icons.calendar_today,
                size: 20,
                color: AppTheme.primaryColor,
              ),
              const SizedBox(width: 8),
              Text(
                displayDate,
                style: TextStyle(
                  fontWeight: FontWeight.w600,
                  color: AppTheme.primaryColor,
                ),
              ),
              const SizedBox(width: 8),
              Container(
                padding: const EdgeInsets.symmetric(horizontal: 8, vertical: 2),
                decoration: BoxDecoration(
                  color: AppTheme.primaryColor,
                  borderRadius: BorderRadius.circular(12),
                ),
                child: Text(
                  '${trips.length} trip${trips.length > 1 ? 's' : ''}',
                  style: const TextStyle(
                    color: Colors.white,
                    fontSize: 12,
                    fontWeight: FontWeight.w500,
                  ),
                ),
              ),
            ],
          ),
        ),
        const SizedBox(height: 12),
        ...trips.map((trip) => Padding(
              padding: const EdgeInsets.only(bottom: 8),
              child: Card(
                child: Padding(
                  padding: const EdgeInsets.all(12),
                  child: Column(
                    crossAxisAlignment: CrossAxisAlignment.start,
                    children: [
                      Row(
                        children: [
                          Container(
                            padding: const EdgeInsets.all(6),
                            decoration: BoxDecoration(
                              color:
                                  AppTheme.primaryColor.withValues(alpha: 0.1),
                              borderRadius: BorderRadius.circular(6),
                            ),
                            child: Icon(
                              Icons.directions_car,
                              size: 18,
                              color: AppTheme.primaryColor,
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
                                    fontSize: 14,
                                  ),
                                ),
                                Text(
                                  '${trip.fromLocation ?? 'N/A'} → ${trip.toLocation ?? 'N/A'}',
                                  style: TextStyle(
                                    color: AppTheme.textSecondary,
                                    fontSize: 12,
                                  ),
                                ),
                              ],
                            ),
                          ),
                          Container(
                            padding: const EdgeInsets.symmetric(
                                horizontal: 6, vertical: 2),
                            decoration: BoxDecoration(
                              color: _getStatusColor(trip.transportStatus)
                                  .withValues(alpha: 0.1),
                              borderRadius: BorderRadius.circular(8),
                            ),
                            child: Text(
                              _formatStatus(trip.transportStatus),
                              style: TextStyle(
                                color: _getStatusColor(trip.transportStatus),
                                fontSize: 10,
                                fontWeight: FontWeight.w600,
                              ),
                            ),
                          ),
                        ],
                      ),
                      const SizedBox(height: 8),
                      Row(
                        children: [
                          Icon(
                            Icons.access_time,
                            size: 14,
                            color: AppTheme.textSecondary,
                          ),
                          const SizedBox(width: 4),
                          Text(
                            trip.travelDate ?? 'Time not set',
                            style: TextStyle(
                              color: AppTheme.textSecondary,
                              fontSize: 12,
                            ),
                          ),
                          const SizedBox(width: 16),
                          Icon(
                            Icons.people,
                            size: 14,
                            color: AppTheme.textSecondary,
                          ),
                          const SizedBox(width: 4),
                          Text(
                            '${trip.numberOfPassengers ?? 0} passengers',
                            style: TextStyle(
                              color: AppTheme.textSecondary,
                              fontSize: 12,
                            ),
                          ),
                        ],
                      ),
                    ],
                  ),
                ),
              ),
            )),
        const SizedBox(height: 16),
      ],
    );
  }

  String _formatDisplayDate(String date) {
    try {
      final dateTime = DateTime.parse(date);
      final now = DateTime.now();
      final today = DateTime(now.year, now.month, now.day);
      final tripDate = DateTime(dateTime.year, dateTime.month, dateTime.day);

      if (tripDate == today) {
        return 'Today';
      } else if (tripDate == today.add(const Duration(days: 1))) {
        return 'Tomorrow';
      } else {
        return '${tripDate.day}/${tripDate.month}/${tripDate.year}';
      }
    } catch (e) {
      return date;
    }
  }

  Color _getStatusColor(String? status) {
    if (status == null) return AppTheme.textSecondary;
    switch (status.toLowerCase()) {
      case 'pending':
        return AppTheme.warningColor;
      case 'approved':
        return AppTheme.primaryColor;
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
      default:
        return status;
    }
  }
}
