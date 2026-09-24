# ProPark

**A Laravel-based parking management, subscription, and software licensing platform**

<p align="center">
  <img src="public/images/ProPark.png" width="220" alt="ProPark Logo">
</p>

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-11.x-FF2D20?logo=laravel&logoColor=white" alt="Laravel 11">
  <img src="https://img.shields.io/badge/PHP-%E2%89%A58.2-777BB4?logo=php&logoColor=white" alt="PHP 8.2+">
  <img src="https://img.shields.io/badge/TailwindCSS-3.x-38B2AC?logo=tailwindcss&logoColor=white" alt="Tailwind CSS">
  <img src="https://img.shields.io/badge/Vite-6.x-646CFF?logo=vite&logoColor=white" alt="Vite">
</p>

---

## About

**ProPark** is a Laravel-based web platform designed to manage the web infrastructure of a parking management software ecosystem.

It provides subscription management, software licensing, device management, user and administration panels, a licensing REST API, database backup and restore functionality, a blog system, and multilingual support.

A production deployment of ProPark is currently used under the **AvaPark** brand.

The platform works alongside a Windows desktop client, which communicates with the server through the licensing API.

### Core Features

* Software license generation and management
* Subscription store with multiple plans and durations
* User dashboard
* Administration panel
* Licensed device management
* RSA-signed API responses
* Blog and content management
* Persian and English localization
* RTL and LTR support

---

## Features

### Store and Subscriptions

ProPark provides a subscription-based purchasing system with multiple plan levels and subscription durations.

Features include:

* Multi-level subscription plans: Eco, Pro, and Enterprise
* Different features and device limits for each plan
* 1, 3, 6, and 12-month subscription periods
* Discount percentages and original pricing
* Automatic transaction type detection:

  * New purchase
  * Renewal
  * Upgrade
  * Downgrade
* 50% of the remaining subscription time is transferred as a bonus when upgrading
* Full remaining time is preserved when downgrading
* Excess registered devices are automatically removed when required by the new plan limit
* Transaction-safe checkout using database transactions and `lockForUpdate`

The current payment process is simulated and does not yet use a production payment gateway.

---

### Licensing and Device Management

Each subscription can be associated with a unique software license.

License keys use the following format:

```text
PRPK-XXXX-XXXX-XXXX-XXXX
```

The licensing system includes:

* Unique license key generation
* License-to-subscription association
* Device registration using a Machine Fingerprint
* Automatic seat allocation
* Device limits based on subscription plans
* Active device management
* Device deactivation from the user dashboard
* Device deactivation through the REST API
* Precise subscription validity calculation
* RSA/SHA-256 signed API responses

---

### User Dashboard

Registered users can:

* View their current subscription
* Access their license key
* Check remaining subscription time
* View active plan information
* View registered devices
* Deactivate devices
* Update profile information
* Manage their phone number
* Change their password
* Delete their account

Authentication is implemented using **Laravel Breeze** with a custom email verification template.

---

### Administration Panel

The administration panel provides tools for managing the platform.

Administrators can:

* View system statistics
* Monitor users and subscriptions
* View subscriptions approaching expiration
* Manage users
* Change user roles (`admin` / `user`)
* Manage subscriptions
* Change subscription status
* Change subscription plans
* Manually renew subscriptions
* Delete subscriptions
* Manually issue subscriptions and licenses
* Manage store pricing
* Perform bulk price updates
* Create database backups
* Restore the database from SQL backups
* Manage blog categories
* Manage blog posts
* Upload blog images
* Edit content using TinyMCE

---

### Blog

ProPark includes a built-in blog and content management system.

Features include:

* Post categories
* Search
* Category filtering
* Featured posts
* Pagination
* View counting
* Session-based duplicate view prevention
* Reading time calculation
* Related posts
* SEO titles
* SEO descriptions
* Canonical URLs
* Open Graph images
* Soft deletes

---

### Localization

ProPark supports:

* Persian
* English

Translations are stored in:

```text
lang/fa.json
lang/en.json
```

The application supports language switching through:

```text
/locale/{locale}
```

