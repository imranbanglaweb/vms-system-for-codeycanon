import 'package:flutter/material.dart';
import 'package:intl/intl.dart';
import '../../core/theme/app_theme.dart';
import '../../data/models/trip_model.dart';

class TripCard extends StatelessWidget {
  final Trip trip;
  final bool isActive;
  final bool showActions;
  final VoidCallback? onStart;
  final VoidCallback? onFinish;
  final VoidCallback? onEnd;

  const TripCard({
    super.key,
    required this.trip,
    this.isActive = false,
    this.showActions = false,
    this.onStart,
    this.onFinish,
    this.onEnd,
  });

  @override
  Widget build(BuildContext context) {
    final statusColor = AppTheme.getStatusColor(trip.transportStatus ?? '');
    
    return Card(
      color: isActive ? AppTheme.secondaryColor.withValues(alpha: 0.1) : null,
      child: Padding(
        padding: const EdgeInsets.all(16),
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            Row(
              mainAxisAlignment: MainAxisAlignment.spaceBetween,
              children: [
                Text(
                  trip.requisitionNumber,
                  style: Theme.of(context).textTheme.titleLarge,
                ),
                Container(
                  padding: const EdgeInsets.symmetric(horizontal: 10, vertical: 4),
                  decoration: BoxDecoration(
                    color: statusColor.withValues(alpha: 0.1),
                    borderRadius: BorderRadius.circular(12),
                    border: Border.all(color: statusColor),
                  ),
                  child: Text(
                    trip.transportStatus ?? 'Pending',
                    style: TextStyle(
                      color: statusColor,
                      fontWeight: FontWeight.bold,
                      fontSize: 12,
                    ),
                  ),
                ),
              ],
            ),
            const SizedBox(height: 12),
            Row(
              children: [
                const Icon(Icons.location_on, size: 16, color: AppTheme.textSecondary),
                const SizedBox(width: 4),
                Expanded(child: Text(trip.fromLocation ?? 'N/A', style: const TextStyle(fontWeight: FontWeight.w500))),
              ],
            ),
            const SizedBox(height: 4),
            Row(
              children: [
                const Icon(Icons.flag, size: 16, color: AppTheme.textSecondary),
                const SizedBox(width: 4),
                Expanded(child: Text(trip.toLocation ?? 'N/A', style: const TextStyle(fontWeight: FontWeight.w500))),
              ],
            ),
            const SizedBox(height: 12),
            Row(
              children: [
                const Icon(Icons.calendar_today, size: 14, color: AppTheme.textSecondary),
                const SizedBox(width: 4),
                Text(
                  trip.travelDate != null 
                    ? DateFormat('MMM d, y').format(trip.travelDate!) 
                    : 'N/A',
                  style: const TextStyle(color: AppTheme.textSecondary),
                ),
                if (trip.travelTime != null) ...[
                  const SizedBox(width: 16),
                  const Icon(Icons.access_time, size: 14, color: AppTheme.textSecondary),
                  const SizedBox(width: 4),
                  Text(trip.travelTime!, style: const TextStyle(color: AppTheme.textSecondary)),
                ],
              ],
            ),
            if (trip.vehicleName != null) ...[
              const SizedBox(height: 8),
              Row(
                children: [
                  const Icon(Icons.directions_car, size: 14, color: AppTheme.textSecondary),
                  const SizedBox(width: 4),
                  Text('${trip.vehicleName} (${trip.vehicleNumber ?? 'N/A'})', style: const TextStyle(color: AppTheme.textSecondary)),
                ],
              ),
            ],
            if (trip.purpose != null) ...[
              const SizedBox(height: 8),
              Text(trip.purpose!, style: const TextStyle(color: AppTheme.textSecondary), maxLines: 2, overflow: TextOverflow.ellipsis),
            ],
            if (showActions && _hasActions()) ...[
              const SizedBox(height: 16),
              const Divider(),
              _buildActionButtons(),
            ],
          ],
        ),
      ),
    );
  }

  bool _hasActions() {
    return trip.isApproved || trip.isInTransit;
  }

  Widget _buildActionButtons() {
    if (trip.isApproved && !trip.isInTransit) {
      return SizedBox(
        width: double.infinity,
        child: ElevatedButton.icon(
          onPressed: onStart,
          icon: const Icon(Icons.play_arrow),
          label: const Text('Start Trip'),
        ),
      );
    }
    
    if (trip.isInTransit) {
      return Row(
        children: [
          Expanded(
            child: OutlinedButton.icon(
              onPressed: onFinish,
              icon: const Icon(Icons.pause),
              label: const Text('Finish'),
            ),
          ),
          const SizedBox(width: 12),
          Expanded(
            child: ElevatedButton.icon(
              onPressed: onEnd,
              icon: const Icon(Icons.check),
              label: const Text('Complete'),
            ),
          ),
        ],
      );
    }
    
    return const SizedBox.shrink();
  }
}