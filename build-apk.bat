@echo off
REM Dag-ag Tracker Mobile Build Script for Windows
REM This script helps build APK files for Android

echo Building Dag-ag Tracker APK...

REM Check if Node.js is installed
node --version >nul 2>&1
if %errorlevel% neq 0 (
    echo Node.js is not installed. Please install Node.js 16+ first.
    pause
    exit /b 1
)

REM Check if npm is installed
npm --version >nul 2>&1
if %errorlevel% neq 0 (
    echo npm is not installed. Please install npm first.
    pause
    exit /b 1
)

REM Install dependencies
echo Installing dependencies...
npm install

REM Build web assets
echo Building web assets...
npm run build

REM Check if Capacitor is available
npx --version >nul 2>&1
if %errorlevel% neq 0 (
    echo npx is not available. Please check your Node.js installation.
    pause
    exit /b 1
)

REM Initialize Capacitor if not already done
if not exist "android" (
    echo Initializing Capacitor Android...
    npx cap add android
)

REM Sync web assets
echo Syncing web assets to native...
npx cap sync

REM Build APK
echo Building APK...
if exist "android" (
    cd android
    echo Running Gradle build...
    call gradlew.bat assembleDebug

    if exist "app\build\outputs\apk\debug\app-debug.apk" (
        echo APK built successfully!
        echo APK location: %cd%\app\build\outputs\apk\debug\app-debug.apk
        echo.
        echo To install on device:
        echo   adb install app\build\outputs\apk\debug\app-debug.apk
        echo.
        echo To test on emulator:
        echo   call gradlew.bat installDebug
    ) else (
        echo APK build failed. Check the logs above for errors.
        cd ..
        pause
        exit /b 1
    )
) else (
    echo Android platform not found. Run 'npx cap add android' first.
    pause
    exit /b 1
)

echo.
echo Build complete! Your Dag-ag Tracker APK is ready.
pause