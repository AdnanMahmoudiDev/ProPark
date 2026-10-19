# AvaPark (آواپارک)
<div align="center">

**A Laravel-based subscription, software licensing, and payment platform for the AvaPark Windows parking-management software.**
<img src="public/images/ProPark.png" width="200" alt="AvaPark Logo">

<p align="center">
  <img src="public/images/ProPark.png" width="220" alt="AvaPark Logo">
</p>
# AvaPark

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-11.x-FF2D20?logo=laravel&logoColor=white" alt="Laravel 11">
  <img src="https://img.shields.io/badge/PHP-%E2%89%A58.2-777BB4?logo=php&logoColor=white" alt="PHP 8.2+">
  <img src="https://img.shields.io/badge/TailwindCSS-3.x-38B2AC?logo=tailwindcss&logoColor=white" alt="Tailwind CSS">
  <img src="https://img.shields.io/badge/Vite-6.x-646CFF?logo=vite&logoColor=white" alt="Vite">
  <img src="https://img.shields.io/badge/Invoices-SEP%20IPG-28A745" alt="SEP Payment Gateway">
</p>
**Subscription, licensing, and commerce platform for the AvaPark parking-management software.**

---
[![Laravel](https://img.shields.io/badge/Laravel-11.x-FF2D20?logo=laravel&logoColor=white)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-%E2%89%A58.2-777BB4?logo=php&logoColor=white)](https://www.php.net)
[![Tailwind CSS](https://img.shields.io/badge/TailwindCSS-3.x-38B2AC?logo=tailwindcss&logoColor=white)](https://tailwindcss.com)
[![Vite](https://img.shields.io/badge/Vite-6.x-646CFF?logo=vite&logoColor=white)](https://vite.dev)
[![Payment](https://img.shields.io/badge/Payment-SEP%20IPG-28A745)](https://www.sep.ir)

## Overview
🌐 **Production:** [https://www.avapark.ir](https://www.avapark.ir)

**AvaPark** is a full-featured Laravel platform that manages the commercial side of a Windows-based parking management application: subscription plans, software licenses, registered devices, support packages, invoicing, and real payment-gateway transactions.
</div>

A production deployment operates under the **AvaPark** brand:
---

### 🌐 Live: **https://www.avapark.ir**
## Table of Contents

The platform provides a complete business workflow:
- [Overview](#overview)
- [Features](#features)
- [Architecture](#architecture)
- [Data Model](#data-model)
- [Purchase Flow](#purchase-flow)
- [Client API](#client-api)
- [Tech Stack](#tech-stack)
- [Getting Started](#getting-started)
- [Seeded Data](#seeded-data)
- [Admin Access](#admin-access)
- [Development](#development)
- [Roadmap](#roadmap)
- [License](#license)

* Real payment through the **SEP (SAMAN) IPG** gateway with server-side verification
* Lifetime software licenses with plan-based device limits
* Purchasable **support packages** (6-month / 1-year) attached to licenses
* Machine-fingerprint device activation and seat management
* Demo **trial mode** (15-day, per-device) for evaluation before purchase
* Full user panel and administration panel
* RSA/SHA-256 **signed REST API** for the desktop client
* Order/invoice management with financial analytics
* Blog/CMS, database backup & restore, server monitoring
* Persian (RTL) and English (LTR) localization

---

## Project Highlights
## Overview

This is not a CRUD demo. The project implements real-world commerce and licensing architecture:
AvaPark is a Laravel application that operates the commercial layer of the AvaPark Windows parking-management software. It covers the full lifecycle of a sale — plan selection, checkout through a real payment gateway, lifetime license issuance, device-bound activation, paid support periods, invoicing, and financial reporting.

### Lifetime Subscriptions
The platform serves three audiences:

Subscriptions **never expire**. What expires is the *support period*:
| Audience | Surface |
| -------- | ------- |
| Prospective and existing customers | Bilingual (RTL/LTR) storefront, blog, and user dashboard |
| The desktop client | Signed REST API for license validation and device activation |
| Operators | Full administration panel with commerce, content, and system tooling |

* Each subscription is tied to a plan (`eco`, `pro`, `sazmani`) with a lifetime license
* The **first purchase** automatically grants **6 months of free support**
* Support can be extended by purchasing support packages (6 or 12 months)
* Renewal adds months on top of the current expiry (or from "now" if already expired)
* Support status (active / expired / remaining days) is exposed through the client API
Core commercial principles:

### Orders, Payments, and Invoices
- **Lifetime subscriptions.** A purchased plan never expires; what expires is the *support period*, which is granted free for the first six months and extendable through purchasable support packages.
- **Verified payments.** All transactions run through the SEP (SAMAN) payment gateway with server-side verification and idempotent callback handling.
- **Device-bound licensing.** Licenses activate on registered devices identified by a machine fingerprint, within per-plan seat limits, and are enforced entirely server-side.

The checkout pipeline is split into three persistence layers:

```text
Cart (intent)  →  Order (invoice)  →  Payment (gateway transaction)
```

* `carts` — a single pending intent per user (plan purchase, renewal, upgrade, downgrade, or support package)
* `orders` — a final invoice with a unique order number (`ORD-YYYYMMDD-XXXXX`), subtotal, discount, and payable amount
* `order_items` — polymorphic items (`Plan` or `SupportPackage`) with unit price, discount, final amount, and metadata
* `payments` — one row per gateway attempt, storing the gateway authority, reference ID, request/response payloads, and failure messages

Safety properties:

* All state changes run inside **database transactions** with `lockForUpdate()`
* Free orders (100% discount) are finalized immediately without hitting the gateway
* Abandoned pending orders are **auto-expired** by a scheduled command (`orders:expire-pending`, every 10 minutes, 30-minute timeout)
* The payment callback is idempotent: already-paid orders are never double-processed

### Real Payment Gateway (SEP IPG)

Payments run through [shetabit/payment](https://github.com/shetabit/payment) with the **SEP (SAMAN)** driver as default:

* Token generation, redirect to the bank page, and server-side **verification**
* Callback accepts both `GET` and `POST` (Shaparak returns POST) and is exempt from CSRF
* Session recovery: if the shopper session is lost on callback, the order owner is re-authenticated securely
* SEP `State != OK` responses are mapped to `cancelled` / `failed` correctly
* Every attempt is persisted with full request/response payloads for auditing

### Software Licensing

License keys are generated in the format:

```text
AVPK-XXXX-XXXX-XXXX-XXXX
```

* Unique key generation with database collision checks
* One license per subscription (unique constraint)
* Device registration by **machine fingerprint** with automatic seat allocation
* Per-plan device limits (`eco` = 2, `pro` = 4, `sazmani` = 8 by default)
* On downgrade, excess devices are automatically removed to respect the new limit
* Device activation / deactivation both from the user panel and the client API

### Demo Trial Mode

A built-in trial key (`AVAPARK-DEMO-TRIAL`, configurable via `AVAPARK_DEMO_LICENSE_KEY`):

* Grants **15 days** of access per machine fingerprint
* Trial records are permanent — a device cannot drop its trial to restart it
* Trial devices cannot be deactivated through the API
* Expired trials return a signed "purchase required" response

### API Response Signing

Every API response `data` payload is signed with **RSA/SHA-256** using a server-side private key (`storage/app/license_private.pem`). The desktop client verifies the signature with the matching public key, guaranteeing authenticity and integrity. Keys are recursively sorted before JSON encoding so signatures are deterministic.

### Admin Financial Analytics

The admin panel includes a full invoicing section:

* Order list with search (order number, ID, customer name/email/phone) and status filters
* Quick stats: total revenue, paid/pending/failed/expired/canceled counters
* Analytics page: revenue for month / 6 months / year, average order value, top-selling packages, 12-month revenue chart with Persian month labels
* Printable invoice detail view with items and payment history

---

## Main Features
## Features

### Store & Checkout

* Three plans: **Eco**, **Pro**, **Sazmani (Enterprise)** — priced directly on the plan (one-time, lifetime)
* Support packages: **6-month** and **1-year** with discounts
* Discounted and original prices with automatic discount calculation
* Automatic transaction-type detection: `purchase`, `renew`, `upgrade`, `downgrade`, or `support`
* Upgrade/downgrade by plan level; downgrade enforces the new device limit
* Transaction-safe checkout
- Three lifetime plans — **Eco**, **Pro**, **Sazmani (Enterprise)** — with per-plan device limits
- Purchasable support packages (6 months / 1 year) with automatic discount handling
- Automatic purchase-type detection: new purchase, renewal, upgrade, downgrade, or support extension
- Transaction-safe checkout; zero-amount orders are settled without a gateway redirect
- Abandoned orders are expired automatically by a scheduled command

### User Dashboard

* Active subscription and plan overview
* License key with copy-to-clipboard
* Registered devices list with deactivation
* Support status and remaining days
* Purchase history / invoices with detail view
* Cart management (add plan or support package, cancel, checkout)
* Profile: name, email verification, phone number, password change, account deletion
- Subscription, plan, and support-period overview
- License key display and registered-device management
- Purchase history with invoice details
- Cart management (add plan or support package, cancel, checkout)
- Profile management with email verification

Authentication is **Laravel Breeze** with a custom email-verification notification (`CustomVerifyEmail` + branded HTML template).

### Administration Panel

* Dashboard with system statistics
* User management and role switching (`user` / `admin`)
* Subscription management: change status, change plan, manual renew, delete
* Support package management: change status, renew, delete
* Store pricing management with **bulk price updates** (plans and support packages)
* Manual license creation for any user
* Order/invoice management with financial analytics
* Database **backup (SQL export) and restore (SQL import)** from the browser
* Server monitoring: RAM, disk, DB latency, response time, page-view statistics (6-month chart)
* Blog: categories and posts with TinyMCE editor and inline image upload
- Dashboard with system and commerce statistics
- User management with role assignment
- Subscription, support-package, license, and store-pricing management (including bulk price updates)
- Order and invoicing center with revenue analytics and a 12-month revenue chart
- Server monitoring: memory, disk, database latency, and traffic statistics
- Blog CMS: categories and posts with a rich-text editor and SEO fields
- Database backup and restore utilities

### Blog & Content Management
### Platform

* Categories with post counts, search, and category filtering
* Featured post on page 1, pagination (9 per page)
* View counting with session-based duplicate prevention
* Related posts by category
* SEO fields: meta title, description, canonical URL, OpenGraph image
* Soft deletes and draft/published workflow
- Persian and English localization with automatic RTL/LTR layout
- Jalali (Solar) date formatting throughout the interface
- Custom bilingual error pages (401–503) on a shared layout
- Page-visit analytics feeding the monitoring dashboard

### Localization

* **Persian (fa)** and **English (en)** via JSON dictionaries in `lang/`
* Locale stored in the session, switched via `/locale/{locale}`
* Automatic RTL/LTR layout adaptation
* Jalali (Solar) date formatting via `morilog/jalali` across models and admin views

### Platform Extras

* **Custom error pages** (401, 402, 403, 404, 419, 429, 500, 503) — bilingual glassmorphism design inheriting a shared layout
* **Page-visit tracking** middleware with per-IP/path deduplication (15-minute cache) powering the monitoring dashboard
* **Trust proxies** configured for correct client IPs behind reverse proxies

---

## Architecture

Business logic is separated from controllers through a dedicated service layer:
Controllers stay thin; business rules live in a dedicated service layer.

```text
app/
├── Console/
│   └── Commands/
│       └── ExpirePendingOrdersCommand.php    # orders:expire-pending (scheduled)
│
├── Console/Commands/
│   └── ExpirePendingOrdersCommand.php      # orders:expire-pending (scheduled)
├── Http/
│   ├── Controllers/
│   │   ├── Admin/                            # Dashboard, Users, Subscriptions, Supports,
│   │   │                                     # Store, Licenses, Invoices, Database, Monitoring,
│   │   │                                     # Categories, Posts
│   │   ├── Api/
│   │   │   └── LicenseController.php         # Client licensing endpoints
│   │   ├── Auth/                             # Breeze controllers (customized)
│   │   ├── User/                             # Cart, Payment, Invoices, Devices,
│   │   │                                     # SubscriptionDetails
│   │   ├── BlogController.php                # Public blog
│   │   ├── LocaleController.php              # Language switcher
│   │   ├── PageController.php                # About / Terms / Privacy / Support
│   │   ├── ProfileController.php             # Profile + user dashboard
│   │   └── ShopController.php                # Store page
│   │
│   ├── Middleware/
│   │   ├── AdminMiddleware.php               # role === 'admin' (alias: admin)
│   │   ├── SetLocale.php                     # Session-based locale
│   │   └── TrackPageVisits.php               # Visit logging with cache dedup
│   │
│   │   ├── Admin/                           # Dashboard, Users, Subscriptions,
│   │   │                                    # Supports, Store, Licenses, Invoices,
│   │   │                                    # Database, Monitoring, Categories, Posts
│   │   ├── Api/LicenseController.php        # Desktop-client endpoints
│   │   ├── Auth/                            # Breeze controllers (customized)
│   │   ├── User/                            # Cart, Payment, Invoices, Devices
│   │   ├── BlogController.php               # Public blog
│   │   ├── LocaleController.php             # Language switcher
│   │   ├── PageController.php               # About / Terms / Privacy / Support
│   │   ├── ProfileController.php            # Profile + user dashboard
│   │   └── ShopController.php               # Storefront
│   ├── Middleware/                          # Admin guard, locale, visit tracking
│   └── Requests/
│
├── Models/
│   ├── User                                  # + role, phone_number, MustVerifyEmail
│   ├── Plan                                  # Lifetime plan with price & device limit
│   ├── Subscription                          # Lifetime subscription (status machine)
│   ├── SubscriptionSupport                   # Support period (starts_at / expires_at)
│   ├── SupportPackage                        # Purchasable support duration
│   ├── Cart                                  # Pending purchase intent
│   ├── Order / OrderItem / Payment           # Commerce records
│   ├── License / LicenseDevice               # License + registered devices
│   ├── DemoLicenseDevice                     # 15-day trial registry
│   └── Post / Category                       # Blog CMS
│
├── Notifications/
│   └── CustomVerifyEmail.php
│
├── Models/                                  # User, Plan, Subscription, Support*,
│                                            # Cart, Order, OrderItem, Payment,
│                                            # License, LicenseDevice, Post, Category
├── Notifications/CustomVerifyEmail.php      # Branded verification mail
├── Services/
│   ├── CartService.php                       # Pending cart lifecycle
│   ├── CheckoutService.php                   # Action detection + finalization
│   ├── OrderService.php                      # Cart → Order conversion
│   ├── PaymentService.php                    # Gateway initiate / verify / callback
│   ├── SubscriptionService.php               # Lifetime subs + support renewal
│   ├── LicenseService.php                    # Key generation & license CRUD
│   ├── LicenseValidatorService.php           # API logic (real + demo trial)
│   ├── DeviceService.php                     # Seats, fingerprints, limits
│   ├── DatabaseBackupService.php             # SQL export / import / stats
│   └── License/
│       └── SignatureService.php              # RSA/SHA-256 response signing
│
│   ├── CartService.php                      # Pending-cart lifecycle
│   ├── CheckoutService.php                  # Purchase-type detection + settlement
│   ├── OrderService.php                     # Cart to order conversion
│   ├── PaymentService.php                   # Gateway initiation and verification
│   ├── SubscriptionService.php              # Lifetime subscriptions + support renewal
│   ├── LicenseService.php                   # License issuance
│   ├── LicenseValidatorService.php          # Client API logic (incl. demo trial)
│   ├── DeviceService.php                    # Seats, fingerprints, limits
│   ├── DatabaseBackupService.php            # SQL export / import
│   └── License/SignatureService.php         # Response signing
└── View/Components/
```

### Data Model

| Table                    | Description                                              |
| ------------------------ | -------------------------------------------------------- |
| `users`                  | Users, roles (`user`/`admin`), phone number              |
| `plans`                  | Lifetime plans: level, slug, price, discount, device limit |
| `subscriptions`          | Lifetime subscriptions per user (status machine)         |
| `subscription_supports`  | Support periods (active/expired, Jalali accessor)        |
| `support_packages`       | Purchasable support durations (6/12 months)              |
| `carts`                  | Pending intents (plan or support package)                |
| `orders`                 | Final invoices with amounts and status                   |
| `order_items`            | Polymorphic items (Plan / SupportPackage)                |
| `payments`               | Gateway transactions with payloads and references        |
| `licenses`               | Generated license keys (unique per subscription)         |
| `license_devices`        | Registered devices with seat numbers                     |
| `demo_license_devices`   | 15-day trial registrations                               |
| `categories` / `posts`   | Blog CMS                                                 |
| `page_visits`            | Traffic log for the monitoring dashboard                 |
| `personal_access_tokens` | Laravel Sanctum tokens                                   |
| Table | Purpose |
| ----- | ------- |
| `users` | Accounts with `user` / `admin` roles and email verification |
| `plans` | Lifetime plans: level, slug, price, discount, device limit |
| `subscriptions` | One lifetime subscription per user, driven by a status machine |
| `subscription_supports` | Support periods with start/expiry timestamps |
| `support_packages` | Purchasable support durations (6 / 12 months) |
| `carts` | Pending purchase intents (one active cart per user) |
| `orders` | Final invoices: order number, amounts, currency, status |
| `order_items` | Polymorphic line items (plan or support package) |
| `payments` | Gateway transactions with references and payloads |
| `licenses` | Issued license keys, unique per subscription |
| `license_devices` | Activated devices with seat numbers |
| `demo_license_devices` | Per-device trial registrations |
| `categories` / `posts` | Blog content |
| `page_visits` | Aggregated traffic statistics |

### Subscription Flow
---

## Purchase Flow

```text
Select Plan or Support Package
        |
        v
   Create Cart  (pending, one per user)
        |
        v
  Start Payment  ──>  Create Order  ──>  Send to Gateway (SEP)
        |                                      |
        |<────────── Callback (GET/POST) ──────┘
        |
   Verify with gateway
        |
   +----+-----------------------------+
   | paid amount > 0                 | paid amount = 0 (free)
   v                                 v
 Update Order + Payment        Finalize immediately
        |
        v
 completeCheckout()  (inside DB transaction, lockForUpdate)
        |
   +----+----------+-----------+-----------+----------+
   | no existing   | same plan | higher    | lower    | support
   | subscription  | level     | level     | level    | package
   v               v           v           v          v
 Purchase        Renew*     Upgrade    Downgrade   Renew
 + License                 (plan_id)   (plan_id +  Support
                             free       device      Period
                            support)    cleanup)
Select plan or support package
            |
            v
     Create cart  (pending, one per user)
            |
            v
     Create order  ──>  Initiate payment (SEP IPG)
            ^                     |
            |                     v
            └──── callback ──> Server-side verification
                                        |
                 +----------------------+----------------------+
                 | paid amount > 0                             | zero amount
                 v                                             v
          Confirm order + payment                     Finalize immediately
                 |
                 v
      Settle checkout (DB transaction with row locking)
                 |
   +---------+---+----------+-----------+----------+
   | no      | same plan   | higher    | lower    | support
   | existing| level       | level     | level    | package
   | sub     |             |           |          |
   v         v             v           v          v
 Purchase   Support       Upgrade     Downgrade   Support
 + license  renewal       (new plan,  (new plan   extension
             (extend      free support limit enforcement)
             support)
```

\* In the lifetime model, "renewal" of a plan equals extending the **support period**.
Settlement is atomic: every state transition runs inside a database transaction with pessimistic locking, callbacks are processed idempotently (a settled order is never settled twice), and free orders bypass the gateway entirely.

---

## REST API (Desktop Client)
## Client API

The Windows/Python client communicates with AvaPark through four signed endpoints:
The Windows desktop client integrates with the platform through a compact REST API:

| Method | Endpoint                            | Description                                  |
| ------ | ----------------------------------- | -------------------------------------------- |
| `POST` | `/api/license/validate`             | Validate license + register device (first run) |
| `POST` | `/api/license/support-status`       | Support status (active/expired + expiry)     |
| `POST` | `/api/license/deactivate-device`    | Deactivate a registered device (logout)      |
| `POST` | `/api/license/info`                 | Full license info incl. support block        |
| Method | Endpoint | Purpose |
| ------ | -------- | ------- |
| `POST` | `/api/license/validate` | Validate the license and activate the calling device |
| `POST` | `/api/license/support-status` | Return the current support period and remaining time |
| `POST` | `/api/license/deactivate-device` | Release a seat (device sign-out) |
| `POST` | `/api/license/info` | Return full license, plan, device, and support details |

All endpoints accept:
Design guarantees:

```json
{
    "license_key": "AVPK-XXXX-XXXX-XXXX-XXXX",
    "machine_fingerprint": "unique-machine-id"
}
```
- Every response payload is cryptographically signed (RSA / SHA-256); the client verifies authenticity and integrity before acting on any data.
- Errors use the same signed envelope, so the client cannot be fed unsigned failure or success states.
- Seat limits, activation, deactivation, and trial eligibility are decided exclusively on the server.
- A built-in per-device demo trial lets prospects evaluate the software before purchasing.

Successful `validate` response:
Detailed request and response contracts are kept in the project's internal API documentation.

```json
{
    "valid": true,
    "message": "Access granted",
    "data": {
        "license_key": "AVPK-XXXX-XXXX-XXXX-XXXX",
        "subscription": {
            "status": "active",
            "effective_status": "active",
            "is_lifetime": true
        },
        "plan": {
            "slug": "pro",
            "max_devices": 4
        },
        "device": {
            "seat_number": 1
        },
        "support": {
            "has_support": true,
            "status": "active",
            "starts_at": "2026-10-06T10:00:00+00:00",
            "expires_at": "2027-04-06T10:00:00+00:00",
            "expires_at_raw": "2027-04-06 10:00:00",
            "is_expired": false,
            "remaining": {
                "total_seconds": 15552000,
                "days": 180,
                "hours": 0,
                "minutes": 0,
                "seconds": 0,
                "text": "180 days"
            },
            "remaining_days": 180
        }
    },
    "signature": "base64-encoded-rsa-sha256-signature"
}
```

Error responses use the same signed envelope with `"valid": false` and a message such as:

```text
Invalid or inactive license
Subscription is inactive
Device limit reached
This device is not registered for this license
Trial period has expired. Please purchase a full license.
```

### Signature Verification

The signature covers the `data` object only: keys are recursively sorted, JSON-encoded (`JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES`), signed with RSA/SHA-256, and base64-encoded.

Generate the key pair:

```bash
openssl genrsa -out storage/app/license_private.pem 2048

openssl rsa \
    -in storage/app/license_private.pem \
    -pubout \
    -out license_public.pem
```

The private key stays on the server and must never be committed. The public key ships with the client for verification.

---

## Tech Stack

| Category           | Technology                                          |
| ------------------ | --------------------------------------------------- |
| Backend            | Laravel 11                                          |
| Language           | PHP 8.2+                                            |
| Authentication     | Laravel Breeze (custom email verification)          |
| API Authentication | Laravel Sanctum                                     |
| Frontend           | Blade + Alpine.js 3                                 |
| CSS                | Tailwind CSS 3 (+ dark mode, RTL)                   |
| Build Tool         | Vite 6                                              |
| Rich Text Editor   | TinyMCE 6                                           |
| Payment Gateway    | shetabit/payment (SEP/SAMAN IPG driver)             |
| Persian Dates      | morilog/jalali                                      |
| Database           | MySQL / MariaDB (SQLite for local testing)          |
| Testing            | PHPUnit 11 + Mockery + Faker                        |
| Code Style         | Laravel Pint                                        |
| Category | Technology |
| -------- | ---------- |
| Framework | Laravel 11 (PHP 8.2+) |
| Authentication | Laravel Breeze with verified email |
| API security | Laravel Sanctum + RSA response signing |
| Frontend | Blade + Alpine.js 3 |
| Styling | Tailwind CSS 3 (dark mode, RTL) |
| Build tooling | Vite 6 |
| Editor | TinyMCE 6 |
| Payments | shetabit/payment (SEP / SAMAN IPG) |
| Calendar | morilog/jalali |
| Database | MySQL 8+ / MariaDB 10.4+ (SQLite for local tests) |
| Quality | PHPUnit 11, Mockery, Laravel Pint |

---

## Installation
## Getting Started

### Requirements

* PHP 8.2 or later (with OpenSSL extension)
* Composer
* Node.js 20+ and npm
* MySQL 8+ / MariaDB 10.4+
* OpenSSL CLI (for generating license signing keys)
- PHP 8.2+ with the OpenSSL extension
- Composer
- Node.js 20+ and npm
- MySQL 8+ or MariaDB 10.4+

### 1. Clone
### Installation

```bash
git clone https://github.com/AdnanMahmoudiDev/ProPark.git
cd ProPark
```

### 2. Install dependencies

```bash
composer install
npm install
```

### 3. Environment

```bash
cp .env.example .env
php artisan key:generate
```

Configure the database:
Configure the database in `.env`:

```env
DB_CONNECTION=mysql
DB_PASSWORD=
```

Payment gateway and demo trial (defaults shown):
Run migrations, seed initial data, and link storage:

```bash
php artisan migrate --seed
php artisan storage:link
```

### Payment Gateway

The SEP (SAMAN) gateway is the default driver. Provide your merchant credentials in `.env`:

```env
PAYMENT_DEFAULT=sep
SEP_TERMINAL_ID=your-terminal-id
SEP_CALLBACK_URL=https://your-domain.com/payment/callback
SEP_DESCRIPTION="AvaPark order payment"
SEP_CURRENCY=T

AVAPARK_DEMO_LICENSE_KEY=AVAPARK-DEMO-TRIAL
```

### 4. Migrate and seed
Additional gateways (e.g., Zarinpal) are configurable in `config/payment.php`.

```bash
php artisan migrate --seed
php artisan storage:link
```
### Scheduling

### 5. Generate the license signing key pair
Order expiry runs on the Laravel scheduler. In production, either run the long-lived worker:

```bash
openssl genrsa -out storage/app/license_private.pem 2048
openssl rsa -in storage/app/license_private.pem -pubout -out license_public.pem
php artisan schedule:work
```

### 6. Run
or register the standard cron entry:

```bash
npm run dev          # assets
php artisan serve    # application → http://127.0.0.1:8000
```cron
* * * * * cd /path-to-project && php artisan schedule:run >> /dev/null 2>&1
```

For production assets: `npm run build`.
### Running Locally

The scheduler must be running in production so abandoned orders expire:

```bash
php artisan schedule:work
npm run dev          # frontend assets
php artisan serve    # application → http://127.0.0.1:8000
```

Or via cron:
For production assets run `npm run build`.

```cron
* * * * * cd /path-to-project && php artisan schedule:run >> /dev/null 2>&1
```

---

## Seeded Data

### Plans (`PlanSeeder`)
### Plans

| Plan       | Slug      | Level | Device Limit |
| ---------- | --------- | ----: | -----------: |
| Eco        | `eco`     |     1 |            2 |
| Pro        | `pro`     |     2 |            4 |
| Sazmani    | `sazmani` |     3 |            8 |
| Plan | Slug | Level | Device Limit |
| ---- | ---- | ----: | -----------: |
| Eco | `eco` | 1 | 2 |
| Pro | `pro` | 2 | 4 |
| Sazmani | `sazmani` | 3 | 8 |

Prices are set through the admin panel (seeded plans start at zero price).
Plan prices are managed from the admin panel (seeded plans start unpriced).

### Support Packages (`SupportPackageSeeder`)
### Support Packages

| Package            | Duration | Price (Toman) |
| ------------------ | -------: | ------------: |
| پشتیبانی ۶ ماهه    |  6 months |   1,500,000 |
| پشتیبانی ۱ ساله    | 12 months |   2,600,000 |
| Package | Duration | Price (Toman) |
| ------- | -------: | ------------: |
| 6-month support | 6 months | 1,500,000 |
| Annual support | 12 months | 2,600,000 |

---

## Creating an Administrator
## Admin Access

There is no admin seeder. Register normally, then promote the account:
No administrator is seeded. After registering a normal account, promote it via Tinker:

```bash
php artisan tinker
    ->update(['role' => 'admin']);
```

The admin panel lives at `/admin` and is protected by the `admin` middleware alias.
The administration panel is served under `/admin` and is restricted to admin accounts.

---

## Testing & Tooling
## Development

```bash
php artisan test        # PHPUnit test suite (auth, email verification, profile)
./vendor/bin/pint       # code style formatting
composer dev            # serve + queue + pail + vite, concurrently
php artisan test      # test suite (auth, email verification, profile)
./vendor/bin/pint     # code style formatting
composer dev          # serve + queue + logs + vite, concurrently
```

---

## Security Notes

* Private RSA signing key kept in `storage/app/` (outside the repository)
* Payment callback route exempt from CSRF but guarded by order ownership + gateway verification
* Callback re-authentication regenerates the session token
* Trust-proxy configuration for correct client IPs
* Database transactions and row locking around checkout and payment verification
* Role-based access control via the `admin` middleware
* Prepared statements / query builder throughout; polymorphic items validated by type

---

## Roadmap

* [ ] Subscription expiration notifications (email/SMS)
* [ ] Discount / coupon codes
* [ ] Queue-based processing for heavy jobs (backups, notifications)
* [ ] Advanced roles & permissions (e.g., Laravel Pennant / Spatie)
* [ ] Swagger/OpenAPI documentation for the client API
* [ ] 2FA for admin accounts
* [ ] Webhook notifications for payment events
* [ ] Multi-gateway support (Zarinpal and others are already configurable)
- [ ] Renewal and expiry notifications (email / SMS)
- [ ] Discount and coupon codes
- [ ] Queue-backed processing for heavy jobs (backups, notifications)
- [ ] Fine-grained role and permission management
- [ ] OpenAPI specification for the client API
- [ ] Two-factor authentication for administrators
- [ ] Payment webhooks for downstream integrations

---

## Project Status

AvaPark is under **active development** and runs in production at [avapark.ir](https://www.avapark.ir).

The codebase demonstrates a real-world Laravel architecture covering lifetime subscription licensing, support-period commerce, real payment-gateway integration, RSA-signed client APIs, device-based access control, financial reporting, content management, and bilingual RTL/LTR localization.

---

## License

This project is released under the MIT license (see `composer.json`).
