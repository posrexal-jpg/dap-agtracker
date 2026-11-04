import 'package:flutter/material.dart';

import '../services/local_store.dart';
import '../theme/cots_theme.dart';
import 'app_brand.dart';

Future<void> showPartnershipWelcome(BuildContext context) => showDialog<void>(
  context: context,
  builder: (_) => const PartnershipWelcomeDialog(),
);

/// The welcome is shown to both existing and new installations once.
class PartnershipWelcomeGate extends StatefulWidget {
  const PartnershipWelcomeGate({required this.child, this.store, super.key});

  final Widget child;
  final LocalStore? store;

  @override
  State<PartnershipWelcomeGate> createState() => _PartnershipWelcomeGateState();
}

class _PartnershipWelcomeGateState extends State<PartnershipWelcomeGate> {
  @override
  void initState() {
    super.initState();
    WidgetsBinding.instance.addPostFrameCallback((_) async {
      if (!mounted) return;
      final store = widget.store ?? LocalStore();
      if (store.hasSeenPartnershipWelcome) return;
      await showPartnershipWelcome(context);
      await store.markPartnershipWelcomeSeen();
    });
  }

  @override
  Widget build(BuildContext context) => widget.child;
}

class PartnershipWelcomeDialog extends StatelessWidget {
  const PartnershipWelcomeDialog({super.key});

  @override
  Widget build(BuildContext context) => Dialog(
    insetPadding: const EdgeInsets.symmetric(horizontal: 20, vertical: 24),
    clipBehavior: Clip.antiAlias,
    child: ConstrainedBox(
      constraints: const BoxConstraints(maxWidth: 520),
      child: Column(
        mainAxisSize: MainAxisSize.min,
        crossAxisAlignment: CrossAxisAlignment.stretch,
        children: [
          Flexible(
            child: SingleChildScrollView(
              child: Column(
                mainAxisSize: MainAxisSize.min,
                crossAxisAlignment: CrossAxisAlignment.stretch,
                children: [
                  Container(
                    padding: const EdgeInsets.fromLTRB(24, 12, 12, 25),
                    decoration: const BoxDecoration(
                      gradient: LinearGradient(
                        colors: [CotsColors.primaryDark, CotsColors.primary],
                        begin: Alignment.topLeft,
                        end: Alignment.bottomRight,
                      ),
                    ),
                    child: Column(
                      crossAxisAlignment: CrossAxisAlignment.start,
                      children: [
                        Row(
                          children: [
                            const Expanded(
                              child: Text(
                                'WELCOME TO COTS TRACKER',
                                style: TextStyle(
                                  color: Color(0xFFBDE8E4),
                                  fontSize: 11,
                                  fontWeight: FontWeight.w700,
                                  letterSpacing: 1.3,
                                ),
                              ),
                            ),
                            IconButton(
                              tooltip: 'Close welcome',
                              onPressed: () => Navigator.pop(context),
                              icon: const Icon(
                                Icons.close,
                                color: Colors.white,
                              ),
                            ),
                          ],
                        ),
                        const SizedBox(height: 4),
                        Row(
                          children: [
                            Expanded(
                              child: Text(
                                'Stronger together.\nHealthier reefs.',
                                style: Theme.of(context).textTheme.headlineSmall
                                    ?.copyWith(
                                      color: Colors.white,
                                      fontWeight: FontWeight.w800,
                                      height: 1.15,
                                      letterSpacing: -0.5,
                                    ),
                              ),
                            ),
                            const SizedBox(width: 12),
                            const CotsMark(size: 76),
                          ],
                        ),
                      ],
                    ),
                  ),
                  Padding(
                    padding: const EdgeInsets.all(24),
                    child: Column(
                      crossAxisAlignment: CrossAxisAlignment.stretch,
                      children: [
                        Text(
                          'Our shared mission',
                          style: Theme.of(context).textTheme.titleLarge
                              ?.copyWith(
                                fontWeight: FontWeight.w800,
                                letterSpacing: -0.3,
                              ),
                        ),
                        const SizedBox(height: 12),
                        const Text(
                          'Developed in partnership with SLSU Bontoc and DOST, '
                          'COTS Tracker connects science, education, and community '
                          'action for healthier reefs.',
                          style: TextStyle(
                            color: CotsColors.muted,
                            height: 1.5,
                          ),
                        ),
                        const SizedBox(height: 20),
                        LayoutBuilder(
                          builder: (context, constraints) {
                            if (constraints.maxWidth < 240 ||
                                MediaQuery.textScalerOf(context).scale(1) >
                                    1.25) {
                              return const Column(
                                children: [
                                  _PartnerCard(slsu: true, horizontal: true),
                                  SizedBox(height: 10),
                                  _PartnerCard(slsu: false, horizontal: true),
                                ],
                              );
                            }
                            return const IntrinsicHeight(
                              child: Row(
                                crossAxisAlignment: CrossAxisAlignment.stretch,
                                children: [
                                  Expanded(child: _PartnerCard(slsu: true)),
                                  SizedBox(width: 12),
                                  Expanded(child: _PartnerCard(slsu: false)),
                                ],
                              ),
                            );
                          },
                        ),
                        const SizedBox(height: 20),
                        Container(
                          padding: const EdgeInsets.all(14),
                          decoration: BoxDecoration(
                            color: CotsColors.primaryContainer,
                            borderRadius: BorderRadius.circular(16),
                          ),
                          child: const Row(
                            crossAxisAlignment: CrossAxisAlignment.start,
                            children: [
                              Icon(
                                Icons.waves_rounded,
                                color: CotsColors.primary,
                              ),
                              SizedBox(width: 10),
                              Expanded(
                                child: Text(
                                  'Record crown-of-thorns starfish sightings in Southern Leyte, '
                                  'even beyond network coverage.',
                                  style: TextStyle(
                                    color: CotsColors.primaryDark,
                                    height: 1.45,
                                  ),
                                ),
                              ),
                            ],
                          ),
                        ),
                      ],
                    ),
                  ),
                ],
              ),
            ),
          ),
          Container(
            padding: const EdgeInsets.fromLTRB(24, 12, 24, 20),
            decoration: const BoxDecoration(
              border: Border(top: BorderSide(color: CotsColors.divider)),
            ),
            child: FilledButton.icon(
              onPressed: () => Navigator.pop(context),
              icon: const Icon(Icons.arrow_forward_rounded),
              label: const Text('Get started'),
            ),
          ),
        ],
      ),
    ),
  );
}

