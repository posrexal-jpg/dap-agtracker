# Dag-ag Tracker - Offline PWA & Mobile App

A Progressive Web App for tracking Crown-of-Thorns Starfish (COTS) sightings with full offline functionality and mobile APK conversion capabilities.

## 🚀 Features

### 🏊‍♂️ **Offline-First Design**
- **Works without internet**: Collect data anywhere, even in remote areas
- **Automatic sync**: Data uploads when connection is restored
- **Local storage**: Uses IndexedDB for reliable offline data storage
- **Background sync**: Automatically syncs data when online

### 📱 **PWA & Mobile App**
- **Installable PWA**: Add to home screen on mobile devices
- **APK Conversion**: Convert to native Android APK using Capacitor
- **Cross-platform**: iOS and Android support
- **Native features**: Camera, GPS, file system access

### 🗺️ **Data Collection**
- **GPS coordinates**: Automatic location capture
- **Photo uploads**: Multiple photo support with offline storage
- **Comprehensive data**: Size categories, activity types, observer details
- **Real-time sync status**: Visual indicators for connection and sync status

## 📱 Mobile APK Conversion

### Quick APK Build

```bash
# Install dependencies
npm install

# Build web assets
npm run build

# Initialize mobile platforms
npm run mobile:add:android

# Build and open Android Studio
npm run mobile:android

# In Android Studio: Build → Make Project → Build APK
```

### Build Scripts

- **Linux/Mac**: `./build-apk.sh`
- **Windows**: `build-apk.bat`
- **Manual**: See `MOBILE_BUILD_GUIDE.md`

### APK Features

- ✅ **Native Performance**: Faster than web app
- ✅ **App Store Distribution**: Submit to Play Store
- ✅ **Push Notifications**: (Future enhancement)
- ✅ **Offline Maps**: Cached map tiles
- ✅ **Device Integration**: Native camera and GPS

## Installation & Setup

### Web App Setup

```bash
# Install PHP dependencies
composer install

# Install Node dependencies
npm install

# Database setup
php artisan migrate

# Start development server
php artisan serve
```

### Mobile App Setup

```bash
# Install Capacitor CLI
npm install -g @capacitor/cli

# Add mobile platforms
npm run mobile:add:android  # For Android
npm run mobile:add:ios      # For iOS (macOS only)

# Build APK
npm run apk:build
```

## Usage Guide

### For Field Researchers

1. **Install App**: PWA or APK on mobile device
2. **Go Offline**: App works without internet connection
3. **Collect Data**: Use GPS and camera for sightings
4. **Auto-Sync**: Data uploads when online
5. **Monitor Status**: Real-time connection indicators

### Data Collection Workflow

1. **Location Access**: Grant GPS permissions
2. **Fill Form**: Complete sighting details
3. **Add Photos**: Multiple photos supported
4. **Save**: Works online or offline
5. **Sync**: Automatic when reconnected

## Technical Implementation

### Service Worker (`sw.js`)
- Enhanced caching strategy
- Background sync registration
- Request queuing for offline API calls
- Cache management and updates

### Offline Manager (`js/offline-manager.js`)
- IndexedDB wrapper for data operations
- Sync coordination
- Network status monitoring
- User notifications

### Mobile Integration
- **Capacitor**: Native API access
- **Cordova**: Alternative build system
- **Plugins**: Camera, Geolocation, Filesystem

### API Endpoints
- `POST /api/sync-locations`: Bulk location sync
- Enhanced error handling for offline scenarios

## Browser & Device Support

- **Modern Browsers**: Chrome, Firefox, Safari, Edge
- **Mobile Browsers**: Android Chrome, iOS Safari
- **Android**: 8.0+ (API 26+)
- **iOS**: 12.0+

## Build Scripts Summary

```bash
# Web Development
npm run dev              # Start dev server
npm run build           # Build for production

# Mobile Development
npm run mobile:build    # Build and sync
npm run mobile:android  # Open Android Studio
npm run mobile:ios      # Open Xcode

# APK Building
npm run apk:build       # Build debug APK
npm run apk:release     # Build release APK
```

## Distribution

### Web App
- **PWA**: Install from browser
- **Hosting**: Any web server with HTTPS

### Mobile App
- **Android**: Google Play Store
- **iOS**: Apple App Store
- **Direct**: APK sharing for testing

## Troubleshooting

### Web App Issues
- **Service Worker**: Clear cache and reload
- **Offline Data**: Check browser storage
- **GPS Issues**: Grant location permissions

### Mobile Build Issues
- **Gradle Errors**: Clean and rebuild
- **Permissions**: Check AndroidManifest.xml
- **Assets**: Ensure web build completed

## Contributing

1. Test on multiple devices
2. Follow PWA best practices
3. Ensure mobile compatibility
4. Update build documentation

## License

This project is part of the Dag-ag Tracker initiative for coral reef conservation.

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
