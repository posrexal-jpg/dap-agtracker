import 'package:flutter/material.dart';

import '../widgets/app_version_text.dart';
import '../theme/cots_theme.dart';
import '../widgets/app_brand.dart';

class LoadingScreen extends StatefulWidget {
  const LoadingScreen({super.key});

  @override
  State<LoadingScreen> createState() => _LoadingScreenState();
}

class _LoadingScreenState extends State<LoadingScreen>
    with SingleTickerProviderStateMixin {
  late final AnimationController _controller;
  late final Animation<double> _scale;
  late final Animation<double> _opacity;

  @override
  void initState() {
    super.initState();
    _controller = AnimationController(
      vsync: this,
      duration: const Duration(milliseconds: 1300),
    )..repeat(reverse: true);
    _scale = Tween<double>(begin: 0.94, end: 1.04).animate(
      CurvedAnimation(parent: _controller, curve: Curves.easeInOutCubic),
    );
    _opacity = Tween<double>(
      begin: 0.58,
      end: 1,
    ).animate(CurvedAnimation(parent: _controller, curve: Curves.easeInOut));
  }

  @override
  void dispose() {
    _controller.dispose();
    super.dispose();
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      body: OceanBackdrop(
        child: SafeArea(
          child: Center(
            child: SingleChildScrollView(
              padding: const EdgeInsets.all(24),
              child: Column(
                mainAxisSize: MainAxisSize.min,
                children: [
                  FadeTransition(
                    opacity: _opacity,
                    child: ScaleTransition(
                      scale: _scale,
                      child: const CotsMark(size: 152),
                    ),
                  ),
                  const SizedBox(height: 28),
                  Text(
                    'COTS Tracker',
                    style: Theme.of(context).textTheme.headlineMedium?.copyWith(
                      color: CotsColors.ink,
                      fontWeight: FontWeight.w900,
                      letterSpacing: -0.5,
                    ),
                  ),
                  const SizedBox(height: 5),
                  const AppVersionText(),
                  const SizedBox(height: 30),
                  const SizedBox(
                    width: 150,
                    child: LinearProgressIndicator(
                      minHeight: 5,
                      borderRadius: BorderRadius.all(Radius.circular(10)),
                    ),
                  ),
                  const SizedBox(height: 12),
                  Text(
                    'Preparing field data…',
                    style: Theme.of(
                      context,
                    ).textTheme.bodyMedium?.copyWith(color: CotsColors.muted),
                  ),
                  const SizedBox(height: 32),
                  const PartnerLogoStrip(),
                ],
              ),
            ),
          ),
        ),
      ),
    );
  }
}
