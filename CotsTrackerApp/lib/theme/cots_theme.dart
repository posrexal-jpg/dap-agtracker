import 'package:flutter/material.dart';

/// Shared ocean colors for field monitoring and partnership branding.
abstract final class CotsColors {
  static const primary = Color(0xFF006D77);
  static const primaryLight = Color(0xFF008C95);
  static const primaryDark = Color(0xFF073747);
  static const primaryContainer = Color(0xFFDEF2F0);
  static const accent = Color(0xFFC75749);
  static const background = Color(0xFFF3F7F8);
  static const ink = Color(0xFF14323C);
  static const muted = Color(0xFF5B727D);
  static const divider = Color(0xFFDDE8EB);

  static const backdrop = LinearGradient(
    begin: Alignment.topLeft,
    end: Alignment.bottomRight,
    colors: [Color(0xFFE4F4F3), Color(0xFFF5F8FA), Color(0xFFE8EFF7)],
  );
}

/// Native equivalents of Materialize cards, waves, buttons and input fields.
/// CSS cannot style Flutter's rendered widget tree, including on the web.
ThemeData buildCotsTheme() {
  final scheme =
      ColorScheme.fromSeed(
        seedColor: CotsColors.primary,
        brightness: Brightness.light,
      ).copyWith(
        primary: CotsColors.primary,
        onPrimary: Colors.white,
        primaryContainer: CotsColors.primaryContainer,
        onPrimaryContainer: CotsColors.primaryDark,
        secondary: CotsColors.accent,
        onSecondary: Colors.white,
        secondaryContainer: const Color(0xFFFBE9E7),
        onSecondaryContainer: const Color(0xFF8C342B),
        surface: Colors.white,
        onSurface: CotsColors.ink,
        onSurfaceVariant: CotsColors.muted,
        outline: const Color(0xFF9E9E9E),
        outlineVariant: CotsColors.divider,
        error: const Color(0xFFC62828),
        onError: Colors.white,
      );
  const shape = RoundedRectangleBorder(
    borderRadius: BorderRadius.all(Radius.circular(14)),
  );
  final base = ThemeData(useMaterial3: true, colorScheme: scheme);
  final buttonText = base.textTheme.labelLarge!.copyWith(
    fontWeight: FontWeight.w600,
    fontSize: 14,
    letterSpacing: 0.6,
  );

  return base.copyWith(
    scaffoldBackgroundColor: CotsColors.background,
    splashFactory: InkRipple.splashFactory,
    textSelectionTheme: TextSelectionThemeData(
      cursorColor: scheme.primary,
      selectionColor: CotsColors.primaryLight.withValues(alpha: 0.24),
      selectionHandleColor: scheme.primary,
    ),
    appBarTheme: const AppBarTheme(
      backgroundColor: CotsColors.primary,
      foregroundColor: Colors.white,
      elevation: 2,
      surfaceTintColor: Colors.transparent,
    ),
    inputDecorationTheme: InputDecorationTheme(
      filled: true,
      fillColor: const Color(0xFFF8FBFC),
      contentPadding: const EdgeInsets.symmetric(horizontal: 16, vertical: 16),
      border: const OutlineInputBorder(
        borderRadius: BorderRadius.all(Radius.circular(14)),
      ),
      enabledBorder: const OutlineInputBorder(
        borderRadius: BorderRadius.all(Radius.circular(14)),
        borderSide: BorderSide(color: CotsColors.divider),
      ),
      focusedBorder: OutlineInputBorder(
        borderRadius: const BorderRadius.all(Radius.circular(14)),
        borderSide: BorderSide(color: scheme.primary, width: 2),
      ),
      errorBorder: OutlineInputBorder(
        borderRadius: const BorderRadius.all(Radius.circular(14)),
        borderSide: BorderSide(color: scheme.error),
      ),
      focusedErrorBorder: OutlineInputBorder(
        borderRadius: const BorderRadius.all(Radius.circular(14)),
        borderSide: BorderSide(color: scheme.error, width: 2),
      ),
      disabledBorder: const OutlineInputBorder(
        borderRadius: BorderRadius.all(Radius.circular(14)),
        borderSide: BorderSide(color: CotsColors.divider),
      ),
      floatingLabelStyle: TextStyle(color: scheme.primary),
      helperMaxLines: 3,
      errorMaxLines: 3,
    ),
    cardTheme: const CardThemeData(
      color: Colors.white,
      clipBehavior: Clip.antiAlias,
      surfaceTintColor: Colors.transparent,
      elevation: 0,
      margin: EdgeInsets.zero,
      shadowColor: Color(0x18073747),
      shape: RoundedRectangleBorder(
        borderRadius: BorderRadius.all(Radius.circular(22)),
        side: BorderSide(color: CotsColors.divider),
      ),
    ),
    filledButtonTheme: FilledButtonThemeData(
      style: FilledButton.styleFrom(
        minimumSize: const Size(64, 48),
        padding: const EdgeInsets.symmetric(horizontal: 20, vertical: 12),
        elevation: 0,
        shadowColor: Colors.black38,
        shape: shape,
        textStyle: buttonText,
      ),
    ),
    elevatedButtonTheme: ElevatedButtonThemeData(
      style: ElevatedButton.styleFrom(
        backgroundColor: scheme.primary,
        foregroundColor: scheme.onPrimary,
        minimumSize: const Size(64, 48),
        elevation: 2,
        shape: shape,
        textStyle: buttonText,
      ),
    ),
    outlinedButtonTheme: OutlinedButtonThemeData(
      style: OutlinedButton.styleFrom(
        foregroundColor: scheme.primary,
        minimumSize: const Size(64, 48),
        shape: shape,
        textStyle: buttonText,
      ),
    ),
    textButtonTheme: TextButtonThemeData(
      style: TextButton.styleFrom(
        foregroundColor: scheme.primary,
        minimumSize: const Size(48, 48),
        shape: shape,
        textStyle: buttonText,
      ),
    ),
    floatingActionButtonTheme: const FloatingActionButtonThemeData(
      backgroundColor: CotsColors.accent,
      foregroundColor: Colors.white,
      elevation: 4,
      shape: CircleBorder(),
    ),
    navigationBarTheme: NavigationBarThemeData(
      backgroundColor: Colors.white,
      surfaceTintColor: Colors.transparent,
      indicatorColor: scheme.primaryContainer,
      elevation: 2,
      indicatorShape: const RoundedRectangleBorder(
        borderRadius: BorderRadius.all(Radius.circular(16)),
      ),
      labelTextStyle: WidgetStateProperty.resolveWith(
        (states) => TextStyle(
          color: states.contains(WidgetState.selected)
              ? scheme.primary
              : CotsColors.muted,
          fontWeight: states.contains(WidgetState.selected)
              ? FontWeight.w700
              : FontWeight.w500,
          fontSize: 12,
        ),
      ),
    ),
    navigationRailTheme: NavigationRailThemeData(
      backgroundColor: Colors.white,
      indicatorColor: scheme.primaryContainer,
      selectedIconTheme: IconThemeData(color: scheme.primary),
      selectedLabelTextStyle: TextStyle(
        color: scheme.primary,
        fontWeight: FontWeight.w700,
      ),
      unselectedIconTheme: const IconThemeData(color: CotsColors.muted),
    ),
    chipTheme: base.chipTheme.copyWith(
      backgroundColor: const Color(0xFFEEEEEE),
      selectedColor: scheme.primaryContainer,
      side: BorderSide.none,
      shape: const StadiumBorder(),
    ),
    dialogTheme: const DialogThemeData(
      backgroundColor: Colors.white,
      surfaceTintColor: Colors.transparent,
      shape: RoundedRectangleBorder(
        borderRadius: BorderRadius.all(Radius.circular(28)),
      ),
    ),
    snackBarTheme: const SnackBarThemeData(
      backgroundColor: Color(0xFF323232),
      contentTextStyle: TextStyle(color: Colors.white),
      actionTextColor: Color(0xFF80CBC4),
      behavior: SnackBarBehavior.floating,
      shape: shape,
    ),
    dividerTheme: const DividerThemeData(color: CotsColors.divider),
    progressIndicatorTheme: const ProgressIndicatorThemeData(
      color: CotsColors.primary,
      linearTrackColor: CotsColors.primaryContainer,
    ),
  );
}
