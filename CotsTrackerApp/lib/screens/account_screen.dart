import 'package:flutter/material.dart';
import 'package:provider/provider.dart';

import '../state/app_state.dart';
import '../theme/cots_theme.dart';

class AccountScreen extends StatefulWidget {
  const AccountScreen({super.key});

  @override
  State<AccountScreen> createState() => _AccountScreenState();
}

class _AccountScreenState extends State<AccountScreen> {
  final _profileKey = GlobalKey<FormState>();
  final _passwordKey = GlobalKey<FormState>();
  late final TextEditingController _name;
  late final TextEditingController _email;
  final _current = TextEditingController();
  final _password = TextEditingController();
  final _confirmation = TextEditingController();
  bool _busy = false;
  bool _hidePasswords = true;

  @override
  void initState() {
    super.initState();
    final user = context.read<AppState>().user;
    _name = TextEditingController(text: '${user?['name'] ?? ''}');
    _email = TextEditingController(text: '${user?['email'] ?? ''}');
  }

  @override
  void dispose() {
    _name.dispose();
    _email.dispose();
    _current.dispose();
    _password.dispose();
    _confirmation.dispose();
    super.dispose();
  }

  void _message(String text, {bool error = false}) {
    ScaffoldMessenger.of(context).showSnackBar(
      SnackBar(
        content: Text(text),
        backgroundColor: error ? Theme.of(context).colorScheme.error : null,
      ),
    );
  }

  Future<void> _saveProfile() async {
    if (!_profileKey.currentState!.validate()) return;
    setState(() => _busy = true);
    final error = await context.read<AppState>().updateProfile(_name.text);
    if (mounted) {
      setState(() => _busy = false);
      _message(error ?? 'Profile updated.', error: error != null);
    }
  }

  Future<void> _savePassword() async {
    if (!_passwordKey.currentState!.validate()) return;
    setState(() => _busy = true);
    final error = await context.read<AppState>().updatePassword(
      _current.text,
      _password.text,
    );
    if (mounted) {
      setState(() => _busy = false);
      if (error == null) {
        _current.clear();
        _password.clear();
        _confirmation.clear();
      }
      _message(error ?? 'Password updated.', error: error != null);
    }
  }

  @override
  Widget build(BuildContext context) {
    return ListView(
      padding: const EdgeInsets.all(20),
      children: [
        Text(
          'My account',
          style: Theme.of(
            context,
          ).textTheme.headlineSmall?.copyWith(fontWeight: FontWeight.w800),
        ),
        const SizedBox(height: 6),
        Text(
          'Keep your observer details and account security up to date.',
          style: Theme.of(context).textTheme.bodyLarge,
        ),
        const SizedBox(height: 20),
        _AccountCard(
          icon: Icons.person_outline,
          title: 'Profile information',
          child: Form(
            key: _profileKey,
            child: Column(
              children: [
                TextFormField(
                  controller: _name,
                  textInputAction: TextInputAction.next,
                  decoration: const InputDecoration(
                    labelText: 'Full name',
                    prefixIcon: Icon(Icons.badge_outlined),
                  ),
                  validator: (v) => v == null || v.trim().isEmpty
                      ? 'Name is required.'
                      : null,
                ),
                const SizedBox(height: 12),
                TextFormField(
                  controller: _email,
                  readOnly: true,
                  enabled: false,
                  decoration: const InputDecoration(
                    labelText: 'Email address',
                    prefixIcon: Icon(Icons.mail_outline),
                    helperText:
                        'Email is tied to your account and cannot be changed.',
                  ),
                ),
                const SizedBox(height: 16),
                SizedBox(
                  width: double.infinity,
                  child: FilledButton.icon(
                    onPressed: _busy ? null : _saveProfile,
                    icon: const Icon(Icons.save_outlined),
                    label: const Text('Save profile'),
                  ),
                ),
              ],
            ),
          ),
        ),
        const SizedBox(height: 14),
        _AccountCard(
          icon: Icons.lock_outline,
          title: 'Change password',
          child: Form(
            key: _passwordKey,
            child: Column(
              children: [
                for (final field in [
                  (_current, 'Current password'),
                  (_password, 'New password'),
                  (_confirmation, 'Confirm new password'),
                ]) ...[
                  TextFormField(
                    controller: field.$1,
                    obscureText: _hidePasswords,
                    decoration: InputDecoration(
                      labelText: field.$2,
                      prefixIcon: const Icon(Icons.key),
                      suffixIcon: IconButton(
                        onPressed: () =>
                            setState(() => _hidePasswords = !_hidePasswords),
                        icon: Icon(
                          _hidePasswords
                              ? Icons.visibility_outlined
                              : Icons.visibility_off_outlined,
                        ),
                      ),
                    ),
                    validator: (v) {
                      if (v == null || v.isEmpty) {
                        return '${field.$2} is required.';
                      }
                      if (field.$1 != _current && v.length < 8) {
                        return 'Use at least 8 characters.';
                      }
                      if (field.$1 == _confirmation && v != _password.text) {
                        return 'Passwords do not match.';
                      }
                      return null;
                    },
                  ),
                  const SizedBox(height: 12),
                ],
                SizedBox(
                  width: double.infinity,
                  child: FilledButton.tonalIcon(
                    onPressed: _busy ? null : _savePassword,
                    icon: const Icon(Icons.security),
                    label: const Text('Update password'),
                  ),
                ),
              ],
            ),
          ),
        ),
      ],
    );
  }
}

class _AccountCard extends StatelessWidget {
  const _AccountCard({
    required this.icon,
    required this.title,
    required this.child,
  });
  final IconData icon;
  final String title;
  final Widget child;

  @override
  Widget build(BuildContext context) => Card(
    child: Padding(
      padding: const EdgeInsets.all(18),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          Row(
            children: [
              CircleAvatar(
                backgroundColor: CotsColors.primaryContainer,
                child: Icon(icon, color: CotsColors.primary),
              ),
              const SizedBox(width: 12),
              Expanded(
                child: Text(
                  title,
                  style: Theme.of(
                    context,
                  ).textTheme.titleLarge?.copyWith(fontWeight: FontWeight.w800),
                ),
              ),
            ],
          ),
          const SizedBox(height: 18),
          child,
        ],
      ),
    ),
  );
}
