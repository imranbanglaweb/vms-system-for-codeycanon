import 'package:flutter/material.dart';
import 'package:flutter_bloc/flutter_bloc.dart';
import '../../core/theme/app_theme.dart';
import '../blocs/dashboard/dashboard_bloc.dart';
import '../blocs/dashboard/dashboard_event.dart';

class LiveMapPage extends StatefulWidget {
  const LiveMapPage({super.key});

  @override
  State<LiveMapPage> createState() => _LiveMapPageState();
}

class _LiveMapPageState extends State<LiveMapPage> {
  bool _isTrackingEnabled = false;

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
        title: const Text('Live Map & GPS Tracking'),
        actions: [
          Switch(
            value: _isTrackingEnabled,
            onChanged: (value) {
              setState(() {
                _isTrackingEnabled = value;
              });
              if (value) {
                _startTracking();
              } else {
                _stopTracking();
              }
            },
            activeThumbColor: AppTheme.primaryColor,
          ),
          const SizedBox(width: 8),
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
                  const Text('Error loading map data'),
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

          return _buildMapContent(context, state);
        },
      ),
    );
  }

  Widget _buildMapContent(BuildContext context, DashboardState state) {
    return Stack(
      children: [
        // Map Placeholder
        _buildMapPlaceholder(),

        // Status Overlay
        if (!_isTrackingEnabled)
          Positioned(
            top: 16,
            left: 16,
            right: 16,
            child: _buildStatusCard(),
          ),

        // Current Location Info
        if (_isTrackingEnabled)
          Positioned(
            bottom: 100,
            left: 16,
            right: 16,
            child: _buildLocationCard(),
          ),

        // Action Buttons
        Positioned(
          bottom: 16,
          left: 16,
          right: 16,
          child: _buildActionButtons(),
        ),
      ],
    );
  }

  Widget _buildMapPlaceholder() {
    return Container(
      color: Colors.grey[200],
      child: Center(
        child: Column(
          mainAxisAlignment: MainAxisAlignment.center,
          children: [
            Icon(
              Icons.map_outlined,
              size: 80,
              color: AppTheme.textSecondary.withValues(alpha: 0.5),
            ),
            const SizedBox(height: 16),
            const Text(
              'Interactive Map',
              style: TextStyle(
                fontSize: 20,
                fontWeight: FontWeight.w600,
                color: AppTheme.textSecondary,
              ),
            ),
            const SizedBox(height: 8),
            const Text(
              'Map integration will be available in the next update',
              style: TextStyle(
                color: AppTheme.textSecondary,
              ),
              textAlign: TextAlign.center,
            ),
            const SizedBox(height: 24),
            Container(
              padding: const EdgeInsets.all(16),
              decoration: BoxDecoration(
                color: Colors.white,
                borderRadius: BorderRadius.circular(12),
                boxShadow: [
                  BoxShadow(
                    color: Colors.black.withValues(alpha: 0.1),
                    blurRadius: 8,
                    offset: const Offset(0, 2),
                  ),
                ],
              ),
              child: Column(
                children: [
                  const Text(
                    'Current Location',
                    style: TextStyle(
                      fontWeight: FontWeight.w600,
                      color: AppTheme.primaryColor,
                    ),
                  ),
                  const SizedBox(height: 8),
                  Row(
                    mainAxisAlignment: MainAxisAlignment.center,
                    children: [
                      const Icon(Icons.location_on,
                          color: AppTheme.primaryColor),
                      const SizedBox(width: 8),
                      Text(
                        _isTrackingEnabled
                            ? 'Tracking Active'
                            : 'Location services disabled',
                        style: const TextStyle(fontWeight: FontWeight.w500),
                      ),
                    ],
                  ),
                ],
              ),
            ),
          ],
        ),
      ),
    );
  }

  Widget _buildStatusCard() {
    return Card(
      child: Container(
        padding: const EdgeInsets.all(16),
        decoration: BoxDecoration(
          borderRadius: BorderRadius.circular(12),
          gradient: LinearGradient(
            colors: [
              AppTheme.warningColor.withValues(alpha: 0.1),
              AppTheme.warningColor.withValues(alpha: 0.05),
            ],
          ),
        ),
        child: Row(
          children: [
            const Icon(
              Icons.location_off,
              color: AppTheme.warningColor,
            ),
            const SizedBox(width: 12),
            const Expanded(
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  Text(
                    'GPS Tracking Disabled',
                    style: TextStyle(
                      fontWeight: FontWeight.w600,
                      color: AppTheme.warningColor,
                    ),
                  ),
                  Text(
                    'Enable tracking to share your location',
                    style: TextStyle(
                      fontSize: 12,
                      color: AppTheme.textSecondary,
                    ),
                  ),
                ],
              ),
            ),
            Switch(
              value: _isTrackingEnabled,
              onChanged: (value) {
                setState(() {
                  _isTrackingEnabled = value;
                });
                if (value) {
                  _startTracking();
                } else {
                  _stopTracking();
                }
              },
              activeThumbColor: AppTheme.primaryColor,
            ),
          ],
        ),
      ),
    );
  }

  Widget _buildLocationCard() {
    return Card(
      child: Container(
        padding: const EdgeInsets.all(16),
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            Row(
              children: [
                Container(
                  padding: const EdgeInsets.all(8),
                  decoration: BoxDecoration(
                    color: AppTheme.successColor.withValues(alpha: 0.1),
                    borderRadius: BorderRadius.circular(8),
                  ),
                  child: const Icon(
                    Icons.gps_fixed,
                    color: AppTheme.successColor,
                  ),
                ),
                const SizedBox(width: 12),
                const Expanded(
                  child: Column(
                    crossAxisAlignment: CrossAxisAlignment.start,
                    children: [
                      Text(
                        'Live Tracking Active',
                        style: TextStyle(
                          fontWeight: FontWeight.w600,
                          color: AppTheme.successColor,
                        ),
                      ),
                      Text(
                        'Your location is being shared',
                        style: TextStyle(
                          fontSize: 12,
                          color: AppTheme.textSecondary,
                        ),
                      ),
                    ],
                  ),
                ),
              ],
            ),
            const SizedBox(height: 12),
            const Divider(),
            const SizedBox(height: 8),
            Row(
              mainAxisAlignment: MainAxisAlignment.spaceBetween,
              children: [
                _buildLocationInfo('Speed', '0 km/h'),
                _buildLocationInfo('Accuracy', '~10m'),
                _buildLocationInfo('Last Update', 'Now'),
              ],
            ),
          ],
        ),
      ),
    );
  }

  Widget _buildLocationInfo(String label, String value) {
    return Column(
      children: [
        Text(
          label,
          style: const TextStyle(
            fontSize: 12,
            color: AppTheme.textSecondary,
          ),
        ),
        const SizedBox(height: 2),
        Text(
          value,
          style: const TextStyle(
            fontWeight: FontWeight.w600,
            fontSize: 14,
          ),
        ),
      ],
    );
  }

  Widget _buildActionButtons() {
    return Row(
      children: [
        Expanded(
          child: ElevatedButton.icon(
            onPressed: _isTrackingEnabled ? _updateLocation : null,
            icon: Icon(
                _isTrackingEnabled ? Icons.refresh : Icons.refresh_outlined),
            label: const Text('Update Location'),
            style: ElevatedButton.styleFrom(
              padding: const EdgeInsets.symmetric(vertical: 12),
              backgroundColor: _isTrackingEnabled
                  ? AppTheme.primaryColor
                  : AppTheme.textSecondary,
            ),
          ),
        ),
        const SizedBox(width: 12),
        Expanded(
          child: OutlinedButton.icon(
            onPressed: _shareLocation,
            icon: const Icon(Icons.share),
            label: const Text('Share Location'),
            style: OutlinedButton.styleFrom(
              padding: const EdgeInsets.symmetric(vertical: 12),
            ),
          ),
        ),
      ],
    );
  }

  void _startTracking() {
    ScaffoldMessenger.of(context).showSnackBar(
      const SnackBar(
        content: Text('GPS tracking started'),
        backgroundColor: AppTheme.successColor,
      ),
    );
    // TODO: Implement actual GPS tracking start
  }

  void _stopTracking() {
    ScaffoldMessenger.of(context).showSnackBar(
      const SnackBar(
        content: Text('GPS tracking stopped'),
        backgroundColor: AppTheme.warningColor,
      ),
    );
    // TODO: Implement actual GPS tracking stop
  }

  void _updateLocation() {
    ScaffoldMessenger.of(context).showSnackBar(
      const SnackBar(
        content: Text('Location updated'),
        backgroundColor: AppTheme.primaryColor,
      ),
    );
    // TODO: Implement location update
  }

  void _shareLocation() {
    ScaffoldMessenger.of(context).showSnackBar(
      const SnackBar(
        content: Text('Location sharing feature coming soon'),
        backgroundColor: AppTheme.primaryColor,
      ),
    );
    // TODO: Implement location sharing
  }
}
