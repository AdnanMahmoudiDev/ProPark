# AvaPark

**A Laravel-based subscription, software licensing, and parking management platform.**

<p align="center">
  <img src="public/images/ProPark.png" width="220" alt="AvaPark Logo">
</p>

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-11.x-FF2D20?logo=laravel&logoColor=white" alt="Laravel 11">
  <img src="https://img.shields.io/badge/PHP-%E2%89%A58.2-777BB4?logo=php&logoColor=white" alt="PHP 8.2+">
  <img src="https://img.shields.io/badge/TailwindCSS-3.x-38B2AC?logo=tailwindcss&logoColor=white" alt="Tailwind CSS">
  <img src="https://img.shields.io/badge/Vite-6.x-646CFF?logo=vite&logoColor=white" alt="Vite">
  <a href="https://www.sep.ir">
    <img src="https://img.shields.io/badge/Payment-SEP%20IPG-28A745" alt="SEP Payment Gateway">
  </a>
</p>

<p align="center">
  <strong>Production:</strong> <a href="https://www.avapark.ir">www.avapark.ir</a>
</p>

---

## Table of Contents

- [Overview](#overview)
- [Project Highlights](#project-highlights)
- [Main Features](#main-features)
- [Architecture](#architecture)
- [Data Model](#data-model)
- [Purchase Flow](#purchase-flow)
- [Client REST API](#client-rest-api)
- [API Response Signing](#api-response-signing)
- [Tech Stack](#tech-stack)
- [Installation](#installation)
- [Creating an Administrator](#creating-an-administrator)
- [Seed Data](#seed-data)
- [Testing and Development](#testing-and-development)
- [Roadmap](#roadmap)
- [License](#license)

---

## Overview

**AvaPark** is a Laravel-based web platform that manages subscriptions, software licenses, payments, support services, and the infrastructure surrounding the AvaPark Windows parking management application.

The platform connects three main areas:

- **Customer experience:** A bilingual storefront, user dashboard, blog, and account management.
- **Software licensing:** A secure REST API for license validation, device activation, and support-status checks.
- **Business operations:** An administration panel for managing customers, subscriptions, orders, payments, invoices, content, and system monitoring.

Unlike a conventional subscription platform, AvaPark uses a lifetime licensing model: purchasing a plan grants a license that does not expire. Technical support is managed separately through time-limited support periods.

The platform brings together the complete commercial workflow, from selecting a plan to payment verification, license issuance, device registration, and support management.

**Live deployment:** [https://www.avapark.ir](https://www.avapark.ir)

### Commercial Model

AvaPark separates software ownership rights under its commercial licensing model from the duration of technical support.

| Component | Description |
| --- | --- |
| Software license | Lifetime validity |
| Initial support | Six months of support included |
| Support extension | Available through purchasable support packages |
| Device activation | Subject to the device limit of the selected plan |
| Payment processing | SEP (SAMAN) Internet Payment Gateway by default |

The support period can expire without the lifetime software license itself expiring.

---

## Project Highlights

### Lifetime Software Licensing

AvaPark provides three lifetime plans:

- **Eco**
- **Pro**
- **Sazmani (Enterprise)**

Each plan has its own device limit. Once purchased, the plan does not expire; support duration is managed independently.

### Subscription and Support Management

The platform handles purchases, plan changes, and support extensions through a unified checkout workflow.

Its business logic distinguishes between purchasing a plan, upgrading or downgrading an existing plan, and extending a support period.

### Payment Processing

The platform integrates with the SEP (SAMAN) payment gateway.

Payment processing includes server-side verification, callback handling, and protection against settling the same order more than once. Orders with a zero payable amount can be finalized without redirecting the customer to a payment gateway.

### Secure Software Licensing

License activation is tied to registered devices identified by machine fingerprints.

The licensing API uses RSA/SHA-256 digital signatures so that the Windows client can verify the authenticity and integrity of server responses.

### Administration and Monitoring

The administration panel combines commerce management, customer administration, invoice and revenue reporting, content management, database backup and restore, and server monitoring.

---

## Main Features

### Store and Checkout

- Three lifetime plans with configurable prices and device limits.
- Purchasable support packages for six months and one year.
- Automatic detection of purchase types.
- Purchase, upgrade, downgrade, and support-extension workflows.
- Automatic discount handling for supported support-package purchases.
- Transaction-safe order settlement.
- Database transactions and row locking for consistency.
- Server-side payment verification.
- Idempotent payment callback handling.
- Automatic expiration of abandoned pending orders through a scheduled command.
- Immediate settlement of zero-amount orders without a gateway redirect.

The payment gateway is configurable, with SEP as the default driver.

### User Dashboard

Users can:

- View their plan and lifetime subscription details.
- Check their support period and remaining support time.
- View their software license key.
- Manage registered devices.
- Review purchase history and invoice details.
- Add plans or support packages to their cart.
- Cancel pending cart operations and proceed to checkout.
- Manage profile information.
- Complete email verification.

### Administration Panel

Administrators have access to the following tools:

- System dashboard and commerce statistics.
- User management and role assignment.
- Subscription and license management.
- Support-package management.
- Store pricing management and bulk price updates.
- Order and invoice management.
- Revenue analytics and a 12-month revenue chart.
- Server monitoring, including memory, disk, database latency, and traffic statistics.
- Blog category and post management.
- Rich-text content editing and SEO fields.
- Database backup and restore utilities.

### Blog and Content Management

The platform includes a built-in content management system with category and post management, a rich-text editor, and SEO-related fields.

### Localization and Interface

- Persian and English localization.
- Automatic right-to-left (RTL) and left-to-right (LTR) layout support.
- Jalali (Solar Hijri) date formatting.
- Custom bilingual error pages for HTTP status codes 401–503.
- Page-visit analytics integrated with the monitoring dashboard.

---

## Architecture

AvaPark separates business logic from HTTP controllers through a dedicated service layer.

Controllers handle incoming requests, while service classes manage operations such as checkout, order settlement, payment verification, subscription management, device activation, and API response signing.

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
│   │   │
│   │   ├── Api/
│   │   │   └── LicenseController.php
│   │   ├── Auth/
│   │   ├── User/
│   │   ├── BlogController.php
│   │   ├── LocaleController.php
│   │   ├── PageController.php
│   │   ├── ProfileController.php
│   │   └── ShopController.php
│   │
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

The service layer is responsible for the main business operations:

| Service | Responsibility |
| --- | --- |
| `CartService` | Pending-cart lifecycle |
| `CheckoutService` | Purchase-type detection and checkout settlement |
| `OrderService` | Converting carts into orders |
| `PaymentService` | Payment initiation and verification |
| `SubscriptionService` | Lifetime subscriptions and support renewal |
| `LicenseService` | License issuance |
| `LicenseValidatorService` | License validation and client API logic |
| `DeviceService` | Device fingerprints, activation, and seat limits |
| `DatabaseBackupService` | SQL database export and import |
| `SignatureService` | Digital signing of API responses |

---

## Data Model

The following tables represent the main data entities described by the application's architecture.

| Table | Purpose |
| --- | --- |
| `users` | User accounts, roles, and email verification |
| `plans` | Plan definitions, prices, discounts, and device limits |
| `subscriptions` | Lifetime subscriptions and their status |
| `subscription_supports` | Support periods with start and expiration timestamps |
| `support_packages` | Purchasable support durations |
| `carts` | Pending purchase operations |
| `orders` | Orders, amounts, currency, and payment status |
| `order_items` | Order line items for plans and support packages |
| `payments` | Payment gateway transactions and references |
| `licenses` | Generated software license keys |
| `license_devices` | Devices activated against licenses |
| `demo_license_devices` | Device-specific trial registrations |
| `categories` | Blog categories |
| `posts` | Blog posts |
| `page_visits` | Page-visit statistics |

---

## Purchase Flow

AvaPark processes purchases through a cart, order, payment-verification, and settlement workflow.

```text
Select a Plan or Support Package
              |
              v
         Create Cart
              |
              v
         Create Order
              |
              v
      Initiate Payment
         (SEP IPG)
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
      Settle Checkout
    (Database Transaction)
              |
       +------+------+
       |             |
       v             v
  Plan Purchase   Existing Plan
       |             |
       v        +----+----+---------+
  Issue License |         |         |
                v         v         v
             Upgrade   Downgrade  Support
                                  Extension
```

### Checkout Integrity

The checkout workflow uses database transactions and pessimistic locking to maintain consistency during settlement.

Payment callbacks are processed idempotently so that an already-settled order is not settled a second time. Zero-amount orders bypass the payment gateway and are finalized directly.

Purchase handling distinguishes between new purchases, same-plan operations, plan upgrades, plan downgrades, and support extensions.

---

## Client REST API

The Windows desktop application communicates with AvaPark through a REST API responsible for license validation, device activation, and support information.

### Available Endpoints

| Method | Endpoint | Description |
| --- | --- | --- |
| `POST` | `/api/license/validate` | Validate a license and activate the calling device |
| `POST` | `/api/license/support-status` | Retrieve the current support period and remaining time |
| `POST` | `/api/license/deactivate-device` | Deactivate a registered device and release its seat |
| `POST` | `/api/license/info` | Retrieve license, plan, device, and support information |

### API Security

The licensing API uses RSA/SHA-256 digital signatures.

- API responses are digitally signed by the server.
- The Windows client can verify response authenticity and integrity using the corresponding public key.
- Error responses use the signed response format.
- Device activation, deactivation, seat limits, and trial eligibility are enforced server-side.
- A per-device demo trial allows prospective customers to evaluate the software before purchasing.

Detailed request and response contracts are maintained in the project's internal API documentation.

---

## API Response Signing

AvaPark uses asymmetric cryptography to sign licensing API responses.

The server signs responses with its private key, while the Windows client uses the corresponding public key to verify signatures.

This provides a mechanism for detecting response tampering and verifying that a response was signed by the holder of the corresponding private key.

The private signing key must remain on the server and must never be committed to the repository.

### Generate a Key Pair

The following commands illustrate RSA key-pair generation using OpenSSL:

```bash
openssl genrsa -out storage/app/license_private.pem 2048

openssl rsa \
    -in storage/app/license_private.pem \
    -pubout \
    -out license_public.pem
```

The public key can be distributed with the Windows client for response verification. Keep the private key secure and configure its storage according to the application's deployment requirements.

---

## Tech Stack

| Category | Technology |
| --- | --- |
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

## Installation

### Requirements

Make sure the following tools and services are available:

- PHP 8.2 or later with the OpenSSL extension.
- Composer.
- Node.js 20 or later.
- npm.
- MySQL 8+, MariaDB 10.4+, or SQLite for supported local testing scenarios.

### 1. Clone the Repository

```bash
git clone https://github.com/AdnanMahmoudiDev/ProPark.git

cd ProPark
```

### 2. Install Dependencies

Install PHP dependencies:

```bash
composer install
```

Install frontend dependencies:

```bash
npm install
```

### 3. Configure the Environment

Create the environment file:

```bash
cp .env.example .env
```

Generate the Laravel application key:

```bash
php artisan key:generate
```

### 4. Configure the Database

Update the database settings in `.env` to match your local environment:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=avapark
DB_USERNAME=root
DB_PASSWORD=
```

Create the database before running migrations.

### 5. Run Migrations and Seeders

```bash
php artisan migrate --seed
```

Create the public storage link:

```bash
php artisan storage:link
```

### 6. Configure the Payment Gateway

SEP (SAMAN) is the default payment gateway. Configure the appropriate merchant credentials and callback URL in `.env`:

```env
PAYMENT_DEFAULT=sep
SEP_TERMINAL_ID=your-terminal-id
SEP_CALLBACK_URL=https://your-domain.com/payment/callback
SEP_DESCRIPTION="AvaPark order payment"
SEP_CURRENCY=T
```

Replace the example values with the actual credentials and settings supplied for your payment-gateway account.

Additional gateway drivers, such as Zarinpal, may be configured through `config/payment.php`, subject to the application's implementation and gateway credentials.

**Security:** Never commit production credentials, private keys, or other secrets to Git.

### 7. Configure the Scheduler

The application uses Laravel's scheduler to expire pending orders.

For local development, run:

```bash
php artisan schedule:work
```

Alternatively, configure the standard scheduler cron entry in production:

```cron
* * * * * cd /path-to-project && php artisan schedule:run >> /dev/null 2>&1
```

Replace `/path-to-project` with the absolute path to the application.

### 8. Start the Application

Start the frontend development server:

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

## Creating an Administrator

The project does not seed an administrator account by default.

First, register a normal account. Then open Laravel Tinker:

```bash
php artisan tinker
```

Promote the account by updating its role:

```php
\App\Models\User::where('email', 'you@example.com')
    ->update(['role' => 'admin']);
```

Replace `you@example.com` with the registered account's email address.

The administration panel is available under `/admin` and is restricted to administrator accounts.

---

## Seed Data

### Subscription Plans

The seed data defines three plans with different device limits.

| Plan | Slug | Level | Device Limit |
| --- | --- | ---: | ---: |
| Eco | `eco` | 1 | 2 |
| Pro | `pro` | 2 | 4 |
| Sazmani | `sazmani` | 3 | 8 |

Plan prices are managed through the administration panel. Seeded plans start without configured prices.

### Support Packages

The documented support-package configuration includes:

| Package | Duration | Price |
| --- | --- | ---: |
| Six-month support | 6 months | 1,500,000 Toman |
| Annual support | 12 months | 2,600,000 Toman |

These are the values described by the project's current README. Verify them against the active application configuration before using them as published commercial prices.

---

## Testing and Development

### Run Tests

```bash
php artisan test
```

### Format PHP Code

```bash
./vendor/bin/pint
```

### Run the Development Environment

The project includes a Composer development script:

```bash
composer dev
```

This script runs the configured development processes concurrently, including the application server, queue processing, logs, and Vite.

---

## Roadmap

Planned improvements include:

- [ ] Email and SMS notifications for relevant renewal and expiration events.
- [ ] Discount codes and coupon support.
- [ ] Queue-backed processing for resource-intensive tasks, such as backups and notifications.
- [ ] Fine-grained role and permission management.
- [ ] OpenAPI specification for the client API.
- [ ] Two-factor authentication for administrators.
- [ ] Payment webhooks for downstream integrations.

---

## License

This repository is released under the **MIT License**, as indicated by the project's `composer.json`.

See the repository's license files and notices for the applicable terms.

**Important:** The repository's software license and AvaPark's commercial terms for lifetime software licenses and paid support are separate matters. The MIT notice describes the repository's stated source-code licensing; it does not, by itself, document the complete commercial agreement offered to AvaPark customers.