class _PartnerCard extends StatelessWidget {
  const _PartnerCard({required this.slsu, this.horizontal = false});

  final bool slsu;
  final bool horizontal;

  @override
  Widget build(BuildContext context) {
    final image = Image.asset(
      slsu ? 'assets/images/slsu-logo.png' : 'assets/images/dost-logo.png',
      width: 48,
      height: 48,
      fit: BoxFit.contain,
      cacheWidth: 192,
      semanticLabel: slsu ? 'SLSU logo' : 'DOST logo',
    );
    final details = Column(
      mainAxisSize: MainAxisSize.min,
      crossAxisAlignment: horizontal
          ? CrossAxisAlignment.start
          : CrossAxisAlignment.center,
      children: [
        Text(
          slsu ? 'SLSU' : 'DOST',
          style: const TextStyle(
            fontSize: 17,
            fontWeight: FontWeight.w800,
            color: CotsColors.ink,
          ),
        ),
        const SizedBox(height: 4),
        Text(
          slsu
              ? 'Southern Leyte State University'
              : 'Department of Science and Technology',
          textAlign: horizontal ? TextAlign.left : TextAlign.center,
          style: const TextStyle(
            fontSize: 12,
            height: 1.4,
            color: CotsColors.muted,
          ),
        ),
        if (slsu) ...[
          const SizedBox(height: 3),
          const Text(
            'Bontoc Campus',
            style: TextStyle(
              fontSize: 11,
              fontWeight: FontWeight.w700,
              color: CotsColors.primary,
            ),
          ),
        ],
      ],
    );
    return Container(
      width: double.infinity,
      padding: const EdgeInsets.all(16),
      decoration: BoxDecoration(
        color: CotsColors.background,
        border: Border.all(color: CotsColors.divider),
        borderRadius: BorderRadius.circular(18),
      ),
      child: horizontal
          ? Row(
              children: [
                image,
                const SizedBox(width: 14),
                Expanded(child: details),
              ],
            )
          : Column(
              mainAxisSize: MainAxisSize.min,
              children: [image, const SizedBox(height: 12), details],
            ),
    );
  }
}
