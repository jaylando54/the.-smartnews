# Rwanda Today — PHP/MySQL starter

## Requirements
- PHP 8.1+ with PDO MySQL enabled
- MySQL 8+ or MariaDB
- Apache (XAMPP is suitable for local development)

## Install locally with XAMPP
1. Copy the `rwanda_today` folder into `C:\xampp\htdocs\`.
2. Start Apache and MySQL in XAMPP.
3. Open phpMyAdmin and import `database.sql`.
4. Edit `config.php` and enter your MySQL username/password.
5. Visit `http://localhost/rwanda_today/`.
6. Register your own account.
7. In phpMyAdmin run:
   `UPDATE users SET role='admin' WHERE email='YOUR_EMAIL_ADDRESS';`
8. Visit `http://localhost/rwanda_today/admin.php` to verify payment requests.

## Included
- Registration with password hashing
- Login and logout with session ID regeneration
- CSRF token checks on POST forms
- Free and premium article access enforced by PHP
- Monthly/yearly membership request records
- MTN/Airtel payment-reference submission
- Admin approval/rejection and subscription activation
- Basic responsive news homepage and styling

## Important before public launch
This is a development starter, not a production-ready payment integration.
- Payment requests are manual: the administrator must independently verify the transaction in the official merchant account before approving.
- No real MTN MoMo or Airtel Money API call is included. For automatic collection, obtain merchant onboarding and API credentials directly from the providers or an authorized payment aggregator, then implement signed server-side callbacks and verify transaction status server-to-server.
- The yearly price is currently a suggested placeholder of 20,000 RWF. Confirm it before accepting yearly payments.
- Add email verification, password reset, login rate limiting, secure HTTPS cookies, backups, audit logs, image upload validation, privacy/terms pages, and production error logging.
- Configure HTTPS and set secure session cookie settings before deployment.
- Create articles using a trusted admin-only content management form; this starter intentionally does not expose public article creation.
- Never ask users for or store their mobile money PIN or OTP.
