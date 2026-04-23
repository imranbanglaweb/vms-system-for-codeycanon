import 'package:flutter/material.dart';
import 'package:flutter_bloc/flutter_bloc.dart';
import '../../core/di/injection_container.dart';
import '../../core/theme/app_theme.dart';
import '../../data/repositories/driver_repository.dart';
import '../blocs/dashboard/dashboard_bloc.dart';
import '../blocs/dashboard/dashboard_event.dart';

class AvailabilityPage extends StatefulWidget {
  const AvailabilityPage({super.key});

  @override
  State<AvailabilityPage> createState() => _AvailabilityPageState();
}

class _AvailabilityPageState extends State<AvailabilityPage> {
  String _currentStatus = 'available';
  final TextEditingController _notesController = TextEditingController();

  @override
  void initState() {
    super.initState();
    // Load current availability status from dashboard
    WidgetsBinding.instance.addPostFrameCallback((_) {
      context.read<DashboardBloc>().add(DashboardLoadRequested());
    });
  }

  @override
  void dispose() {
    _notesController.dispose();
    super.dispose();
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: const Text('Availability Status'),
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
                  const Text('Error loading availability status'),
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
            if (dashboard.driver != null) {
              _currentStatus =
                  dashboard.driver!.availabilityStatus ?? 'available';
            }
          }

