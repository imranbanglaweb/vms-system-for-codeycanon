import 'dart:async';
import 'package:flutter/material.dart';
import 'package:flutter_bloc/flutter_bloc.dart';
import 'package:geolocator/geolocator.dart';
import 'package:share_plus/share_plus.dart';
import '../../core/di/injection_container.dart';
import '../../core/theme/app_theme.dart';
import '../../data/repositories/driver_repository.dart';
import '../blocs/dashboard/dashboard_bloc.dart';
import '../blocs/dashboard/dashboard_event.dart';

class LiveMapPage extends StatefulWidget {
  const LiveMapPage({super.key});

  @override
  State<LiveMapPage> createState() => _LiveMapPageState();
}

class _LiveMapPageState extends State<LiveMapPage> {
  bool _isTrackingEnabled = false;
  StreamSubscription<Position>? _locationSubscription;

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
            onPressed: _isTrackingEnabled ? _manualLocationUpdate : null,
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

  Future<void> _startTracking() async {
    try {
      // Check location permissions
      LocationPermission permission = await Geolocator.checkPermission();
      if (permission == LocationPermission.denied) {
        permission = await Geolocator.requestPermission();
        if (permission == LocationPermission.denied) {
          if (mounted) {
            ScaffoldMessenger.of(context).showSnackBar(
              const SnackBar(
                content:
                    Text('Location permissions are required for GPS tracking'),
                backgroundColor: AppTheme.errorColor,
              ),
            );
          }
          return;
        }
      }

      if (permission == LocationPermission.deniedForever) {
        if (mounted) {
          ScaffoldMessenger.of(context).showSnackBar(
            const SnackBar(
              content: Text(
                  'Location permissions are permanently denied. Please enable them in settings.'),
              backgroundColor: AppTheme.errorColor,
            ),
          );
        }
        return;
      }

      // Check if location services are enabled
      bool serviceEnabled = await Geolocator.isLocationServiceEnabled();
      if (!serviceEnabled) {
        if (mounted) {
          ScaffoldMessenger.of(context).showSnackBar(
            const SnackBar(
              content:
                  Text('Location services are disabled. Please enable them.'),
              backgroundColor: AppTheme.errorColor,
            ),
          );
        }
        return;
      }

      // Start location tracking
      const LocationSettings locationSettings = LocationSettings(
        accuracy: LocationAccuracy.high,
        distanceFilter: 10, // Update every 10 meters
      );

      _locationSubscription = Geolocator.getPositionStream(
        locationSettings: locationSettings,
      ).listen((Position position) {
        _updateLocation(position);
      });

      if (mounted) {
        ScaffoldMessenger.of(context).showSnackBar(
          const SnackBar(
            content: Text('GPS tracking started'),
            backgroundColor: AppTheme.successColor,
          ),
        );
      }
    } catch (e) {
      if (mounted) {
        ScaffoldMessenger.of(context).showSnackBar(
          SnackBar(
            content: Text('Failed to start GPS tracking: ${e.toString()}'),
            backgroundColor: AppTheme.errorColor,
          ),
        );
      }
    }
  }

  void _stopTracking() {
    // Cancel location subscription
    _locationSubscription?.cancel();
    _locationSubscription = null;

    ScaffoldMessenger.of(context).showSnackBar(
      const SnackBar(
        content: Text('GPS tracking stopped'),
        backgroundColor: AppTheme.warningColor,
      ),
    );
  }

  Future<void> _manualLocationUpdate() async {
    try {
      Position position = await Geolocator.getCurrentPosition(
        desiredAccuracy: LocationAccuracy.high,
      );
      _updateLocation(position);
    } catch (e) {
      if (mounted) {
        ScaffoldMessenger.of(context).showSnackBar(
          SnackBar(
            content: Text('Failed to get current location: ${e.toString()}'),
            backgroundColor: AppTheme.errorColor,
          ),
        );
      }
    }
  }

