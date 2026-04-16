import 'package:flutter/material.dart';
import 'package:intl/intl.dart';
import '../../core/theme/app_theme.dart';
import '../../data/models/fuel_log_model.dart';

class FuelLogCard extends StatelessWidget {
  final FuelLog fuelLog;

  const FuelLogCard({super.key, required this.fuelLog});

  @override
  Widget build(BuildContext context) {
    return Card(
      child: Padding(
        padding: const EdgeInsets.all(16),
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            Row(
              mainAxisAlignment: MainAxisAlignment.spaceBetween,
              children: [
                Row(
                  children: [
                    const Icon(Icons.local_gas_station, color: AppTheme.secondaryColor),
                    const SizedBox(width: 8),
                    Text(
                      fuelLog.vehicleName ?? 'Unknown Vehicle',
                      style: Theme.of(context).textTheme.titleLarge,
                    ),
                  ],
                ),
                Text(
                  fuelLog.vehicleNumber ?? '',
                  style: Theme.of(context).textTheme.bodyMedium?.copyWith(
                    color: AppTheme.textSecondary,
                  ),
                ),
              ],
            ),
            const SizedBox(height: 12),
            Row(
              children: [
                const Icon(Icons.calendar_today, size: 14, color: AppTheme.textSecondary),
                const SizedBox(width: 4),
                Text(
                  fuelLog.fuelDate != null
                    ? DateFormat('MMM d, y').format(fuelLog.fuelDate!)
                    : 'N/A',
                  style: const TextStyle(color: AppTheme.textSecondary),
                ),
              ],
            ),
            const SizedBox(height: 8),
            const Divider(),
            const SizedBox(height: 8),
            Row(
              mainAxisAlignment: MainAxisAlignment.spaceAround,
              children: [
                _buildInfoItem(context, 'Fuel Type', fuelLog.fuelType ?? '-'),
                _buildInfoItem(context, 'Quantity', fuelLog.quantity != null ? '${fuelLog.quantity!.toStringAsFixed(2)} L' : '-'),
                _buildInfoItem(context, 'Cost', fuelLog.cost != null ? '\$${fuelLog.cost!.toStringAsFixed(2)}' : '-'),
              ],
            ),
            if (fuelLog.odometerReading != null) ...[
              const SizedBox(height: 8),
              Row(
                children: [
                  const Icon(Icons.speed, size: 14, color: AppTheme.textSecondary),
                  const SizedBox(width: 4),
                  Text(
                    'Odometer: ${fuelLog.odometerReading!.toStringAsFixed(0)} km',
                    style: const TextStyle(color: AppTheme.textSecondary),
                  ),
                ],
              ),
            ],
            if (fuelLog.location != null) ...[
              const SizedBox(height: 4),
              Row(
                children: [
                  const Icon(Icons.location_on, size: 14, color: AppTheme.textSecondary),
                  const SizedBox(width: 4),
                  Expanded(
                    child: Text(
                      fuelLog.location!,
                      style: const TextStyle(color: AppTheme.textSecondary),
                      maxLines: 1,
                      overflow: TextOverflow.ellipsis,
                    ),
                  ),
                ],
              ),
            ],
            if (fuelLog.notes != null && fuelLog.notes!.isNotEmpty) ...[
              const SizedBox(height: 8),
              Row(
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  const Icon(Icons.note, size: 14, color: AppTheme.textSecondary),
                  const SizedBox(width: 4),
                  Expanded(
                    child: Text(
                      fuelLog.notes!,
                      style: const TextStyle(color: AppTheme.textSecondary),
                      maxLines: 2,
                      overflow: TextOverflow.ellipsis,
                    ),
                  ),
                ],
              ),
            ],
          ],
        ),
      ),
    );
  }

  Widget _buildInfoItem(BuildContext context, String label, String value) {
    return Column(
      children: [
        Text(
          value,
          style: Theme.of(context).textTheme.titleMedium?.copyWith(
            fontWeight: FontWeight.bold,
          ),
        ),
        const SizedBox(height: 2),
        Text(
          label,
          style: Theme.of(context).textTheme.bodySmall,
        ),
      ],
    );
  }
}