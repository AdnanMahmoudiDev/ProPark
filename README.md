# AvaPark

**A web-based platform for selling software licenses and technical support for an intelligent urban parking management application.**

<div align="center">

<img src="public/images/ProPark.png" width="200" alt="AvaPark Logo">

[![Laravel](https://img.shields.io/badge/Laravel-11.x-FF2D20?logo=laravel&logoColor=white)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-%E2%89%A58.2-777BB4?logo=php&logoColor=white)](https://www.php.net)
[![Tailwind CSS](https://img.shields.io/badge/TailwindCSS-3.x-38B2AC?logo=tailwindcss&logoColor=white)](https://tailwindcss.com)
[![Vite](https://img.shields.io/badge/Vite-6.x-646CFF?logo=vite&logoColor=white)](https://vite.dev)
[![Payment](https://img.shields.io/badge/Payment-SEP%20IPG-28A745)](https://www.sep.ir)

**Live Website:** [https://www.avapark.ir](https://www.avapark.ir)

</div>

---

## Table of Contents

- [Overview](#overview)
- [How AvaPark Works](#how-avapark-works)
- [Key Features](#key-features)
- [License and Support Model](#license-and-support-model)
- [Software Plans](#software-plans)
- [Architecture](#architecture)
- [Data Model](#data-model)
- [Purchase and Payment Flow](#purchase-and-payment-flow)
- [Windows Client API](#windows-client-api)
- [API Response Signing](#api-response-signing)
- [Technology Stack](#technology-stack)
- [Requirements](#requirements)
- [Installation](#installation)
- [Configuration](#configuration)
- [Seeded Data](#seeded-data)
- [Administration Access](#administration-access)
- [Development and Testing](#development-and-testing)
- [Security Considerations](#security-considerations)
- [Roadmap](#roadmap)
- [License](#license)

---

## Overview

**AvaPark is the online sales, software licensing, and technical support platform for a Windows application designed to manage urban parking intelligently.**

The Windows application provides the parking management functionality, while AvaPark operates the web-based infrastructure behind its commercial distribution and license management.

The platform enables customers to purchase software licenses, activate the application on authorized devices, manage their licenses, access invoices, and obtain technical support. It also provides administrators with the tools required to manage customers, software plans, payments, support packages, and other business operations.

AvaPark connects the Windows application to the online platform through a REST API that validates licenses, manages device activation, and provides license and support information.

### The platform serves three main purposes

| Area | Purpose |
|---|---|
| **Online Store** | Sell software licenses and technical support packages. |
| **License Management** | Issue and validate licenses, register devices, and enforce device limits. |
| **Business Administration** | Manage customers, orders, payments, support services, and website content. |

AvaPark is not the parking-management application itself. It is the web platform responsible for its online sales, licensing, customer management, and support services.

**Production Website:** [https://www.avapark.ir](https://www.avapark.ir)

---

## How AvaPark Works

AvaPark connects customers, the Windows parking management application, and the business operations behind the software.

1. **Purchase:** A customer selects a software plan and completes checkout.
2. **Payment:** The platform processes the payment and verifies the transaction on the server.
3. **License issuance:** After successful settlement, AvaPark issues the corresponding software license.
4. **Device activation:** The Windows application communicates with AvaPark to validate the license and register the device.
5. **Customer management:** The customer can access license details, registered devices, purchase history, invoices, and support information.
6. **Technical support:** Customers can purchase eligible support packages when they need to extend their support period.
7. **Administration:** Authorized administrators manage the commercial and operational aspects of the platform.

The software license and technical support period are handled separately. A lifetime license does not imply lifetime technical support.

---

## Key Features

### Online Store and Checkout

AvaPark provides the purchasing infrastructure for the Windows parking management software.

- Three software plans: Eco, Pro, and Sazmani (Enterprise).
- Lifetime software licenses.
- Configurable plan pricing and device limits.
- Six-month and twelve-month technical support packages.
- Purchase-type detection for new purchases, renewals, upgrades, downgrades, and support extensions.
- Shopping cart and checkout management.
- SEP (SAMAN) payment gateway integration.
- Server-side payment verification.
- Duplicate-payment processing protection.
- Transaction-safe order settlement.
- Automatic expiration of abandoned pending orders.
- Immediate settlement of zero-amount orders without a payment gateway redirect.

### Software License Management

- License issuance and subscription association.
- License validation through the Windows client API.
- Machine-fingerprint-based device registration.
- Device activation and deactivation.
- Device limits based on the purchased plan.
- Server-side enforcement of licensing rules.
- License and device administration.

### Technical Support Management

- Initial support period included with eligible license purchases.
- Paid support extensions.
- Six-month and annual support packages.
- Support-period tracking.
- Customer access to support status and remaining support time.

### Customer Dashboard

Customers can:

- View their software plan and license details.
- Access their license key.
- Manage registered devices.
- Review orders and invoices.
- View purchase history.
- Check technical support validity.
- Purchase available support extensions.
- Manage profile information and email verification.

### Administration Panel

Administrators can:

- View system and commerce statistics.
- Manage users and account roles.
- Manage software plans and pricing.
- Manage licenses, subscriptions, and registered devices.
- Manage support packages and support periods.
- Manage orders, invoices, and payments.
- Review revenue analytics and a twelve-month revenue chart.
- Monitor server memory, disk usage, database latency, and traffic statistics.
- Manage blog categories, posts, and SEO fields.
- Create and restore database backups.

### Website and Localization

- Persian and English interfaces.
- Automatic right-to-left (RTL) and left-to-right (LTR) layout.
- Jalali calendar formatting.
- Blog and content management system.
- Rich-text content editing.
- SEO metadata and canonical URLs.
- Custom bilingual error pages for HTTP status codes 401–503.
- Page-visit analytics.

---

## License and Support Model

AvaPark separates the validity of the software license from the duration of technical support.

| Component | Description |
|---|---|
| Software license | Lifetime validity under the applicable licensing terms |
| Initial technical support | Six months included with the license |
| Support extensions | Available through paid support packages |
| Device activation | Restricted by the device limit of the purchased plan |
| License validation | Performed through the server-side licensing API |

A license remains lifetime-valid under its applicable terms even when its included support period expires. Customers may purchase eligible support extensions to continue receiving support services.

Lifetime validity does not remove device limits or other applicable license conditions.

---

## Software Plans

AvaPark currently defines three software plan levels.

| Plan | Slug | Level | Device Limit |
|---|---|---:|---:|
| Eco | `eco` | 1 | 2 |
| Pro | `pro` | 2 | 4 |
| Sazmani (Enterprise) | `sazmani` | 3 | 8 |

Plan prices are managed through the administration panel.

### Technical Support Packages

The documented support-package configuration includes:

| Package | Duration | Price |
|---|---|---:|
| Six-month support | 6 months | 1,500,000 Toman |
| Annual support | 12 months | 2,600,000 Toman |

These values should be verified against the active application configuration before being used as current commercial prices.

---

## Architecture

AvaPark is built with Laravel and separates HTTP handling from business logic through dedicated service classes.

Controllers handle incoming requests, while the service layer manages checkout, orders, payment verification, subscriptions, licensing, device activation, and API response signing.

### Application Structure

```text
app/
├── Console/
│   └── Commands/
│       └── ExpirePendingOrdersCommand.php
│
├── Http/
│   ├── Controllers/
│   │   ├── Admin/
│   │   │   ├── Dashboard
│   │   │   ├── Users
│   │   │   ├── Subscriptions
│   │   │   ├── Supports
│   │   │   ├── Store
│   │   │   ├── Licenses
│   │   │   ├── Invoices
│   │   │   ├── Database
│   │   │   ├── Monitoring
│   │   │   ├── Categories
│   │   │   └── Posts
│   │   ├── Api/
│   │   │   └── LicenseController.php
│   │   ├── Auth/
│   │   ├── User/
│   │   ├── BlogController.php
│   │   ├── LocaleController.php
│   │   ├── PageController.php
│   │   ├── ProfileController.php
│   │   └── ShopController.php
│   ├── Middleware/
│   └── Requests/
│
├── Models/
│   ├── User
│   ├── Plan
│   ├── Subscription
│   ├── Support*
│   ├── Cart
│   ├── Order
│   ├── OrderItem
│   ├── Payment
│   ├── License
│   ├── LicenseDevice
│   ├── Post
│   └── Category
│
├── Notifications/
│   └── CustomVerifyEmail.php
│
├── Services/
│   ├── CartService.php
│   ├── CheckoutService.php
│   ├── OrderService.php
│   ├── PaymentService.php
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

### Service Layer

| Service | Responsibility |
|---|---|
| `CartService` | Pending-cart lifecycle |
| `CheckoutService` | Purchase-type detection and checkout settlement |
| `OrderService` | Cart-to-order conversion |
| `PaymentService` | Payment gateway initiation and verification |
| `SubscriptionService` | Lifetime subscriptions and support extensions |
| `LicenseService` | License issuance |
| `LicenseValidatorService` | License validation and client API logic |
| `DeviceService` | Device fingerprints, activations, and seat limits |
| `DatabaseBackupService` | SQL database export and import |
| `SignatureService` | Digital signing of API responses |

---

## Data Model

The main data entities include:

| Table | Purpose |
|---|---|
| `users` | User accounts, roles, and email verification |
| `plans` | Software plans, prices, discounts, and device limits |
| `subscriptions` | Lifetime subscriptions and their status |
| `subscription_supports` | Support periods and expiration timestamps |
| `support_packages` | Purchasable support durations |
| `carts` | Pending purchase operations |
| `orders` | Orders, amounts, currency, and payment status |
| `order_items` | Order line items |
| `payments` | Payment transactions and gateway references |
| `licenses` | Issued software license keys |
| `license_devices` | Devices activated against licenses |
| `demo_license_devices` | Device-specific trial registrations |
| `categories` | Blog categories |
| `posts` | Blog posts |
| `page_visits` | Page-visit statistics |

---

## Purchase and Payment Flow

The checkout workflow processes orders, verifies payments, and settles purchases.

```text
Select Software Plan or Support Package
                  |
                  v
             Create Cart
                  |
                  v
             Create Order
                  |
                  v
          Initiate SEP Payment
                  |
                  v
            Payment Callback
                  |
                  v
        Server-side Verification
                  |
                  v
           Confirm Payment
                  |
                  v
        Settle Checkout Transaction
                  |
          +-------+--------+
          |       |        |
          v       v        v
       Purchase Upgrade  Downgrade
          |       |        |
          v       v        v
       License  Plan     Plan Change
       Issuance Change
                  |
                  v
        Support Extension (if applicable)
```

### Transaction Integrity

Checkout settlement uses database transactions and pessimistic row locking to maintain consistency during state changes.

Payment callbacks are processed idempotently so an already-settled order is not settled twice. Zero-amount orders can be finalized without a gateway redirect.

The checkout service distinguishes between new purchases, same-plan operations, plan upgrades, plan downgrades, and support extensions.

---

## Windows Client API

The Windows parking management application communicates with AvaPark through a REST API for license validation, device activation, and support information.

### Available Endpoints

| Method | Endpoint | Purpose |
|---|---|---|
| `POST` | `/api/license/validate` | Validate a license and activate the calling device |
| `POST` | `/api/license/support-status` | Retrieve the support period and remaining time |
| `POST` | `/api/license/deactivate-device` | Deactivate a registered device |
| `POST` | `/api/license/info` | Retrieve license, plan, device, and support details |

### API Security

The licensing API uses RSA/SHA-256 digital signatures.

- API responses are signed on the server.
- The Windows client verifies response authenticity and integrity.
- Error responses use the signed response format.
- Device activation, deactivation, seat limits, and trial eligibility are enforced server-side.
- A per-device demo trial allows prospective customers to evaluate the software before purchasing.

Detailed request and response contracts should be maintained alongside the API implementation and its internal documentation.

---

## API Response Signing

AvaPark uses asymmetric cryptography to sign licensing API responses.

The server signs responses with its private key, and the Windows application verifies signatures using the corresponding public key.

This mechanism helps the client detect response tampering and verify that a response was signed by the holder of the corresponding private key.

### Generate a Key Pair

The following commands illustrate RSA key-pair generation with OpenSSL:

```bash
openssl genrsa -out storage/app/license_private.pem 2048

openssl rsa \
    -in storage/app/license_private.pem \
    -pubout \
    -out license_public.pem
```

The public key can be distributed with the Windows application for response verification.

**Never commit the private signing key to Git or include it in the distributed desktop application.**

---

## Technology Stack

| Category | Technology |
|---|---|
| Backend framework | Laravel 11 |
| Programming language | PHP 8.2+ |
| Authentication | Laravel Breeze |
| API authentication | Laravel Sanctum |
| API response security | RSA/SHA-256 digital signatures |
| Frontend | Blade |
| JavaScript | Alpine.js 3 |
| CSS framework | Tailwind CSS 3 |
| Build tool | Vite 6 |
| Rich-text editor | TinyMCE 6 |
| Payment integration | `shetabit/payment` — SEP / SAMAN IPG |
| Calendar | `morilog/jalali` |
| Database | MySQL 8+ / MariaDB 10.4+ |
| Local testing database | SQLite |
| Testing | PHPUnit 11 |
| Mocking | Mockery |
| Code formatting | Laravel Pint |

---

## Requirements

Before installing AvaPark, make sure the following tools and services are available:

- PHP 8.2 or later with the OpenSSL extension.
- Composer.
- Node.js 20 or later.
- npm.
- MySQL 8+, MariaDB 10.4+, or SQLite for supported local testing scenarios.

A valid SEP merchant configuration is required for real payment processing.

---

## Installation

### 1. Clone the Repository

```bash
git clone https://github.com/AdnanMahmoudiDev/ProPark.git

cd ProPark
```

### 2. Install Dependencies

```bash
composer install
npm install
```

### 3. Configure the Environment

Create the environment file:

```bash
cp .env.example .env
```

On Windows PowerShell, you can use:

```powershell
Copy-Item .env.example .env
```

### 4. Generate the Application Key

```bash
php artisan key:generate
```

### 5. Configure the Database

Update the database settings in `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=avapark
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

Create the database before running migrations.

### 6. Run Migrations and Seeders

```bash
php artisan migrate --seed
```

### 7. Create the Storage Link

```bash
php artisan storage:link
```

### 8. Start the Application

In one terminal, start the frontend development server:

```bash
npm run dev
```

In another terminal, start Laravel:

```bash
php artisan serve
```

The application will normally be available at:

```text
http://127.0.0.1:8000
```

For production frontend assets, run:

```bash
npm run build
```

---

## Configuration

### Payment Gateway

SEP (SAMAN) is the default payment gateway. Configure the required merchant credentials and callback URL in `.env`:

```env
PAYMENT_DEFAULT=sep
SEP_TERMINAL_ID=your-terminal-id
SEP_CALLBACK_URL=https://your-domain.com/payment/callback
SEP_DESCRIPTION="AvaPark order payment"
SEP_CURRENCY=T
```

Replace the example values with the actual credentials and configuration supplied for your payment-gateway account.

Additional gateways, such as Zarinpal, may be configurable through `config/payment.php`, depending on the application's implementation.

Never commit production credentials or other secrets to version control.

### Scheduler

The application uses Laravel's scheduler to expire pending orders.

For local development, run:

```bash
php artisan schedule:work
```

Alternatively, configure the standard cron entry in production:

```cron
* * * * * cd /path-to-project && php artisan schedule:run >> /dev/null 2>&1
```

Replace `/path-to-project` with the absolute path to the application.

---

## Seeded Data

### Software Plans

The default seed data defines the following plans:

| Plan | Slug | Level | Device Limit |
|---|---|---:|---:|
| Eco | `eco` | 1 | 2 |
| Pro | `pro` | 2 | 4 |
| Sazmani | `sazmani` | 3 | 8 |

Seeded plans start without configured prices. Administrators can set prices through the administration panel.

### Support Packages

The documented support-package configuration includes:

| Package | Duration | Price (Toman) |
|---|---:|---:|
| Six-month support | 6 months | 1,500,000 |
| Annual support | 12 months | 2,600,000 |

Verify these values against the active configuration before publishing them as current prices.

---

## Administration Access

No administrator account is seeded by default.

After registering a regular account, open Laravel Tinker:

```bash
php artisan tinker
```

Then promote the account:

```php
\App\Models\User::where('email', 'you@example.com')
    ->update(['role' => 'admin']);
```

Replace `you@example.com` with the registered account's email address.

The administration panel is available under `/admin` and is restricted to administrator accounts.

Use this procedure carefully and only for accounts you control.

---

## Development and Testing

### Run Tests

```bash
php artisan test
```

### Format PHP Code

```bash
./vendor/bin/pint
```

### Run the Development Environment

```bash
composer dev
```

The Composer development script runs the processes configured in `composer.json`, which may include the application server, queue worker, logs, and Vite.

---

## Security Considerations

AvaPark handles payments, software licenses, and device authorization. These operations require careful security controls.

Recommended practices include:

- Keep production credentials and private signing keys out of version control.
- Enforce authorization on administrative actions.
- Validate API requests on the server.
- Enforce license and device limits server-side.
- Verify payment results on the server instead of trusting browser redirects.
- Prevent duplicate payment settlement.
- Verify API response signatures in the Windows client.
- Use HTTPS in production.
- Keep Laravel and third-party dependencies updated.
- Restrict administrative access to authorized personnel.
- Review database backup and restore permissions carefully.

The actual security of a deployment depends on the implementation, configuration, and operational practices in use.

---

## Roadmap

Potential future improvements include:

- [ ] Email and SMS notifications for support expiration and relevant account events.
- [ ] Discount codes and coupons.
- [ ] Queue-backed processing for backups and notifications.
- [ ] Fine-grained role and permission management.
- [ ] OpenAPI documentation for the Windows client API.
- [ ] Two-factor authentication for administrators.
- [ ] Expanded payment webhook support.

These items represent planned improvements and should not be interpreted as currently implemented features.

---

## License

AvaPark is open-source software licensed under the [MIT License](LICENSE).

You are free to use, copy, modify, merge, publish, distribute, sublicense, and sell copies of the software, subject to the terms and conditions of the MIT License.

The MIT License applies to the project's source code. Commercial licenses sold to customers for the AvaPark Windows application, as well as paid technical support services, are governed by their respective terms and are separate from this source-code license.

Third-party dependencies remain subject to their respective licenses.
---

**AvaPark — The online sales and licensing platform for intelligent urban parking management software.**
