# Mobile APK Build Guide

This guide explains how to convert the Dag-ag Tracker PWA into a native Android APK using Capacitor.

## Prerequisites

- Node.js 16+ and npm
- Android Studio (for Android builds)
- Xcode (for iOS builds, macOS only)
- Java JDK 11+

## Quick Start with Capacitor

### 1. Install Dependencies

```bash
# Install Capacitor CLI globally
npm install -g @capacitor/cli

# Install project dependencies
npm install
```

### 2. Build Web Assets

```bash
# Build the PWA for production
npm run build
```

### 3. Initialize Capacitor

```bash
# Add Android platform
npx cap add android

# Add iOS platform (macOS only)
npx cap add ios
```

### 4. Build APK

```bash
# Sync web assets to native projects
npm run mobile:sync

# Open Android Studio
npm run mobile:android

# In Android Studio:
# 1. Wait for Gradle sync
# 2. Build → Make Project
# 3. Build → Build Bundle(s)/APK(s) → Build APK(s)
# 4. Locate APK in android/app/build/outputs/apk/debug/
```

## Alternative: Cordova Build

If you prefer Cordova over Capacitor:

### 1. Install Cordova

```bash
npm install -g cordova
```

### 2. Create Cordova Project

```bash
# Create Cordova project
cordova create dagag-mobile com.dagag.tracker "Dag-ag Tracker"

# Copy web assets
cp -r public/* dagag-mobile/www/

# Add Android platform
cd dagag-mobile
cordova platform add android

# Build APK
cordova build android
```

## Capacitor Configuration

The `capacitor.config.json` is pre-configured with:

- App ID: `com.dagag.tracker`
- App Name: "Dag-ag Tracker"
- Plugins: Camera, Geolocation, Filesystem, Network
- Web directory: `public/`

## Android Build Optimization

### 1. AndroidManifest.xml Customizations

The build includes optimized permissions:

```xml
<uses-permission android:name="android.permission.INTERNET" />
<uses-permission android:name="android.permission.ACCESS_FINE_LOCATION" />
<uses-permission android:name="android.permission.ACCESS_COARSE_LOCATION" />
<uses-permission android:name="android.permission.CAMERA" />
<uses-permission android:name="android.permission.WRITE_EXTERNAL_STORAGE" />
```

### 2. Build Variants

- **Debug APK**: For testing (`npm run apk:build`)
- **Release APK**: For production (requires signing)

### 3. Signing Release APK

1. Create keystore:
```bash
keytool -genkey -v -keystore dagag-key.keystore -alias dagag -keyalg RSA -keysize 2048 -validity 10000
```

2. Update `android/app/build.gradle`:
```gradle
android {
    signingConfigs {
        release {
            storeFile file('dagag-key.keystore')
            storePassword 'your_password'
            keyAlias 'dagag'
            keyPassword 'your_password'
        }
    }
    buildTypes {
        release {
            signingConfig signingConfigs.release
        }
    }
}
```

## iOS Build (macOS only)

### 1. iOS Build Process

```bash
# Sync and open Xcode
npm run mobile:ios

# In Xcode:
# 1. Select development team
# 2. Set bundle identifier
# 3. Product → Archive
# 4. Distribute App → Ad Hoc → Export
```

### 2. iOS Permissions

The app requests:
- Location services
- Camera access
- Photo library access

## Testing APK

### 1. Install on Device

```bash
# Via ADB (Android)
adb install android/app/build/outputs/apk/debug/app-debug.apk

# Or use Android Studio device manager
```

### 2. Test Features

- ✅ Offline data collection
- ✅ GPS location capture
- ✅ Camera photo capture
- ✅ Background sync
- ✅ PWA installation prompt

## Troubleshooting

### Common Issues

**Build fails with "AAPT" errors:**
- Clean and rebuild: `./gradlew clean build`

**Permissions not working:**
- Check AndroidManifest.xml
- Verify plugin installations

**White screen on launch:**
- Check web asset paths
- Verify Capacitor sync completed

**GPS not working:**
- Enable location permissions
- Check device GPS settings

### Debug APK

```bash
# Enable USB debugging on Android device
# Connect device via USB
adb logcat | grep -i dagag
```

## Distribution

### Google Play Store

1. **Prepare Release APK**
2. **Create Play Store Listing**
3. **Upload APK/AAB**
4. **Configure Store Settings**
5. **Publish**

### Alternative Distribution

- **Direct APK sharing**
- **Enterprise distribution**
- **Beta testing via Google Play**

## Performance Optimization

### APK Size Reduction

- **Enable ProGuard/R8**: Minifies code
- **WebP Images**: Smaller image sizes
- **Asset Optimization**: Compress resources

### Runtime Performance

- **Service Worker**: Cached assets
- **Lazy Loading**: On-demand resource loading
- **Background Sync**: Efficient data handling

## Updates

### In-App Updates

The PWA automatically updates web assets. For native updates:

- **Android**: Publish new version on Play Store
- **iOS**: Submit update to App Store

### Web Asset Updates

```bash
# Update web assets
npm run build
npm run mobile:sync
npm run mobile:android  # Rebuild native app
```

## Support

For build issues:
1. Check Capacitor documentation
2. Verify Android Studio setup
3. Ensure all dependencies installed
4. Check device compatibility

## Build Scripts Summary

```bash
# Development
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