  void _updateLocation(Position position) {
    // Log the location data for debugging
    debugPrint(
        'Location updated: Lat=${position.latitude}, Lng=${position.longitude}, Accuracy=${position.accuracy}m');

    // Send location to backend API
    _sendLocationToBackend(position);
  }

  Future<void> _sendLocationToBackend(Position position) async {
    try {
      // Get the repository from dependency injection
      final repository = getIt<DriverRepository>();

      // Prepare location data
      final locationData = {
        'latitude': position.latitude,
        'longitude': position.longitude,
        'accuracy': position.accuracy,
        'speed': position.speed,
        'altitude': position.altitude,
        'heading': position.heading,
        'timestamp': position.timestamp.toIso8601String(),
      };

      // Send to backend
      await repository.updateDriverLocation(locationData);

      // Optional: Update UI with current location if needed
      if (mounted) {
        // Here you could update a state variable to show current location
        // For example: setState(() => _currentPosition = position);
      }

      debugPrint('Location successfully sent to backend');
    } catch (e) {
      // Log error but don't show user notification for every location update
      // to avoid spamming the user with error messages during GPS issues
      debugPrint('Failed to send location to backend: $e');
    }
  }

  Future<void> _shareLocation() async {
    try {
      // Check if location services are enabled
      bool serviceEnabled = await Geolocator.isLocationServiceEnabled();
      if (!serviceEnabled) {
        if (mounted) {
          ScaffoldMessenger.of(context).showSnackBar(
            const SnackBar(
              content: Text(
                  'Location services are disabled. Please enable them to share location.'),
              backgroundColor: AppTheme.errorColor,
            ),
          );
        }
        return;
      }

      // Check permissions
      LocationPermission permission = await Geolocator.checkPermission();
      if (permission == LocationPermission.denied) {
        permission = await Geolocator.requestPermission();
        if (permission == LocationPermission.denied) {
          if (mounted) {
            ScaffoldMessenger.of(context).showSnackBar(
              const SnackBar(
                content:
                    Text('Location permissions are required to share location'),
                backgroundColor: AppTheme.errorColor,
              ),
            );
          }
          return;
        }
      }

      if (permission == LocationPermission.deniedForever) {
        if (mounted) {
          ScaffoldMessenger.of(context).showSnackBar(
            const SnackBar(
              content: Text(
                  'Location permissions are permanently denied. Please enable them in settings.'),
              backgroundColor: AppTheme.errorColor,
            ),
          );
        }
        return;
      }

      // Get current location
      if (mounted) {
        ScaffoldMessenger.of(context).showSnackBar(
          const SnackBar(
            content: Text('Getting current location...'),
            backgroundColor: AppTheme.primaryColor,
          ),
        );
      }

      Position position = await Geolocator.getCurrentPosition(
        desiredAccuracy: LocationAccuracy.high,
        timeLimit: const Duration(seconds: 10),
      );

      // Create shareable location message
      final locationMessage = _createLocationShareMessage(position);

      // Share the location
      await Share.share(
        locationMessage,
        subject: 'My Current Location',
      );
    } catch (e) {
      if (mounted) {
        ScaffoldMessenger.of(context).showSnackBar(
          SnackBar(
            content: Text('Failed to share location: ${e.toString()}'),
            backgroundColor: AppTheme.errorColor,
          ),
        );
      }
    }
  }

  String _createLocationShareMessage(Position position) {
    final latitude = position.latitude.toStringAsFixed(6);
    final longitude = position.longitude.toStringAsFixed(6);
    final accuracy = position.accuracy.toStringAsFixed(1);

    // Create a comprehensive location message
    final message = '''
My Current Location

📍 Coordinates: $latitude, $longitude
🎯 Accuracy: ±${accuracy}m
🕒 Time: ${position.timestamp.toLocal().toString()}

Google Maps: https://maps.google.com/?q=$latitude,$longitude
    '''
        .trim();

    return message;
  }
}
