# Google OAuth Setup for Dap-ag Tracker

This guide will help you set up Google OAuth login for the Dap-ag Tracker application.

## Prerequisites

- Google account
- Laravel application with Socialite package installed

## Step 1: Create a Google OAuth Application

1. Go to the [Google Cloud Console](https://console.cloud.google.com/)
2. Create a new project or select an existing one
3. Enable the Google+ API:
   - Go to "APIs & Services" > "Library"
   - Search for "Google+ API" and enable it
4. Create OAuth credentials:
   - Go to "APIs & Services" > "Credentials"
   - Click "Create Credentials" > "OAuth 2.0 Client IDs"
   - Choose "Web application"
   - Add authorized redirect URIs:
     - For development: `http://localhost:8000/auth/google/callback`
     - For production: `https://yourdomain.com/auth/google/callback`

## Step 2: Configure Environment Variables

Update your `.env` file with the Google OAuth credentials:

```env
GOOGLE_CLIENT_ID=your_google_client_id_here
GOOGLE_CLIENT_SECRET=your_google_client_secret_here
GOOGLE_REDIRECT_URI=http://localhost:8000/auth/google/callback
```

Replace the placeholder values with the actual credentials from your Google OAuth application.

## Step 3: Database Migration

The application includes a migration that adds a `google_id` field to the users table. This has already been run, but if you're setting up on a fresh installation:

```bash
php artisan migrate
```

## Step 4: Test the Integration

1. Start your Laravel development server:
   ```bash
   php artisan serve
   ```

2. Visit `http://localhost:8000/login`

3. Click the "Continue with Google" button

4. You should be redirected to Google for authentication

5. After successful authentication, you'll be redirected back to the application

## Features

- **New User Creation**: If a user logs in with Google and doesn't exist in the system, a new account is created with role_id = 2 (regular user)
- **Existing User Linking**: If a user already exists with the same email, their account is linked with the Google ID
- **Role-based Redirect**: After login, users are redirected based on their role (admin to /admin, users to /user/index)

## Security Notes

- The Google OAuth integration uses Laravel Socialite for secure authentication
- User passwords are not required for Google-authenticated users
- All Google OAuth data is handled securely through encrypted tokens

## Troubleshooting

1. **"Invalid client" error**: Check that your GOOGLE_CLIENT_ID and GOOGLE_CLIENT_SECRET are correct
2. **"Redirect URI mismatch" error**: Ensure the redirect URI in Google Console matches your GOOGLE_REDIRECT_URI environment variable
3. **Users not being created**: Check database permissions and ensure the migration has run
4. **Login not working**: Clear Laravel cache with `php artisan config:clear` and `php artisan cache:clear`

## Production Deployment

When deploying to production:

1. Update the authorized redirect URI in Google Cloud Console to your production domain
2. Update the GOOGLE_REDIRECT_URI in your production .env file
3. Ensure HTTPS is enabled for security
4. Consider adding additional user verification steps if needed