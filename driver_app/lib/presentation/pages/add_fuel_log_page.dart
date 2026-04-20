import 'package:flutter/material.dart';
import 'package:flutter_bloc/flutter_bloc.dart';
import 'package:intl/intl.dart';
import 'package:image_picker/image_picker.dart';
import 'dart:io';
import '../../core/theme/app_theme.dart';
import '../../data/models/vehicle_model.dart';
import '../blocs/fuel/fuel_bloc.dart';
import '../blocs/fuel/fuel_event.dart';

class AddFuelLogPage extends StatefulWidget {
  const AddFuelLogPage({super.key});

  @override
  State<AddFuelLogPage> createState() => _AddFuelLogPageState();
}

class _AddFuelLogPageState extends State<AddFuelLogPage> {
  final _formKey = GlobalKey<FormState>();
  final _fuelDateController = TextEditingController();
  final _quantityController = TextEditingController();
  final _costController = TextEditingController();
  final _odometerController = TextEditingController();
  final _stationController = TextEditingController();
  final _notesController = TextEditingController();

  String? _selectedFuelType;
  Vehicle? _selectedVehicle;
  File? _receiptImage;
  List<Vehicle> _vehicles = [];
  bool _isLoadingVehicles = true;

  final List<String> _fuelTypes = ['Petrol', 'Diesel', 'CNG', 'Electric'];

  @override
  void initState() {
    super.initState();
    _fuelDateController.text = DateFormat('yyyy-MM-dd').format(DateTime.now());
    _loadVehicles();
  }

  Future<void> _loadVehicles() async {
    try {
      final state = context.read<FuelBloc>().state;
      if (state is FuelLogsLoaded && state.vehicles.isNotEmpty) {
        if (mounted) {
          setState(() {
            _vehicles = state.vehicles;
            _isLoadingVehicles = false;
          });
        }
      } else {
        context.read<FuelBloc>().add(AssignedVehiclesLoadRequested());
        await Future.delayed(const Duration(milliseconds: 500));
        if (!mounted) return;
        final newState = context.read<FuelBloc>().state;
        if (newState is FuelLogsLoaded) {
          setState(() {
            _vehicles = newState.vehicles;
            _isLoadingVehicles = false;
          });
        } else {
          setState(() {
            _isLoadingVehicles = false;
          });
        }
      }
    } catch (e) {
      if (mounted) {
        setState(() {
          _isLoadingVehicles = false;
        });
      }
    }
  }

  @override
  void dispose() {
    _fuelDateController.dispose();
    _quantityController.dispose();
    _costController.dispose();
    _odometerController.dispose();
    _stationController.dispose();
    _notesController.dispose();
    super.dispose();
  }

  Future<void> _pickImage() async {
    final picker = ImagePicker();
    final source = await showModalBottomSheet<ImageSource>(
      context: context,
      builder: (context) => SafeArea(
        child: Wrap(
          children: [
            ListTile(
              leading: const Icon(Icons.camera_alt),
              title: const Text('Camera'),
              onTap: () => Navigator.pop(context, ImageSource.camera),
            ),
            ListTile(
              leading: const Icon(Icons.photo_library),
              title: const Text('Gallery'),
              onTap: () => Navigator.pop(context, ImageSource.gallery),
            ),
          ],
        ),
      ),
    );

    if (source != null) {
      final image = await picker.pickImage(
        source: source,
        maxWidth: 1024,
        maxHeight: 1024,
      );
      if (image != null) {
        setState(() {
          _receiptImage = File(image.path);
        });
      }
    }
  }

