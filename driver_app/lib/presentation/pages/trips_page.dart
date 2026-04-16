import 'package:flutter/material.dart';
import 'package:flutter_bloc/flutter_bloc.dart';
import '../../core/theme/app_theme.dart';
import '../blocs/trips/trips_bloc.dart';
import '../blocs/trips/trips_event.dart';
import '../widgets/trip_card.dart';

class TripsPage extends StatelessWidget {
  const TripsPage({super.key});

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: const Text('My Trips'),
      ),
      body: BlocConsumer<TripsBloc, TripsState>(
        listener: (context, state) {
          if (state is TripActionSuccess) {
            ScaffoldMessenger.of(context).showSnackBar(
              SnackBar(
                content: Text(state.message),
                backgroundColor: AppTheme.successColor,
              ),
            );
          }
          if (state is TripsError) {
            ScaffoldMessenger.of(context).showSnackBar(
              SnackBar(
                content: Text(state.message),
                backgroundColor: AppTheme.errorColor,
              ),
            );
          }
        },
        builder: (context, state) {
          if (state is TripsLoading) {
            return const Center(child: CircularProgressIndicator());
          }

          if (state is TripsLoaded) {
            if (state.trips.isEmpty) {
              return _buildEmptyState(context);
            }

            return RefreshIndicator(
              onRefresh: () async {
                context.read<TripsBloc>().add(TripsLoadRequested());
              },
              child: ListView.builder(
                padding: const EdgeInsets.all(16),
                itemCount: state.trips.length,
                itemBuilder: (context, index) {
                  final trip = state.trips[index];
                  return Padding(
                    padding: const EdgeInsets.only(bottom: 12),
                    child: TripCard(
                      trip: trip,
                      showActions: true,
                      onStart: () {
                        _showConfirmationDialog(
                          context,
                          'Start Trip',
                          'Are you sure you want to start this trip?',
                          () => context.read<TripsBloc>().add(TripStartRequested(tripId: trip.id)),
                        );
                      },
                      onFinish: () {
                        _showConfirmationDialog(
                          context,
                          'Finish Trip',
                          'Are you sure you want to finish this trip?',
                          () => context.read<TripsBloc>().add(TripFinishRequested(tripId: trip.id)),
                        );
                      },
                      onEnd: () {
                        _showConfirmationDialog(
                          context,
                          'Complete Trip',
                          'Are you sure you want to complete this trip?',
                          () => context.read<TripsBloc>().add(TripEndRequested(tripId: trip.id)),
                        );
                      },
                    ),
                  );
                },
              ),
            );
          }

          if (state is TripsUpdating) {
            return const Center(child: CircularProgressIndicator());
          }

          return _buildEmptyState(context);
        },
      ),
    );
  }

  Widget _buildEmptyState(BuildContext context) {
    return Center(
      child: Column(
        mainAxisAlignment: MainAxisAlignment.center,
        children: [
          Icon(
            Icons.directions_car_outlined,
            size: 64,
            color: AppTheme.textSecondary.withValues(alpha: 0.5),
          ),
          const SizedBox(height: 16),
          Text(
            'No trips found',
            style: Theme.of(context).textTheme.titleMedium?.copyWith(
              color: AppTheme.textSecondary,
            ),
          ),
          const SizedBox(height: 8),
          Text(
            'Your trips will appear here',
            style: Theme.of(context).textTheme.bodyMedium?.copyWith(
              color: AppTheme.textSecondary,
            ),
          ),
        ],
      ),
    );
  }

  void _showConfirmationDialog(
    BuildContext context,
    String title,
    String message,
    VoidCallback onConfirm,
  ) {
    showDialog(
      context: context,
      builder: (context) => AlertDialog(
        title: Text(title),
        content: Text(message),
        actions: [
          TextButton(
            onPressed: () => Navigator.pop(context),
            child: const Text('Cancel'),
          ),
          ElevatedButton(
            onPressed: () {
              Navigator.pop(context);
              onConfirm();
            },
            child: const Text('Confirm'),
          ),
        ],
      ),
    );
  }
}