          return _buildAvailabilityContent(context);
        },
      ),
    );
  }

  Widget _buildAvailabilityContent(BuildContext context) {
    return SingleChildScrollView(
      padding: const EdgeInsets.all(16),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          // Current Status Card
          Card(
            child: Container(
              padding: const EdgeInsets.all(20),
              decoration: BoxDecoration(
                borderRadius: BorderRadius.circular(12),
                gradient: LinearGradient(
                  colors: [
                    _getStatusColor(_currentStatus).withValues(alpha: 0.1),
                    _getStatusColor(_currentStatus).withValues(alpha: 0.05),
                  ],
                  begin: Alignment.topLeft,
                  end: Alignment.bottomRight,
                ),
              ),
              child: Column(
                children: [
                  Container(
                    padding: const EdgeInsets.all(16),
                    decoration: BoxDecoration(
                      color: _getStatusColor(_currentStatus),
                      borderRadius: BorderRadius.circular(12),
                    ),
                    child: Icon(
                      _getStatusIcon(_currentStatus),
                      size: 32,
                      color: Colors.white,
                    ),
                  ),
                  const SizedBox(height: 16),
                  Text(
                    'Current Status',
                    style: Theme.of(context).textTheme.bodyMedium?.copyWith(
                          color: AppTheme.textSecondary,
                        ),
                  ),
                  const SizedBox(height: 4),
                  Text(
                    _formatStatus(_currentStatus),
                    style: Theme.of(context).textTheme.headlineSmall?.copyWith(
                          fontWeight: FontWeight.bold,
                          color: _getStatusColor(_currentStatus),
                        ),
                  ),
                ],
              ),
            ),
          ),

          const SizedBox(height: 24),

          // Status Options
          Text(
            'Update Status',
            style: Theme.of(context).textTheme.titleLarge?.copyWith(
                  fontWeight: FontWeight.w600,
                ),
          ),
          const SizedBox(height: 16),

          _buildStatusOption(
            context,
            status: 'available',
            title: 'Available',
            description: 'Ready to accept new trips',
            icon: Icons.check_circle,
          ),
          const SizedBox(height: 12),

          _buildStatusOption(
            context,
            status: 'on_leave',
            title: 'On Leave',
            description: 'Temporarily unavailable',
            icon: Icons.beach_access,
          ),
          const SizedBox(height: 12),

          _buildStatusOption(
            context,
            status: 'unavailable',
            title: 'Unavailable',
            description: 'Not available for trips',
            icon: Icons.cancel,
          ),

          const SizedBox(height: 24),

          // Notes Section
          Text(
            'Additional Notes (Optional)',
            style: Theme.of(context).textTheme.titleLarge?.copyWith(
                  fontWeight: FontWeight.w600,
                ),
          ),
          const SizedBox(height: 16),

          TextFormField(
            controller: _notesController,
            maxLines: 3,
            decoration: const InputDecoration(
              hintText: 'Add any additional notes about your availability...',
              border: OutlineInputBorder(),
            ),
          ),

          const SizedBox(height: 24),

          // Update Button
          SizedBox(
            width: double.infinity,
            child: ElevatedButton(
              onPressed: _updateAvailability,
              style: ElevatedButton.styleFrom(
                padding: const EdgeInsets.symmetric(vertical: 16),
              ),
              child: const Text('Update Availability'),
            ),
          ),

          const SizedBox(height: 16),

          // Info Text
          Container(
            padding: const EdgeInsets.all(16),
            decoration: BoxDecoration(
              color: AppTheme.primaryColor.withValues(alpha: 0.1),
              borderRadius: BorderRadius.circular(8),
              border: Border.all(
                  color: AppTheme.primaryColor.withValues(alpha: 0.2)),
            ),
            child: const Row(
              children: [
                Icon(
                  Icons.info_outline,
                  color: AppTheme.primaryColor,
                ),
                SizedBox(width: 12),
                Expanded(
                  child: Text(
                    'Your availability status affects trip assignments. Make sure to update it when your situation changes.',
                    style: TextStyle(
                      color: AppTheme.primaryColor,
                      fontSize: 14,
                    ),
                  ),
                ),
              ],
            ),
          ),
        ],
      ),
    );
  }

  Widget _buildStatusOption(
    BuildContext context, {
    required String status,
    required String title,
    required String description,
    required IconData icon,
  }) {
    final isSelected = _currentStatus == status;

    return InkWell(
      onTap: () {
        setState(() {
          _currentStatus = status;
        });
      },
      borderRadius: BorderRadius.circular(12),
      child: Container(
        padding: const EdgeInsets.all(16),
        decoration: BoxDecoration(
          color: isSelected
              ? _getStatusColor(status).withValues(alpha: 0.1)
              : Colors.white,
          borderRadius: BorderRadius.circular(12),
          border: Border.all(
            color: isSelected ? _getStatusColor(status) : AppTheme.borderColor,
            width: isSelected ? 2 : 1,
          ),
        ),
        child: Row(
          children: [
            Container(
              padding: const EdgeInsets.all(8),
              decoration: BoxDecoration(
                color: _getStatusColor(status).withValues(alpha: 0.1),
                borderRadius: BorderRadius.circular(8),
              ),
              child: Icon(
                icon,
                color: _getStatusColor(status),
                size: 24,
              ),
            ),
            const SizedBox(width: 16),
            Expanded(
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  Text(
                    title,
                    style: TextStyle(
                      fontWeight: FontWeight.w600,
                      color: isSelected
                          ? _getStatusColor(status)
                          : AppTheme.textPrimary,
                    ),
                  ),
                  Text(
                    description,
                    style: const TextStyle(
                      fontSize: 12,
                      color: AppTheme.textSecondary,
                    ),
                  ),
                ],
              ),
            ),
            if (isSelected)
              Icon(
                Icons.check_circle,
                color: _getStatusColor(status),
              ),
          ],
        ),
      ),
    );
  }

  Color _getStatusColor(String status) {
    switch (status) {
      case 'available':
        return AppTheme.successColor;
      case 'on_leave':
        return AppTheme.warningColor;
      case 'unavailable':
        return AppTheme.errorColor;
      default:
        return AppTheme.textSecondary;
    }
  }

  IconData _getStatusIcon(String status) {
    switch (status) {
      case 'available':
        return Icons.check_circle;
      case 'on_leave':
        return Icons.beach_access;
      case 'unavailable':
        return Icons.cancel;
      default:
        return Icons.help;
    }
  }

  String _formatStatus(String status) {
    switch (status) {
      case 'available':
        return 'Available';
      case 'on_leave':
        return 'On Leave';
      case 'unavailable':
        return 'Unavailable';
      default:
        return status;
    }
  }

  Future<void> _updateAvailability() async {
    try {
      // Get the repository from dependency injection
      final repository = getIt<DriverRepository>();

      // Prepare the data to send
      final data = {
        'availability_status': _currentStatus,
        'availability_notes': _notesController.text.trim().isNotEmpty
            ? _notesController.text.trim()
            : null,
      };

      // Call the API
      await repository.updateAvailability(data);

      // Show success message
      if (mounted) {
        ScaffoldMessenger.of(context).showSnackBar(
          SnackBar(
            content: Text(
                'Availability updated to ${_formatStatus(_currentStatus)}'),
            backgroundColor: AppTheme.successColor,
          ),
        );

        // Refresh dashboard data to reflect the changes
        context.read<DashboardBloc>().add(DashboardRefreshRequested());
      }
    } catch (e) {
      // Show error message
      if (mounted) {
        ScaffoldMessenger.of(context).showSnackBar(
          SnackBar(
            content: Text('Failed to update availability: ${e.toString()}'),
            backgroundColor: AppTheme.errorColor,
          ),
        );
      }
    }
  }
}