  void _submit() {
    if (_formKey.currentState!.validate()) {
      if (_selectedVehicle == null) {
        ScaffoldMessenger.of(context).showSnackBar(
          const SnackBar(content: Text('Please select a vehicle')),
        );
        return;
      }

      context.read<FuelBloc>().add(FuelLogSubmitRequested(
            data: {
              'vehicle_id': _selectedVehicle!.id,
              'fuel_date': _fuelDateController.text,
              'fuel_quantity': double.parse(_quantityController.text),
              'fuel_cost': double.parse(_costController.text),
              'fuel_type': _selectedFuelType ?? 'Petrol',
              'fuel_station': _stationController.text,
              'odometer_reading': double.parse(_odometerController.text),
              'notes': _notesController.text,
            },
            imagePath: _receiptImage?.path,
          ));
    }
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: const Text('Add Fuel Log'),
      ),
      body: BlocListener<FuelBloc, FuelState>(
        listener: (context, state) {
          if (state is FuelSubmitSuccess) {
            Navigator.pop(context);
          }
        },
        child: SingleChildScrollView(
          padding: const EdgeInsets.all(16),
          child: Form(
            key: _formKey,
            child: Column(
              crossAxisAlignment: CrossAxisAlignment.stretch,
              children: [
                if (_isLoadingVehicles)
                  const LinearProgressIndicator()
                else
                  DropdownButtonFormField<Vehicle>(
                    value: _selectedVehicle,
                    decoration: const InputDecoration(
                      labelText: 'Vehicle',
                      prefixIcon: Icon(Icons.directions_car),
                    ),
                    items: _vehicles
                        .map((v) => DropdownMenuItem(
                              value: v,
                              child:
                                  Text('${v.vehicleName} - ${v.vehicleNumber}'),
                            ))
                        .toList(),
                    onChanged: (v) => setState(() => _selectedVehicle = v),
                    validator: (v) =>
                        v == null ? 'Please select a vehicle' : null,
                  ),
                const SizedBox(height: 16),
                TextFormField(
                  controller: _fuelDateController,
                  decoration: const InputDecoration(
                    labelText: 'Fuel Date',
                    prefixIcon: Icon(Icons.calendar_today),
                  ),
                  readOnly: true,
                  onTap: () async {
                    final date = await showDatePicker(
                      context: context,
                      initialDate: DateTime.now(),
                      firstDate: DateTime(2020),
                      lastDate: DateTime.now(),
                    );
                    if (date != null) {
                      _fuelDateController.text =
                          DateFormat('yyyy-MM-dd').format(date);
                    }
                  },
                ),
                const SizedBox(height: 16),
                DropdownButtonFormField<String>(
                  initialValue: _selectedFuelType,
                  decoration: const InputDecoration(
                    labelText: 'Fuel Type',
                    prefixIcon: Icon(Icons.local_gas_station),
                  ),
                  items: _fuelTypes
                      .map((t) => DropdownMenuItem(value: t, child: Text(t)))
                      .toList(),
                  onChanged: (v) => setState(() => _selectedFuelType = v),
                  validator: (v) =>
                      v == null ? 'Please select fuel type' : null,
                ),
                const SizedBox(height: 16),
                Row(
                  children: [
                    Expanded(
                      child: TextFormField(
                        controller: _quantityController,
                        decoration: const InputDecoration(
                          labelText: 'Quantity (L)',
                          prefixIcon: Icon(Icons.local_gas_station),
                        ),
                        keyboardType: TextInputType.number,
                        validator: (v) =>
                            v == null || v.isEmpty ? 'Required' : null,
                      ),
                    ),
                    const SizedBox(width: 16),
                    Expanded(
                      child: TextFormField(
                        controller: _costController,
                        decoration: const InputDecoration(
                          labelText: 'Total Cost',
                          prefixIcon: Icon(Icons.attach_money),
                        ),
                        keyboardType: TextInputType.number,
                        validator: (v) =>
                            v == null || v.isEmpty ? 'Required' : null,
                      ),
                    ),
                  ],
                ),
                const SizedBox(height: 16),
                TextFormField(
                  controller: _odometerController,
                  decoration: const InputDecoration(
                    labelText: 'Odometer Reading (km)',
                    prefixIcon: Icon(Icons.speed),
                  ),
                  keyboardType: TextInputType.number,
                  validator: (v) => v == null || v.isEmpty ? 'Required' : null,
                ),
                const SizedBox(height: 16),
                TextFormField(
                  controller: _stationController,
                  decoration: const InputDecoration(
                    labelText: 'Fuel Station',
                    prefixIcon: Icon(Icons.location_on),
                  ),
                  validator: (v) => v == null || v.isEmpty ? 'Required' : null,
                ),
                const SizedBox(height: 16),
                TextFormField(
                  controller: _notesController,
                  decoration: const InputDecoration(
                    labelText: 'Notes (Optional)',
                    prefixIcon: Icon(Icons.note),
                  ),
                  maxLines: 2,
                ),
                const SizedBox(height: 16),
                GestureDetector(
                  onTap: _pickImage,
                  child: Container(
                    height: 150,
                    decoration: BoxDecoration(
                      border: Border.all(color: AppTheme.dividerColor),
                      borderRadius: BorderRadius.circular(8),
                    ),
                    child: _receiptImage != null
                        ? ClipRRect(
                            borderRadius: BorderRadius.circular(8),
                            child:
                                Image.file(_receiptImage!, fit: BoxFit.cover),
                          )
                        : const Column(
                            mainAxisAlignment: MainAxisAlignment.center,
                            children: [
                              Icon(Icons.camera_alt,
                                  size: 40, color: AppTheme.textSecondary),
                              SizedBox(height: 8),
                              Text('Tap to add receipt photo',
                                  style:
                                      TextStyle(color: AppTheme.textSecondary)),
                            ],
                          ),
                  ),
                ),
                const SizedBox(height: 24),
                BlocBuilder<FuelBloc, FuelState>(
                  builder: (context, state) {
                    return ElevatedButton(
                      onPressed: state is FuelSubmitting ? null : _submit,
                      child: state is FuelSubmitting
                          ? const CircularProgressIndicator(color: Colors.white)
                          : const Text('Submit'),
                    );
                  },
                ),
              ],
            ),
          ),
        ),
      ),
    );
  }
}