The selected language is stored in the session, and the interface automatically switches between RTL and LTR layouts.

---

## Architecture

A significant portion of the application's business logic is separated from the controllers and implemented through dedicated service classes.

```text
app/
├── Http/
│   ├── Controllers/
│   │   ├── Admin/
│   │   │   ├── DashboardController
│   │   │   ├── UserController
│   │   │   ├── SubscriptionController
│   │   │   ├── StoreController
│   │   │   ├── LicenseCreationController
│   │   │   ├── DatabaseBackupController
│   │   │   ├── CategoryController
│   │   │   └── PostController
│   │   │
│   │   ├── Api/
│   │   │   └── LicenseController
│   │   │
│   │   ├── Auth/
│   │   │
│   │   └── User/
│   │       ├── CartController
│   │       ├── SubscriptionDetailsController
│   │       └── UserDeviceController
│   │
│   ├── Middleware/
│   │   ├── AdminMiddleware
│   │   └── SetLocale
│   │
│   └── Requests/
│
├── Models/
│   ├── User
│   ├── Plan
│   ├── PlanPrice
│   ├── Subscription
│   ├── Cart
│   ├── License
│   ├── LicenseDevice
│   ├── Post
│   └── Category
│
├── Notifications/
│   └── CustomVerifyEmail
│
├── Services/
│   ├── CartService.php
│   ├── CheckoutService.php
│   ├── SubscriptionService.php
│   ├── LicenseService.php
│   ├── LicenseValidatorService.php
│   ├── DeviceService.php
│   ├── DatabaseBackupService.php
│   └── License/
│       └── SignatureService.php
│
└── View/
    └── Components/
```

---

## Data Model

| Table                    | Description                           |
| ------------------------ | ------------------------------------- |
| `users`                  | Application users and roles           |
| `plans`                  | Subscription plan definitions         |
| `plan_prices`            | Plan pricing based on duration        |
| `subscriptions`          | User subscriptions                    |
| `carts`                  | Purchase and plan-change transactions |
| `licenses`               | Generated software licenses           |
| `license_devices`        | Devices registered to licenses        |
| `categories`             | Blog categories                       |
| `posts`                  | Blog posts                            |
| `personal_access_tokens` | Laravel Sanctum tokens                |

---

## Subscription Flow

```text
Select Plan
    |
    v
Create Cart
    |
    v
Checkout
    |
    +-- No existing subscription
    |      |
    |      +-- Purchase
    |             |
    |             +-- New Subscription + License
    |
    +-- Higher-level plan
    |      |
    |      +-- Upgrade
    |             |
    |             +-- Upgrade + 50% Remaining Time Bonus
    |
    +-- Lower-level plan
    |      |
    |      +-- Downgrade
    |             |
    |             +-- Preserve Remaining Time + Device Adjustment
    |
    +-- Same plan
           |
           +-- Renew
                  |
                  +-- Extend Subscription
```

---

## REST API

The Windows client communicates with ProPark through the licensing REST API.

| Method | Endpoint                          | Description                              |
| ------ | --------------------------------- | ---------------------------------------- |
| `POST` | `/api/license/validate`           | Validate a license and register a device |
| `POST` | `/api/license/remaining-validity` | Retrieve remaining subscription validity |
| `POST` | `/api/license/deactivate-device`  | Deactivate a registered device           |
| `POST` | `/api/license/info`               | Retrieve license information             |

### Example Request

```json
{
  "license_key": "PRPK-XXXX-XXXX-XXXX-XXXX",
  "machine_fingerprint": "unique-machine-id"
}
```

### Example Response

```json
{
  "valid": true,
  "message": "Access granted",
  "data": {
    "license_key": "PRPK-XXXX-XXXX-XXXX-XXXX",
    "subscription": {
      "status": "active",
      "effective_status": "active"
    },
    "plan": {
      "slug": "pro"
    },
    "device": {
      "seat_number": 1
    },
    "expires_at": "2026-12-31 23:59:59",
    "remaining": {
      "total_seconds": 8640000,
      "days": 100,
      "hours": 0,
      "minutes": 0,
      "seconds": 0,
      "text": "100 days"
    },
    "remaining_days": 100
  },
  "signature": "base64-encoded-rsa-signature"
}
```

