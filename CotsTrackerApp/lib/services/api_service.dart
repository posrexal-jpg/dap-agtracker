import 'dart:typed_data';

import 'package:dio/dio.dart';
import 'package:flutter_secure_storage/flutter_secure_storage.dart';

import '../models/sighting.dart';

class ApiService {
  ApiService(this.baseUrl)
    : _dio = Dio(
        BaseOptions(
          baseUrl: baseUrl,
          connectTimeout: const Duration(seconds: 15),
          receiveTimeout: const Duration(seconds: 20),
          headers: {'Accept': 'application/json'},
        ),
      );

  final String baseUrl;
  final Dio _dio;
  static const _storage = FlutterSecureStorage();

  Future<String?> get token => _storage.read(key: 'api_token');

  Future<void> _authorize() async {
    final value = await token;
    if (value != null) {
      _dio.options.headers['Authorization'] = 'Bearer $value';
    }
  }

  Future<Map<String, dynamic>> login(String email, String password) async {
    final response = await _dio.post<Map<String, dynamic>>(
      '/login',
      data: {
        'email': email,
        'password': password,
        'device_name': 'COTS Tracker Flutter',
      },
    );
    final data = response.data!;
    await _storage.write(key: 'api_token', value: '${data['token']}');
    return Map<String, dynamic>.from(data['user'] as Map);
  }

  Future<String> googleClientId() async {
    final response = await _dio.get<Map<String, dynamic>>('/google/config');
    final configuredValue = response.data?['client_id'];
    final value = configuredValue is String ? configuredValue.trim() : '';
    if (value.isEmpty || !value.endsWith('.apps.googleusercontent.com')) {
      throw StateError(
        'Google Sign-In is not configured correctly on the server.',
      );
    }
    return value;
  }

  Future<Map<String, dynamic>> googleLogin(String idToken) async {
    final response = await _dio.post<Map<String, dynamic>>(
      '/google/login',
      data: {'id_token': idToken, 'device_name': 'COTS Tracker Flutter'},
    );
    final data = response.data!;
    await _storage.write(key: 'api_token', value: '${data['token']}');
    return Map<String, dynamic>.from(data['user'] as Map);
  }

  Future<Map<String, dynamic>> bootstrap() async {
    await _authorize();
    final response = await _dio.get<Map<String, dynamic>>('/bootstrap');
    return response.data!;
  }

  Future<Map<String, dynamic>> me() async {
    await _authorize();
    final response = await _dio.get<Map<String, dynamic>>('/me');
    return Map<String, dynamic>.from(response.data!['user'] as Map);
  }

  static bool isUnauthorized(Object error) =>
      error is DioException && error.response?.statusCode == 401;

  Future<Map<String, dynamic>> updateProfile(String name) async {
    await _authorize();
    final response = await _dio.put<Map<String, dynamic>>(
      '/profile',
      data: {'name': name},
    );
    return Map<String, dynamic>.from(response.data!['user'] as Map);
  }

  Future<void> updatePassword(String currentPassword, String password) async {
    await _authorize();
    await _dio.put<void>(
      '/password',
      data: {
        'current_password': currentPassword,
        'password': password,
        'password_confirmation': password,
      },
    );
  }

  Future<void> deleteSighting(int id) async {
    await _authorize();
    await _dio.delete<void>('/sightings/$id');
  }

  Future<Sighting> upload(Sighting sighting) async {
    await _authorize();
    final fields = sighting.toApiMap();
    final form = FormData.fromMap(fields);
    for (var i = 0; i < sighting.photoBytes.length; i++) {
      final Uint8List bytes = sighting.photoBytes[i];
      form.files.add(
        MapEntry(
          'photos[]',
          MultipartFile.fromBytes(bytes, filename: 'cots_${i + 1}.jpg'),
        ),
      );
    }
    final response = await _dio.post<Map<String, dynamic>>(
      '/sightings',
      data: form,
    );
    return Sighting.fromMap(response.data!['sighting'] as Map);
  }

  Future<void> logout() async {
    try {
      await _authorize();
      await _dio.post<void>('/logout');
    } finally {
      await clearToken();
    }
  }

  Future<void> clearToken() => _storage.delete(key: 'api_token');

  static String messageFor(Object error) {
    if (error is DioException) {
      final data = error.response?.data;
      if (data is Map && data['message'] != null) return '${data['message']}';
      if (error.type == DioExceptionType.connectionError ||
          error.type == DioExceptionType.connectionTimeout) {
        return 'Cannot reach the server. Check the API address and connection.';
      }
    }
    return 'Something went wrong. Please try again.';
  }
}
