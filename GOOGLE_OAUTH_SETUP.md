# Google Sign-In (Identity Services) Setup Guide

"Sign in with Google" uses **Google Identity Services (GIS)** — the modern client-side
`google.accounts.id` API. The browser shows Google's own button, gets a signed ID token,
and posts it to your server, which verifies it against Google's public keys. **No OAuth
secret is needed**, only the public **Client ID**.

The "forgot password" flow uses Laravel's built-in password reset, which sends the reset
email through the mail driver configured in `.env`.

The code is fully wired. Your Client ID is already set in `.env` (`GOOGLE_CLIENT_ID`).

## 1. Confirm the OAuth client

1. Go to https://console.cloud.google.com and open the project that owns the Client ID
   (`1002000471378-893gvh3o5mp7tlg2tedor3se18i7skoi.apps.googleusercontent.com`).
2. Go to **APIs & Services → OAuth consent screen**:
   - Make sure your Google account email is listed under **Test users** (the app runs in
     Testing mode until it's verified, so only test users can sign in).
3. Go to **APIs & Services → Credentials**, open the OAuth client, and under
   **Authorized JavaScript origins** add the page origin you'll run the site on:
   - `http://127.0.0.1:8000` for local development
   - your production origin (e.g. `https://bella-artista.com`) when you deploy

> GIS verifies the origin of the page that shows the button. If your origin isn't listed,
> the popup/redirect will be refused with an error in the browser console.

## 2. Verify `.env`

```
GOOGLE_CLIENT_ID=1002000471378-893gvh3o5mp7tlg2tedor3se18i7skoi.apps.googleusercontent.com
```

Refresh the cached config if your environment caches it:

```
php artisan config:clear
```

## 3. Configure a mail driver (for password reset)

Laravel's reset flow needs an SMTP provider. Set the standard `MAIL_*` values in `.env`:

```
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=you@gmail.com
MAIL_PASSWORD=<app password>
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=you@gmail.com
MAIL_FROM_NAME="${APP_NAME}"
```

Easy options: **Gmail** (needs an app password), **Mailgun**, **SES**, or your host's SMTP.
Until a real driver is set, the reset pages work but the email won't send.

## 4. Test the flows

1. Restart `php artisan serve` if it was running.
2. Open `http://127.0.0.1:8000/login`:
   - **Google sign-in**: click the Google button (rendered by GIS), pick your test account,
     and you're logged in. A customer account is created on first sign-in and linked by
     `google_id`. Admin accounts cannot sign in via Google (blocked for safety).
   - **Forgot password**: click "Forgot your password?", enter the account email, and submit.
     A reset email with a signed link is sent to that address.
3. Follow the link → set a new password → you're logged in automatically.
4. Verify `/account/orders` still loads and the navbar bell works.

## How it works

- The login page loads `https://accounts.google.com/gsi/client` and calls
  `google.accounts.id.renderButton(...)` into the `#googleLoginBtn` container.
- On sign-in, GIS returns a signed JWT (`credential`), which the page POSTs to
  `POST /login/google` (`app/Http/Controllers/GoogleAuthController.php`).
- The server verifies the JWT with `firebase/php-jwt`: signature against Google's
  keys (`https://www.googleapis.com/oauth2/v3/certs`, cached for 1 hour), `iss` must be
  `accounts.google.com`, and `aud` must equal your `GOOGLE_CLIENT_ID`. It then finds or
  creates the customer by email / `google_id` and logs them in.
- Forgot password routes live in `app/Http/Controllers/PasswordResetController.php`
  (`/password/reset`, `/password/email`, `/password/reset/{token}`) and use Laravel's
  password broker with the `password_resets` table. Views are in
  `resources/views/auth/passwords/`.

## Troubleshooting

- **Button shows but popup is refused** → add the page origin to the OAuth client's
  **Authorized JavaScript origins** (step 1.3).
- **"access_denied" / "Unverified app" screen** → add your email under OAuth consent screen
  → **Test users**; testing-mode apps only accept test users.
- **Server returns a Google error / `Invalid token audience`** → make sure `GOOGLE_CLIENT_ID`
  in `.env` matches the client the page used, then run `php artisan config:clear`.
- **Reset email never arrives** → configure a real `MAIL_*` provider (step 3) and check Spam.
- **Google button never appears** → open the browser console; a failed script/JS error points
  to the cause. With `GOOGLE_CLIENT_ID` empty the button is intentionally not rendered.
