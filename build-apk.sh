#!/bin/bash

# COTS Tracker Mobile Build Script
# This script helps build APK files for Android

echo "🏗️  Building COTS Tracker APK..."

# Check if Node.js is installed
if ! command -v node &> /dev/null; then
    echo "❌ Node.js is not installed. Please install Node.js 16+ first."
    exit 1
fi

# Check if npm is installed
if ! command -v npm &> /dev/null; then
    echo "❌ npm is not installed. Please install npm first."
    exit 1
fi

# Install dependencies
echo "📦 Installing dependencies..."
npm install

# Build web assets
echo "🔨 Building web assets..."
npm run build

# Check if Capacitor is installed
if ! command -v npx &> /dev/null; then
    echo "❌ npx is not available. Please check your Node.js installation."
    exit 1
fi

# Initialize Capacitor if not already done
if [ ! -d "android" ]; then
    echo "📱 Initializing Capacitor Android..."
    npx cap add android
fi

# Sync web assets
echo "🔄 Syncing web assets to native..."
npx cap sync

# Build APK
echo "📱 Building APK..."
if [ -d "android" ]; then
    cd android
    echo "🏗️  Running Gradle build..."
    ./gradlew assembleDebug

    if [ -f "app/build/outputs/apk/debug/app-debug.apk" ]; then
        echo "✅ APK built successfully!"
        echo "📁 APK location: $(pwd)/app/build/outputs/apk/debug/app-debug.apk"
        echo ""
        echo "📲 To install on device:"
        echo "   adb install app/build/outputs/apk/debug/app-debug.apk"
        echo ""
        echo "🔍 To test on emulator:"
        echo "   ./gradlew installDebug"
    else
        echo "❌ APK build failed. Check the logs above for errors."
        exit 1
    fi
else
    echo "❌ Android platform not found. Run 'npx cap add android' first."
    exit 1
fi

echo ""
echo "🎉 Build complete! Your COTS Tracker APK is ready."