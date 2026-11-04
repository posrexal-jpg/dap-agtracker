import 'package:flutter/material.dart';

import '../theme/cots_theme.dart';

class CotsMark extends StatelessWidget {
  const CotsMark({this.size = 88, this.framed = true, super.key});

  final double size;
  final bool framed;

  @override
  Widget build(BuildContext context) => Semantics(
    label: 'COTS Tracker logo',
    image: true,
    child: ExcludeSemantics(
      child: Container(
        width: size,
        height: size,
        padding: EdgeInsets.all(framed ? size * 0.04 : 0),
        decoration: framed
            ? BoxDecoration(
                color: Colors.white,
                borderRadius: BorderRadius.circular(size * 0.27),
                border: Border.all(color: CotsColors.divider),
                boxShadow: [
                  BoxShadow(
                    color: CotsColors.primaryDark.withValues(alpha: 0.08),
                    blurRadius: size * 0.3,
                    offset: const Offset(0, 6),
                  ),
                ],
              )
            : null,
        child: Transform.scale(
          scale: 1.18,
          child: Image.asset(
            'assets/images/cots_mark.png',
            fit: BoxFit.contain,
            cacheWidth: 512,
          ),
        ),
      ),
    ),
  );
}

class OceanBackdrop extends StatelessWidget {
  const OceanBackdrop({required this.child, super.key});

  final Widget child;

  @override
  Widget build(BuildContext context) => Stack(
    fit: StackFit.expand,
    children: [
      const DecoratedBox(
        decoration: BoxDecoration(gradient: CotsColors.backdrop),
      ),
      Positioned(
        top: -100,
        right: -90,
        child: IgnorePointer(
          child: Container(
            width: 320,
            height: 320,
            decoration: BoxDecoration(
              shape: BoxShape.circle,
              border: Border.all(
                color: CotsColors.primary.withValues(alpha: 0.07),
                width: 52,
              ),
            ),
          ),
        ),
      ),
      Positioned(
        bottom: -110,
        left: -100,
        child: IgnorePointer(
          child: Container(
            width: 280,
            height: 280,
            decoration: BoxDecoration(
              shape: BoxShape.circle,
              color: CotsColors.primary.withValues(alpha: 0.04),
            ),
          ),
        ),
      ),
      child,
    ],
  );
}

class PartnerLogoStrip extends StatelessWidget {
  const PartnerLogoStrip({super.key});

  @override
  Widget build(BuildContext context) => Wrap(
    alignment: WrapAlignment.center,
    crossAxisAlignment: WrapCrossAlignment.center,
    spacing: 14,
    runSpacing: 10,
    children: [
      _logo('assets/images/slsu-logo.png', 'SLSU Bontoc'),
      const Text('×', style: TextStyle(color: CotsColors.muted)),
      _logo('assets/images/dost-logo.png', 'DOST'),
    ],
  );

  Widget _logo(String asset, String name) => Row(
    mainAxisSize: MainAxisSize.min,
    children: [
      Image.asset(
        asset,
        width: 30,
        height: 30,
        fit: BoxFit.contain,
        cacheWidth: 192,
        semanticLabel: '$name logo',
      ),
      const SizedBox(width: 7),
      Flexible(
        child: Text(
          name,
          style: const TextStyle(
            color: CotsColors.ink,
            fontSize: 12,
            fontWeight: FontWeight.w700,
          ),
        ),
      ),
    ],
  );
}
