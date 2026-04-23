import 'package:flutter/material.dart';
import 'package:flutter_bloc/flutter_bloc.dart';
import '../../core/theme/app_theme.dart';
import '../blocs/dashboard/dashboard_bloc.dart';
import '../blocs/dashboard/dashboard_event.dart';

class MyTripsPage extends StatefulWidget {
  const MyTripsPage({super.key});

  @override
  State<MyTripsPage> createState() => _MyTripsPageState();
}

class _MyTripsPageState extends State<MyTripsPage>
    with SingleTickerProviderStateMixin {
  late TabController _tabController;

  @override
  void initState() {
    super.initState();
    _tabController = TabController(length: 3, vsync: this);
    WidgetsBinding.instance.addPostFrameCallback((_) {
      context.read<DashboardBloc>().add(DashboardLoadRequested());
    });
  }

  @override
  void dispose() {
    _tabController.dispose();
    super.dispose();
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: const Text('My Trips'),
        actions: [
          IconButton(
            icon: const Icon(Icons.refresh),
            onPressed: () {
              context.read<DashboardBloc>().add(DashboardRefreshRequested());
            },
          ),
        ],
        bottom: TabBar(
          controller: _tabController,
          tabs: const [
            Tab(text: 'All'),
            Tab(text: 'Active'),
            Tab(text: 'Completed'),
          ],
        ),
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
                  const Text('Error loading trips'),
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
            final allTrips = [
              ...dashboard.assignedTrips,
              ...dashboard.todayTrips,
              ...dashboard.upcomingTrips,
              ...dashboard.recentTrips,
            ];

            // Remove duplicates based on ID
            final uniqueTrips = <dynamic>{};
            final filteredTrips = allTrips.where((trip) {
              if (uniqueTrips.contains(trip.id)) {
                return false;
              }
              uniqueTrips.add(trip.id);
              return true;
            }).toList();

            final activeTrips = filteredTrips
                .where((trip) =>
                    trip.status?.toLowerCase() != 'completed' &&
                    (trip.transportStatus == 'Approved' ||
                        trip.transportStatus == 'Pending' ||
                        trip.transportStatus == 'In Transit'))
                .toList();

            final completedTrips = filteredTrips
                .where((trip) =>
                    trip.status?.toLowerCase() == 'completed' ||
                    trip.transportStatus == 'Completed')
                .toList();

            return TabBarView(
              controller: _tabController,
              children: [
                _buildTripsList(context, filteredTrips, 'No trips found'),
                _buildTripsList(context, activeTrips, 'No active trips'),
                _buildTripsList(context, completedTrips, 'No completed trips'),
              ],
            );
          }

          return const Center(child: Text('Loading trips...'));
        },
      ),
    );
  }

  Widget _buildTripsList(
      BuildContext context, List trips, String emptyMessage) {
    if (trips.isEmpty) {
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
              emptyMessage,
              style: Theme.of(context).textTheme.headlineSmall?.copyWith(
                    color: AppTheme.textSecondary,
                    fontWeight: FontWeight.w600,
                  ),
            ),
          ],
        ),
      );
    }

    return RefreshIndicator(
      onRefresh: () async {
        context.read<DashboardBloc>().add(DashboardRefreshRequested());
      },
      child: ListView.builder(
        padding: const EdgeInsets.all(16),
        itemCount: trips.length,
        itemBuilder: (context, index) {
          final trip = trips[index];
          return Padding(
            padding: const EdgeInsets.only(bottom: 12),
            child: _buildTripCard(context, trip),
          );
        },
      ),
    );
  }

  Widget _buildTripCard(BuildContext context, trip) {
    final isCompleted = trip.status?.toLowerCase() == 'completed' ||
        trip.transportStatus == 'Completed';
    final isActive = trip.transportStatus == 'In Transit';

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
                    color: isCompleted
                        ? AppTheme.successColor.withValues(alpha: 0.1)
                        : isActive
                            ? AppTheme.secondaryColor.withValues(alpha: 0.1)
                            : AppTheme.primaryColor.withValues(alpha: 0.1),
                    borderRadius: BorderRadius.circular(8),
                  ),
                  child: Icon(
                    isCompleted ? Icons.check_circle : Icons.directions_car,
                    color: isCompleted
                        ? AppTheme.successColor
                        : isActive
                            ? AppTheme.secondaryColor
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
                        style: const TextStyle(
                          color: AppTheme.textSecondary,
                          fontSize: 14,
                        ),
                      ),
                      Text(
                        '${trip.travelDate ?? 'N/A'} • ${trip.numberOfPassengers ?? 0} passengers',
                        style: const TextStyle(
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
            if (trip.assignedVehicle != null) ...[
              const SizedBox(height: 12),
              Container(
                padding: const EdgeInsets.all(8),
                decoration: BoxDecoration(
                  color: AppTheme.surfaceColor,
                  borderRadius: BorderRadius.circular(8),
                  border: Border.all(color: AppTheme.borderColor),
                ),
                child: Row(
                  children: [
                    const Icon(
                      Icons.directions_car,
                      size: 16,
                      color: AppTheme.textSecondary,
                    ),
                    const SizedBox(width: 8),
                    Text(
                      trip.assignedVehicle.vehicleName ?? 'Assigned Vehicle',
                      style: const TextStyle(
                        color: AppTheme.textSecondary,
                        fontSize: 12,
                      ),
                    ),
                    if (trip.assignedVehicle.numberPlate != null) ...[
                      const SizedBox(width: 8),
                      Container(
                        padding: const EdgeInsets.symmetric(
                            horizontal: 6, vertical: 2),
                        decoration: BoxDecoration(
                          color: AppTheme.primaryColor.withValues(alpha: 0.1),
                          borderRadius: BorderRadius.circular(4),
                        ),
                        child: Text(
                          trip.assignedVehicle.numberPlate!,
                          style: const TextStyle(
                            color: AppTheme.primaryColor,
                            fontSize: 10,
                            fontWeight: FontWeight.w600,
                          ),
                        ),
                      ),
                    ],
                  ],
                ),
              ),
            ],
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
      case 'completed':
        return AppTheme.successColor;
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
      case 'completed':
        return 'Completed';
      default:
        return status;
    }
  }
}
