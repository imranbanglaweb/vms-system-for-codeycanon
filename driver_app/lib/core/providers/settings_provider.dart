import 'package:flutter/material.dart';
import 'package:flutter/foundation.dart';
import 'package:flutter_secure_storage/flutter_secure_storage.dart';
import '../constants/app_constants.dart';
import '../../data/repositories/driver_repository.dart';

class SettingsProvider extends ChangeNotifier {
  final DriverRepository _repository;
  final FlutterSecureStorage _storage = const FlutterSecureStorage();

  String? _logoUrl;
  String _title = AppStrings.defaultTitle;
  String _description = AppStrings.defaultDescription;
  bool _isLoaded = false;

  SettingsProvider(this._repository);

  String? get logoUrl => _logoUrl;
  String get title => _title;
  String get description => _description;
  bool get isLoaded => _isLoaded;

  Future<void> loadSettings() async {
    if (_isLoaded) return;

    try {
      // Try to get cached settings first
      final cachedLogo = await _storage.read(key: StorageKeys.appLogo);
      final cachedTitle = await _storage.read(key: StorageKeys.appTitle);
      final cachedDescription =
          await _storage.read(key: StorageKeys.appDescription);

      if (cachedLogo != null || cachedTitle != null) {
        _logoUrl = cachedLogo;
        _title = cachedTitle ?? AppStrings.defaultTitle;
        _description = cachedDescription ?? AppStrings.defaultDescription;
        notifyListeners();
      }

      // Then fetch fresh settings from API
      final settings = await _repository.getSettings();

      if (settings['logo_url'] != null) {
        _logoUrl = settings['logo_url']?.toString();
        await _storage.write(key: StorageKeys.appLogo, value: _logoUrl);
      }

      if (settings['title'] != null) {
        _title = settings['title'].toString();
        await _storage.write(key: StorageKeys.appTitle, value: _title);
      }

      if (settings['description'] != null) {
        _description = settings['description'].toString();
        await _storage.write(
            key: StorageKeys.appDescription, value: _description);
      }

      _isLoaded = true;
      notifyListeners();
    } catch (e) {
      debugPrint('Failed to load settings: $e');
      _isLoaded = true;
      notifyListeners();
    }
  }
}
