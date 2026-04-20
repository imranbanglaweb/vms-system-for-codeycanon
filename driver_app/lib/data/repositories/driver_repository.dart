import 'package:flutter/foundation.dart';
import '../datasources/api_client.dart';
import '../models/driver_model.dart';
import '../models/trip_model.dart';
import '../models/vehicle_model.dart';
import '../models/fuel_log_model.dart';
import '../models/dashboard_model.dart';

class DriverRepository {
  final ApiClient _apiClient;

  DriverRepository(this._apiClient);

  Future<Map<String, dynamic>> login(String email, String password) async {
    final response = await _apiClient.login(email, password);
    if (response.statusCode == 200) {
      if (response.data['success'] == true && response.data['token'] != null) {
        await _apiClient.setToken(response.data['token']);
        return response.data;
      } else if (response.data['success'] == false) {
        throw Exception(response.data['message'] ?? 'Invalid credentials');
      }
    }
    throw Exception(response.data['message'] ?? 'Login failed');
  }

  Future<void> logout() async {
    await _apiClient.clearToken();
  }

  Future<bool> isLoggedIn() async {
    final token = await _apiClient.getToken();
    return token != null && token.isNotEmpty;
  }

  Future<DriverDashboard> getDashboard() async {
    final response = await _apiClient.getDriverDashboard();
    return DriverDashboard.fromJson(response.data);
  }

  Future<List<Trip>> getTrips({int page = 1}) async {
    final response = await _apiClient.getDriverTrips(page: page);
    if (response.data['data'] != null) {
      return (response.data['data'] as List)
          .map((t) => Trip.fromJson(t))
          .toList();
    }
    return [];
  }

  Future<Trip> getTripDetails(int tripId) async {
    final response = await _apiClient.getTripDetails(tripId);
    return Trip.fromJson(response.data);
  }

  Future<void> startTrip(int tripId) async {
    final response = await _apiClient.startTrip(tripId);
    if (response.statusCode != 200) {
      throw Exception(response.data['message'] ?? 'Failed to start trip');
    }
  }

  Future<void> finishTrip(int tripId) async {
    final response = await _apiClient.finishTrip(tripId);
    if (response.statusCode != 200) {
      throw Exception(response.data['message'] ?? 'Failed to finish trip');
    }
  }

  Future<void> endTrip(int tripId) async {
    final response = await _apiClient.endTrip(tripId);
    if (response.statusCode != 200) {
      throw Exception(response.data['message'] ?? 'Failed to end trip');
    }
  }

  Future<List<Trip>> getSchedule() async {
    final response = await _apiClient.getDriverSchedule();
    if (response.data != null) {
      return (response.data as List).map((t) => Trip.fromJson(t)).toList();
    }
    return [];
  }

  Future<List<FuelLog>> getFuelLogs({int page = 1}) async {
    final response = await _apiClient.getFuelLogs(page: page);
    if (response.data['data'] != null) {
      return (response.data['data'] as List)
          .map((f) => FuelLog.fromJson(f))
          .toList();
    }
    return [];
  }

  Future<Map<String, dynamic>> getVehicleFuelData(int vehicleId) async {
    final response = await _apiClient.getFuelVehicleData(vehicleId);
    return response.data['data'] ?? {};
  }

  Future<void> submitFuelLog(
      Map<String, dynamic> data, String? imagePath) async {
    final response = await _apiClient.submitFuelLog(data, imagePath);
    if (response.statusCode != 200) {
      throw Exception(response.data['message'] ?? 'Failed to submit fuel log');
    }
  }

  Future<Vehicle?> getVehicle() async {
    final response = await _apiClient.getDriverVehicle();
    if (response.data['vehicle'] != null) {
      return Vehicle.fromJson(response.data['vehicle'] as Map<String, dynamic>);
    }
    return null;
  }

  Future<Driver> getProfile() async {
    final response = await _apiClient.getDriverProfile();
    debugPrint('getProfile response.data: ${response.data}');
    return Driver.fromJson(response.data as Map<String, dynamic>);
  }

  Future<void> updateAvailability(Map<String, dynamic> data) async {
    final response = await _apiClient.updateAvailability(data);
    if (response.statusCode != 200) {
      throw Exception(
          response.data['message'] ?? 'Failed to update availability');
    }
  }

  Future<List<Vehicle>> getAssignedVehicles() async {
    final response = await _apiClient.getDriverVehicle();
    if (response.data['vehicles'] != null) {
      return (response.data['vehicles'] as List)
          .map((v) => Vehicle.fromJson(v as Map<String, dynamic>))
          .toList();
    }
    if (response.data['vehicle'] != null) {
      return [
        Vehicle.fromJson(response.data['vehicle'] as Map<String, dynamic>)
      ];
    }
    return [];
  }

  Future<Map<String, dynamic>> getSettings() async {
    final response = await _apiClient.getSettings();
    return response.data;
  }
}
