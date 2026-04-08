import 'package:dio/dio.dart';
import 'package:flutter_secure_storage/flutter_secure_storage.dart';
import '../../core/constants/app_constants.dart';

class ApiClient {
  late final Dio _dio;
  final FlutterSecureStorage _storage = const FlutterSecureStorage();

  ApiClient() {
    _dio = Dio(BaseOptions(
      baseUrl: ApiConstants.baseUrl,
      connectTimeout: const Duration(milliseconds: ApiConstants.connectTimeout),
      receiveTimeout: const Duration(milliseconds: ApiConstants.receiveTimeout),
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
      },
    ));

    _dio.interceptors.add(InterceptorsWrapper(
      onRequest: (options, handler) async {
        final token = await _storage.read(key: StorageKeys.authToken);
        if (token != null) {
          options.headers['Authorization'] = 'Bearer $token';
        }
        return handler.next(options);
      },
      onError: (error, handler) {
        if (error.response?.statusCode == 401) {
          _storage.delete(key: StorageKeys.authToken);
        }
        return handler.next(error);
      },
    ));
  }

  Future<void> setToken(String token) async {
    await _storage.write(key: StorageKeys.authToken, value: token);
  }

  Future<String?> getToken() async {
    return await _storage.read(key: StorageKeys.authToken);
  }

  Future<void> clearToken() async {
    await _storage.delete(key: StorageKeys.authToken);
  }

  Future<Response> login(String email, String password) async {
    return await _dio.post(
      ApiConstants.loginEndpoint,
      data: {
        'email': email,
        'password': password,
      },
    );
  }

  Future<Response> getDriverDashboard() async {
    return await _dio.get(ApiConstants.driverDashboard);
  }

  Future<Response> getDriverTrips({int page = 1}) async {
    return await _dio.get(ApiConstants.driverTrips, queryParameters: {'page': page});
  }

  Future<Response> getTripDetails(int tripId) async {
    return await _dio.get('${ApiConstants.driverTrips}/$tripId');
  }

  Future<Response> startTrip(int tripId) async {
    return await _dio.post('/driver/trips/$tripId/start');
  }

  Future<Response> finishTrip(int tripId) async {
    return await _dio.post('/driver/trips/$tripId/finish');
  }

  Future<Response> endTrip(int tripId) async {
    return await _dio.post('/driver/trips/$tripId/end');
  }

  Future<Response> getDriverSchedule() async {
    return await _dio.get(ApiConstants.driverSchedule);
  }

  Future<Response> getFuelLogs({int page = 1}) async {
    return await _dio.get(ApiConstants.driverFuelLog, queryParameters: {'page': page});
  }

  Future<Response> getFuelVehicleData(int vehicleId) async {
    return await _dio.get('/driver/fuel-log/vehicle-data', queryParameters: {'vehicle_id': vehicleId});
  }

  Future<Response> submitFuelLog(Map<String, dynamic> data, String? imagePath) async {
    if (imagePath != null) {
      final formData = FormData.fromMap({
        ...data,
        'receipt_image': await MultipartFile.fromFile(imagePath),
      });
      return await _dio.post(
        ApiConstants.driverFuelLog,
        data: formData,
      );
    }
    return await _dio.post(ApiConstants.driverFuelLog, data: data);
  }

  Future<Response> getDriverVehicle() async {
    return await _dio.get(ApiConstants.driverVehicle);
  }

  Future<Response> updateAvailability(Map<String, dynamic> data) async {
    return await _dio.post(ApiConstants.driverAvailability, data: data);
  }

  Future<Response> getDriverProfile() async {
    return await _dio.get(ApiConstants.driverProfile);
  }
}