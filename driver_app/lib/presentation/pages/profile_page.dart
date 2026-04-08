import 'package:flutter/material.dart';
import 'package:flutter_bloc/flutter_bloc.dart';
import '../../core/theme/app_theme.dart';
import '../blocs/profile/profile_bloc.dart';
import '../blocs/profile/profile_event.dart';
import '../blocs/auth/auth_bloc.dart';
import '../blocs/auth/auth_event.dart';

class ProfilePage extends StatelessWidget {
  const ProfilePage({super.key});

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: const Text('Profile'),
        actions: [
          IconButton(
            icon: const Icon(Icons.logout),
            onPressed: () => _showLogoutDialog(context),
          ),
        ],
      ),
      body: BlocBuilder<ProfileBloc, ProfileState>(
        builder: (context, state) {
          if (state is ProfileLoading) {
            return const Center(child: CircularProgressIndicator());
          }

          if (state is ProfileError) {
            return Center(
              child: Column(
                mainAxisAlignment: MainAxisAlignment.center,
                children: [
                  Icon(Icons.error_outline, size: 64, color: AppTheme.errorColor),
                  const SizedBox(height: 16),
                  Text('Error loading profile'),
                  const SizedBox(height: 8),
                  ElevatedButton(
                    onPressed: () {
                      context.read<ProfileBloc>().add(ProfileLoadRequested());
                    },
                    child: const Text('Retry'),
                  ),
                ],
              ),
            );
          }

          if (state is ProfileLoaded) {
            final driver = state.driver;
            final vehicle = state.vehicle;

            return SingleChildScrollView(
              padding: const EdgeInsets.all(16),
              child: Column(
                children: [
                  _buildProfileHeader(context, driver),
                  const SizedBox(height: 24),
                  _buildInfoSection(context, 'Driver Information', [
                    _buildInfoRow('Name', driver?.driverName ?? '-'),
                    _buildInfoRow('License Number', driver?.licenseNumber ?? '-'),
                    _buildInfoRow('License Type', driver?.licenseType ?? '-'),
                    _buildInfoRow('Mobile', driver?.mobile ?? '-'),
                    _buildInfoRow('NID', driver?.nid ?? '-'),
                  ]),
                  const SizedBox(height: 16),
                  _buildAvailabilitySection(context, driver),
                  const SizedBox(height: 16),
                  if (vehicle != null)
                    _buildInfoSection(context, 'Assigned Vehicle', [
                      _buildInfoRow('Vehicle', vehicle.vehicleName),
                      _buildInfoRow('Number', vehicle.vehicleNumber),
                      _buildInfoRow('Type', vehicle.vehicleType ?? '-'),
                      _buildInfoRow('Brand', vehicle.brand ?? '-'),
                      _buildInfoRow('Model', vehicle.model ?? '-'),
                    ]),
                  if (driver?.presentAddress != null || driver?.permanentAddress != null) ...[
                    const SizedBox(height: 16),
                    _buildInfoSection(context, 'Address', [
                      if (driver?.presentAddress != null)
                        _buildInfoRow('Present', driver!.presentAddress!),
                      if (driver?.permanentAddress != null)
                        _buildInfoRow('Permanent', driver!.permanentAddress!),
                    ]),
                  ],
                ],
              ),
            );
          }

          return const Center(child: Text('Loading profile...'));
        },
      ),
    );
  }

  Widget _buildProfileHeader(BuildContext context, driver) {
    return Card(
      child: Padding(
        padding: const EdgeInsets.all(24),
        child: Column(
          children: [
            CircleAvatar(
              radius: 50,
              backgroundColor: AppTheme.primaryColor,
              child: Text(
                (driver?.driverName ?? 'D')[0].toUpperCase(),
                style: const TextStyle(fontSize: 40, color: Colors.white),
              ),
            ),
            const SizedBox(height: 16),
            Text(
              driver?.driverName ?? 'Driver',
              style: Theme.of(context).textTheme.headlineSmall,
            ),
            if (driver?.mobile != null) ...[
              const SizedBox(height: 4),
              Text(
                driver!.mobile!,
                style: Theme.of(context).textTheme.bodyMedium?.copyWith(
                  color: AppTheme.textSecondary,
                ),
              ),
            ],
          ],
        ),
      ),
    );
  }

  Widget _buildInfoSection(BuildContext context, String title, List<Widget> rows) {
    return Card(
      child: Padding(
        padding: const EdgeInsets.all(16),
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            Text(
              title,
              style: Theme.of(context).textTheme.titleLarge,
            ),
            const Divider(),
            ...rows,
          ],
        ),
      ),
    );
  }

  Widget _buildInfoRow(String label, String value) {
    return Padding(
      padding: const EdgeInsets.symmetric(vertical: 8),
      child: Row(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          SizedBox(
            width: 120,
            child: Text(
              label,
              style: const TextStyle(color: AppTheme.textSecondary),
            ),
          ),
          Expanded(
            child: Text(
              value,
              style: const TextStyle(fontWeight: FontWeight.w500),
            ),
          ),
        ],
      ),
    );
  }

  Widget _buildAvailabilitySection(BuildContext context, driver) {
    final status = driver?.availabilityStatus ?? 'available';
    final statusColor = AppTheme.getAvailabilityColor(status);

    return Card(
      child: Padding(
        padding: const EdgeInsets.all(16),
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            Row(
              mainAxisAlignment: MainAxisAlignment.spaceBetween,
              children: [
                Text(
                  'Availability',
                  style: Theme.of(context).textTheme.titleLarge,
                ),
                Container(
                  padding: const EdgeInsets.symmetric(horizontal: 12, vertical: 6),
                  decoration: BoxDecoration(
                    color: statusColor.withOpacity(0.1),
                    borderRadius: BorderRadius.circular(20),
                    border: Border.all(color: statusColor),
                  ),
                  child: Text(
                    status.replaceAll('_', ' ').toUpperCase(),
                    style: TextStyle(
                      color: statusColor,
                      fontWeight: FontWeight.bold,
                      fontSize: 12,
                    ),
                  ),
                ),
              ],
            ),
            const Divider(),
            if (driver?.availabilityNotes != null) ...[
              _buildInfoRow('Notes', driver!.availabilityNotes!),
            ],
            if (driver?.availableFrom != null) ...[
              _buildInfoRow('Available From', driver!.availableFrom.toString().split(' ')[0]),
            ],
            if (driver?.availableUntil != null) ...[
              _buildInfoRow('Available Until', driver!.availableUntil.toString().split(' ')[0]),
            ],
            const SizedBox(height: 16),
            SizedBox(
              width: double.infinity,
              child: OutlinedButton.icon(
                onPressed: () => _showAvailabilityDialog(context, driver),
                icon: const Icon(Icons.edit),
                label: const Text('Update Availability'),
              ),
            ),
          ],
        ),
      ),
    );
  }

  void _showAvailabilityDialog(BuildContext context, driver) {
    String selectedStatus = driver?.availabilityStatus ?? 'available';
    final notesController = TextEditingController(text: driver?.availabilityNotes);

    showDialog(
      context: context,
      builder: (context) => AlertDialog(
        title: const Text('Update Availability'),
        content: Column(
          mainAxisSize: MainAxisSize.min,
          children: [
            DropdownButtonFormField<String>(
              value: selectedStatus,
              decoration: const InputDecoration(labelText: 'Status'),
              items: const [
                DropdownMenuItem(value: 'available', child: Text('Available')),
                DropdownMenuItem(value: 'on_leave', child: Text('On Leave')),
                DropdownMenuItem(value: 'unavailable', child: Text('Unavailable')),
              ],
              onChanged: (v) => selectedStatus = v!,
            ),
            const SizedBox(height: 16),
            TextField(
              controller: notesController,
              decoration: const InputDecoration(labelText: 'Notes'),
              maxLines: 2,
            ),
          ],
        ),
        actions: [
          TextButton(
            onPressed: () => Navigator.pop(context),
            child: const Text('Cancel'),
          ),
          ElevatedButton(
            onPressed: () {
              Navigator.pop(context);
              context.read<ProfileBloc>().add(AvailabilityUpdateRequested(
                status: selectedStatus,
                notes: notesController.text.isEmpty ? null : notesController.text,
              ));
            },
            child: const Text('Update'),
          ),
        ],
      ),
    );
  }

  void _showLogoutDialog(BuildContext context) {
    showDialog(
      context: context,
      builder: (context) => AlertDialog(
        title: const Text('Logout'),
        content: const Text('Are you sure you want to logout?'),
        actions: [
          TextButton(
            onPressed: () => Navigator.pop(context),
            child: const Text('Cancel'),
          ),
          ElevatedButton(
            onPressed: () {
              Navigator.pop(context);
              context.read<AuthBloc>().add(AuthLogoutRequested());
            },
            style: ElevatedButton.styleFrom(backgroundColor: AppTheme.errorColor),
            child: const Text('Logout'),
          ),
        ],
      ),
    );
  }
}