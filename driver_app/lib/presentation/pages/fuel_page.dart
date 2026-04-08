import 'package:flutter/material.dart';
import 'package:flutter_bloc/flutter_bloc.dart';
import 'package:intl/intl.dart';
import '../../core/theme/app_theme.dart';
import '../blocs/fuel/fuel_bloc.dart';
import '../blocs/fuel/fuel_event.dart';
import '../widgets/fuel_log_card.dart';
import 'add_fuel_log_page.dart';

class FuelPage extends StatelessWidget {
  const FuelPage({super.key});

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: const Text('Fuel Log'),
      ),
      body: BlocConsumer<FuelBloc, FuelState>(
        listener: (context, state) {
          if (state is FuelSubmitSuccess) {
            ScaffoldMessenger.of(context).showSnackBar(
              SnackBar(
                content: Text(state.message),
                backgroundColor: AppTheme.successColor,
              ),
            );
            context.read<FuelBloc>().add(FuelLogsLoadRequested());
          }
          if (state is FuelError) {
            ScaffoldMessenger.of(context).showSnackBar(
              SnackBar(
                content: Text(state.message),
                backgroundColor: AppTheme.errorColor,
              ),
            );
          }
        },
        builder: (context, state) {
          if (state is FuelLoading) {
            return const Center(child: CircularProgressIndicator());
          }

          if (state is FuelLogsLoaded) {
            if (state.fuelLogs.isEmpty) {
              return _buildEmptyState(context);
            }

            return RefreshIndicator(
              onRefresh: () async {
                context.read<FuelBloc>().add(FuelLogsLoadRequested());
              },
              child: ListView.builder(
                padding: const EdgeInsets.all(16),
                itemCount: state.fuelLogs.length,
                itemBuilder: (context, index) {
                  final fuelLog = state.fuelLogs[index];
                  return Padding(
                    padding: const EdgeInsets.only(bottom: 12),
                    child: FuelLogCard(fuelLog: fuelLog),
                  );
                },
              ),
            );
          }

          return _buildEmptyState(context);
        },
      ),
      floatingActionButton: FloatingActionButton.extended(
        onPressed: () {
          Navigator.push(
            context,
            MaterialPageRoute(builder: (context) => const AddFuelLogPage()),
          );
        },
        icon: const Icon(Icons.add),
        label: const Text('Add Fuel'),
      ),
    );
  }

  Widget _buildEmptyState(BuildContext context) {
    return Center(
      child: Column(
        mainAxisAlignment: MainAxisAlignment.center,
        children: [
          Icon(
            Icons.local_gas_station_outlined,
            size: 64,
            color: AppTheme.textSecondary.withOpacity(0.5),
          ),
          const SizedBox(height: 16),
          Text(
            'No fuel logs found',
            style: Theme.of(context).textTheme.titleMedium?.copyWith(
              color: AppTheme.textSecondary,
            ),
          ),
          const SizedBox(height: 8),
          Text(
            'Tap + to add a fuel entry',
            style: Theme.of(context).textTheme.bodyMedium?.copyWith(
              color: AppTheme.textSecondary,
            ),
          ),
        ],
      ),
    );
  }
}