Common API errors include:

```text
Invalid or inactive license
Subscription expired
Device limit reached
This device is not registered for this license
```

---

## API Response Signing

Licensing API responses are digitally signed using **RSA/SHA-256**.

The Windows client uses the corresponding public key to verify that responses originated from the ProPark server and were not modified in transit.

The private key is stored on the server and must never be committed to the repository.

A key pair can be generated using:

```bash
openssl genrsa -out storage/app/license_private.pem 2048

openssl rsa \
    -in storage/app/license_private.pem \
    -pubout \
    -out license_public.pem
```

The generated public key should be distributed with the Windows client for response verification.

---

## Installation

### Requirements

Before installing ProPark, make sure the following software is available:

* PHP 8.2 or later
* Composer
* Node.js 20 or later
* npm
* MySQL or MariaDB
* OpenSSL

SQLite can also be used for testing.

### 1. Clone the Repository

```bash
git clone <repository-url>
cd ProPark
```

### 2. Install PHP Dependencies

```bash
composer install
```

### 3. Install Frontend Dependencies

```bash
npm install
```

### 4. Create the Environment File

```bash
cp .env.example .env
```

### 5. Generate the Application Key

```bash
php artisan key:generate
```

### 6. Configure the Database

Configure the database connection inside `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ProPark
DB_USERNAME=root
DB_PASSWORD=
```

### 7. Run Migrations and Seeders

```bash
php artisan migrate --seed
```

### 8. Create the Storage Link

```bash
php artisan storage:link
```

### 9. Start the Frontend Development Server

```bash
npm run dev
```

For production assets:

```bash
npm run build
```

### 10. Start Laravel

```bash
php artisan serve
```

The application will normally be available at:

```text
http://127.0.0.1:8000
```

---

## Creating an Administrator

There is currently no dedicated administrator seeder.

Create a regular account first and then update its role using Laravel Tinker:

```bash
php artisan tinker
```

Then run:

```php
\App\Models\User::where('email', 'you@example.com')
    ->update(['role' => 'admin']);
```

---

## Seed Data

The project seeder creates three default subscription plans:

| Plan       | Level | Device Limit |
| ---------- | ----: | -----------: |
| Eco        |     1 |            2 |
| Pro        |     2 |            4 |
| Enterprise |     3 |            8 |

Seeded prices are initial application data and can be changed through the administration panel.

---

## Testing

Run the test suite with:

```bash
php artisan test
```

Format the PHP code using Laravel Pint:

```bash
./vendor/bin/pint
```

The project also includes a Composer development script:

```bash
composer dev
```

This can be used to run the development environment and related services together.

---

## Tech Stack

| Category           | Technology      |
| ------------------ | --------------- |
| Backend            | Laravel 11      |
| Language           | PHP 8.2+        |
| Authentication     | Laravel Breeze  |
| API Authentication | Laravel Sanctum |
| Frontend           | Blade           |
| CSS                | Tailwind CSS 3  |
| JavaScript         | Alpine.js 3     |
| Build Tool         | Vite 6          |
| HTTP Client        | Axios           |
| Rich Text Editor   | TinyMCE 6       |
| Database           | MySQL / MariaDB |
| Persian Dates      | morilog/jalali  |
| Testing            | PHPUnit 11      |
| Mocking            | Mockery         |
| Test Data          | Faker           |

---

## Roadmap

Planned improvements include:

* [ ] Production payment gateway integration
* [ ] Subscription expiration notifications
* [ ] Email and SMS notifications
* [ ] Extended Queue and Job usage
* [ ] Advanced role and permission management
* [ ] Swagger/OpenAPI documentation
* [ ] Discount code support
* [ ] Extended payment infrastructure

---

## Project Status

ProPark is under active development.

A production deployment of the platform is currently used under the **AvaPark** brand.

The project demonstrates the implementation of a subscription-based and license-based software architecture using Laravel, including subscription lifecycle management, device-based licensing, administration tools, localization, and API response signing.
