# Mobile APK Deployment Guide

## Overview

This guide covers converting the Dap-ag Tracker PWA into a native Android APK using Capacitor framework. The app is fully prepared for mobile deployment with offline functionality, native features, and optimized UI.

## Prerequisites

### System Requirements
- **Node.js**: 16+ (LTS recommended)
- **Android Studio**: Latest stable version
- **Java JDK**: 11+ (included with Android Studio)
- **Capacitor CLI**: `npm install -g @capacitor/cli`

### Development Environment
```bash
# Verify installations
node --version
npm --version
java -version
./gradlew --version  # In Android Studio terminal
```

## Quick Start APK Build

### 1. Prepare Web Assets
```bash
# Install dependencies
npm install

# Build production assets
npm run build
```

### 2. Initialize Capacitor
```bash
# Add Android platform
npm run mobile:add:android

# Sync web assets to native
npm run mobile:sync
```

### 3. Build APK in Android Studio
```bash
# Open Android Studio
npm run mobile:android

# In Android Studio:
# 1. Wait for Gradle sync
# 2. Build → Make Project
# 3. Build → Build Bundle(s)/APK(s) → Build APK(s)
# 4. Locate APK in: android/app/build/outputs/apk/debug/
```

## Detailed Build Process

### Step 1: Web Build Configuration

Ensure `vite.config.js` is configured for mobile:
```javascript
export default defineConfig({
  build: {
    outDir: 'public',
    assetsDir: 'assets',
    rollupOptions: {
      output: {
        manualChunks: undefined,
      }
    }
  },
  server: {
    host: '0.0.0.0',
    port: 3000,
  }
});
```

### Step 2: Capacitor Configuration

The `capacitor.config.json` is pre-configured:
```json
{
  "appId": "com.dagag.tracker",
  "appName": "Dap-ag Tracker",
  "webDir": "public",
  "bundledWebRuntime": false,
  "plugins": {
    "Camera": {
      "allowEditing": true,
      "saveToGallery": false
    },
    "Geolocation": {},
    "Filesystem": {}
  }
}
```

### Step 3: Android Configuration

The `android/` folder contains:
- **AndroidManifest.xml**: Permissions and app configuration
- **gradle.properties**: Build settings
- **MainActivity.java**: Native activity class

### Step 4: Build Scripts

Use the provided build scripts:

**Linux/Mac:**
```bash
chmod +x build-apk.sh
./build-apk.sh
```

**Windows:**
```cmd
build-apk.bat
```

## APK Types

### Debug APK
- **Purpose**: Development and testing
- **Signing**: Automatic debug keystore
- **Size**: Larger (includes debug symbols)
- **Installation**: Direct install on devices

### Release APK
- **Purpose**: Production distribution
- **Signing**: Requires keystore setup
- **Size**: Optimized and smaller
- **Installation**: Play Store or direct distribution

## Signing Release APK

### 1. Generate Keystore
```bash
# In android/ directory
keytool -genkey -v -keystore release.keystore -alias dagag-key -keyalg RSA -keysize 2048 -validity 10000
```

### 2. Configure Signing
Create `android/app/release-signing.properties`:
```
storeFile=../../release.keystore
storePassword=your_store_password
keyAlias=dagag-key
keyPassword=your_key_password
```

### 3. Build Signed APK
```bash
cd android
./gradlew assembleRelease
```

## Testing APK

### 1. Install on Device
```bash
# Connect Android device with USB debugging enabled
adb install android/app/build/outputs/apk/debug/app-debug.apk
```

### 2. Test Features
- ✅ **Offline Functionality**: Disable WiFi/mobile data
- ✅ **GPS**: Grant location permissions
- ✅ **Camera**: Test photo capture
- ✅ **Data Sync**: Re-enable connection, check sync
- ✅ **UI Responsiveness**: Test on different screen sizes

### 3. Common Test Scenarios
- **Network Interruption**: Collect data offline, then reconnect
- **App Restart**: Data should persist across app restarts
- **Memory Pressure**: Test with low memory conditions
- **GPS Accuracy**: Verify coordinate capture accuracy

## Play Store Preparation

### 1. App Store Listing
- **Title**: Dap-ag Tracker
- **Short Description**: Offline COTS tracking for marine conservation
- **Full Description**: Include feature list and offline capabilities
- **Screenshots**: Capture from actual device
- **Icon**: Use 512x512 PNG from resources

### 2. Store-Specific Assets
- **Feature Graphic**: 1024x500 PNG
- **Promo Graphic**: 180x120 PNG
- **Screenshots**: 8-10 images showing app in use

### 3. App Bundle vs APK
- **Recommended**: Android App Bundle (.aab)
- **Benefits**: Smaller downloads, optimized for device
- **Build Command**: `./gradlew bundleRelease`

## Troubleshooting

### Build Issues

**Gradle Sync Failed:**
```bash
# Clean and retry
cd android
./gradlew clean
./gradlew build
```

**Plugin Errors:**
```bash
# Reinstall plugins
npm run mobile:sync
npm run mobile:add:android
```

**Assets Not Loading:**
```bash
# Force rebuild web assets
npm run build
npm run mobile:sync
```

### Runtime Issues

**Permissions Denied:**
- Check AndroidManifest.xml for required permissions
- Request permissions at runtime in the app

**Offline Data Not Syncing:**
- Verify service worker registration
- Check network connectivity
- Review console logs for sync errors

**Camera Not Working:**
- Ensure camera permissions granted
- Test with device camera app first
- Check Capacitor Camera plugin configuration

### Performance Issues

**Large APK Size:**
- Optimize images and assets
- Use ProGuard for code shrinking
- Consider dynamic feature modules

**Slow Startup:**
- Minimize initial JavaScript bundle
- Use code splitting
- Optimize service worker caching

## Advanced Configuration

### Custom Plugins

Add native functionality:
```bash
npm install @capacitor/plugin-name
npm run mobile:sync
```

### Push Notifications

```bash
npm install @capacitor/push-notifications
npx cap sync
```

### Background Tasks

```bash
npm install @capacitor/background-task
npx cap sync
```

## Distribution Options

### 1. Google Play Store
- **Primary**: Full app store distribution
- **Requirements**: Signed release APK/bundle
- **Process**: Upload via Play Console

### 2. Direct APK Sharing
- **Testing**: Share debug APKs with testers
- **Enterprise**: Direct distribution to field teams
- **Updates**: Manual APK distribution

### 3. Alternative Stores
- **Amazon Appstore**: Alternative Android distribution
- **Samsung Galaxy Store**: Samsung device distribution

## Maintenance

### Version Updates
1. Update version in `package.json`
2. Update version in `capacitor.config.json`
3. Rebuild and test APK
4. Submit to Play Store

### Security Updates
- Keep Capacitor and plugins updated
- Monitor security advisories
- Update native dependencies regularly

### User Feedback
- Monitor crash reports in Play Console
- Collect user feedback for improvements
- Plan regular feature updates

## Support Resources

- **Capacitor Docs**: https://capacitorjs.com/docs
- **Android Developer**: https://developer.android.com
- **Play Console Help**: https://support.google.com/googleplay
- **Cordova Alternative**: If Capacitor issues arise

## Next Steps

1. **Test APK thoroughly** on target devices
2. **Prepare Play Store listing** with screenshots
3. **Set up crash reporting** (Firebase Crashlytics)
4. **Plan update strategy** for field deployment
5. **Consider iOS version** for broader adoption

---

*This guide ensures successful conversion of the Dap-ag Tracker PWA to a production-ready Android APK with full offline functionality.*