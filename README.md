# ProPark
# AvaPark (آواپارک)

**A Laravel-based subscription, software licensing, and parking management platform.**
**A Laravel-based subscription, software licensing, and payment platform for the AvaPark Windows parking-management software.**

<p align="center">
  <img src="public/images/ProPark.png" width="220" alt="ProPark Logo">
  <img src="public/images/ProPark.png" width="220" alt="AvaPark Logo">
</p>

<p align="center">
  <img src="https://img.shields.io/badge/PHP-%E2%89%A58.2-777BB4?logo=php&logoColor=white" alt="PHP 8.2+">
  <img src="https://img.shields.io/badge/TailwindCSS-3.x-38B2AC?logo=tailwindcss&logoColor=white" alt="Tailwind CSS">
  <img src="https://img.shields.io/badge/Vite-6.x-646CFF?logo=vite&logoColor=white" alt="Vite">
  <img src="https://img.shields.io/badge/Invoices-SEP%20IPG-28A745" alt="SEP Payment Gateway">
</p>

---

## Overview

**ProPark** is a Laravel-based web platform developed to manage subscriptions, software licenses, registered devices, users, and the infrastructure surrounding a Windows parking management application.
**AvaPark** is a full-featured Laravel platform that manages the commercial side of a Windows-based parking management application: subscription plans, software licenses, registered devices, support packages, invoicing, and real payment-gateway transactions.

The platform provides a complete subscription and licensing workflow, including:
A production deployment operates under the **AvaPark** brand:

* Subscription purchasing and renewal
* Plan upgrades and downgrades
* Software license generation
* Device registration and management
* User and administration panels
* REST API for the Windows client
* RSA-signed API responses
* Database backup and restore
* Blog and content management
* Persian and English localization
* RTL and LTR interface support
### 🌐 Live: **https://www.avapark.ir**

A production deployment of ProPark is currently used under the **AvaPark** brand.
The platform provides a complete business workflow:

### Live Deployment
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

**https://www.avapark.ir**

---

## Project Highlights

This project focuses on implementing real-world backend and application architecture rather than a simple CRUD application.
This is not a CRUD demo. The project implements real-world commerce and licensing architecture:

### Subscription Management
### Lifetime Subscriptions

The application supports a complete subscription lifecycle:
Subscriptions **never expire**. What expires is the *support period*:

* Multiple subscription plans
* Multiple subscription durations
* New purchases
* Subscription renewals
* Plan upgrades
* Plan downgrades
* Automatic subscription validity calculation
* Device limits based on the selected plan
* Transaction-safe checkout
* Each subscription is tied to a plan (`eco`, `pro`, `sazmani`) with a lifetime license
* The **first purchase** automatically grants **6 months of free support**
* Support can be extended by purchasing support packages (6 or 12 months)
* Renewal adds months on top of the current expiry (or from "now" if already expired)
* Support status (active / expired / remaining days) is exposed through the client API

Upgrade and downgrade operations also contain business rules for handling remaining subscription time and registered devices.
### Orders, Payments, and Invoices

### Software Licensing
The checkout pipeline is split into three persistence layers:

Each subscription can have an associated software license.

License keys follow this format:

```text
PRPK-XXXX-XXXX-XXXX-XXXX
Cart (intent)  →  Order (invoice)  →  Payment (gateway transaction)
```

The licensing system supports:
* `carts` — a single pending intent per user (plan purchase, renewal, upgrade, downgrade, or support package)
* `orders` — a final invoice with a unique order number (`ORD-YYYYMMDD-XXXXX`), subtotal, discount, and payable amount
* `order_items` — polymorphic items (`Plan` or `SupportPackage`) with unit price, discount, final amount, and metadata
* `payments` — one row per gateway attempt, storing the gateway authority, reference ID, request/response payloads, and failure messages

* Unique license generation
* License-to-subscription association
* Machine fingerprint-based device registration
* Automatic seat allocation
* Device limits
* Device activation and deactivation
* License validation
* Subscription validity checks
* API-based device deactivation
Safety properties:

### API Security
* All state changes run inside **database transactions** with `lockForUpdate()`
* Free orders (100% discount) are finalized immediately without hitting the gateway
* Abandoned pending orders are **auto-expired** by a scheduled command (`orders:expire-pending`, every 10 minutes, 30-minute timeout)
* The payment callback is idempotent: already-paid orders are never double-processed

The licensing API uses **RSA/SHA-256 digital signatures**.
### Real Payment Gateway (SEP IPG)

API responses are signed on the server and can be verified by the Windows client using the corresponding public key.
Payments run through [shetabit/payment](https://github.com/shetabit/payment) with the **SEP (SAMAN)** driver as default:

This provides a mechanism for the client to verify that a response was generated by the expected server and has not been modified after signing.
* Token generation, redirect to the bank page, and server-side **verification**
* Callback accepts both `GET` and `POST` (Shaparak returns POST) and is exempt from CSRF
* Session recovery: if the shopper session is lost on callback, the order owner is re-authenticated securely
* SEP `State != OK` responses are mapped to `cancelled` / `failed` correctly
* Every attempt is persisted with full request/response payloads for auditing

The private signing key is kept on the server and is not included in the repository.
### Software Licensing

---
License keys are generated in the format:

## Main Features
```text
AVPK-XXXX-XXXX-XXXX-XXXX
```

### Store & Subscriptions
* Unique key generation with database collision checks
* One license per subscription (unique constraint)
* Device registration by **machine fingerprint** with automatic seat allocation
* Per-plan device limits (`eco` = 2, `pro` = 4, `sazmani` = 8 by default)
* On downgrade, excess devices are automatically removed to respect the new limit
* Device activation / deactivation both from the user panel and the client API

* Eco, Pro, and Enterprise plans
* 1, 3, 6, and 12-month durations
* Different device limits per plan
* Discounted and original prices
* Automatic transaction type detection
* Purchase, renewal, upgrade, and downgrade workflows
* Transaction-safe checkout using database transactions
* Row locking with `lockForUpdate()` where required
* Automatic device adjustment after plan changes
### Demo Trial Mode

> The current payment process is simulated and does not yet use a production payment gateway.
A built-in trial key (`AVAPARK-DEMO-TRIAL`, configurable via `AVAPARK_DEMO_LICENSE_KEY`):

### User Dashboard
* Grants **15 days** of access per machine fingerprint
* Trial records are permanent — a device cannot drop its trial to restart it
* Trial devices cannot be deactivated through the API
* Expired trials return a signed "purchase required" response

Users can:
### API Response Signing

* View their active subscription
* View subscription details
* Access their software license
* Check remaining subscription time
* View registered devices
* Deactivate devices
* Update profile information
* Manage their phone number
* Change their password
* Delete their account
Every API response `data` payload is signed with **RSA/SHA-256** using a server-side private key (`storage/app/license_private.pem`). The desktop client verifies the signature with the matching public key, guaranteeing authenticity and integrity. Keys are recursively sorted before JSON encoding so signatures are deterministic.

Authentication is implemented using **Laravel Breeze** with a customized email verification flow.
### Admin Financial Analytics

### Administration Panel
The admin panel includes a full invoicing section:

Administrators can:
* Order list with search (order number, ID, customer name/email/phone) and status filters
* Quick stats: total revenue, paid/pending/failed/expired/canceled counters
* Analytics page: revenue for month / 6 months / year, average order value, top-selling packages, 12-month revenue chart with Persian month labels
* Printable invoice detail view with items and payment history

* View system statistics
* Manage users
* Manage user roles
* Manage subscriptions
* Change subscription status
* Change subscription plans
* Manually renew subscriptions
* Manually issue subscriptions and licenses
* Manage store pricing
* Perform bulk price updates
* View subscriptions approaching expiration
* Create database backups
* Restore SQL database backups
* Manage blog categories
* Manage blog posts
* Upload blog images
* Edit content using TinyMCE
---

### Blog & Content Management
## Main Features

The platform includes a built-in blog system with:
### Store & Checkout

* Categories
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
* Three plans: **Eco**, **Pro**, **Sazmani (Enterprise)** — priced directly on the plan (one-time, lifetime)
* Support packages: **6-month** and **1-year** with discounts
* Discounted and original prices with automatic discount calculation
* Automatic transaction-type detection: `purchase`, `renew`, `upgrade`, `downgrade`, or `support`
* Upgrade/downgrade by plan level; downgrade enforces the new device limit
* Transaction-safe checkout

### Localization
### User Dashboard

The application currently supports:
* Active subscription and plan overview
* License key with copy-to-clipboard
* Registered devices list with deactivation
* Support status and remaining days
* Purchase history / invoices with detail view
* Cart management (add plan or support package, cancel, checkout)
* Profile: name, email verification, phone number, password change, account deletion

* Persian
* English
Authentication is **Laravel Breeze** with a custom email-verification notification (`CustomVerifyEmail` + branded HTML template).

Translations are stored in:
### Administration Panel

```text
lang/fa.json
lang/en.json
```
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

The interface supports both:
### Blog & Content Management

```text
RTL
LTR
```
* Categories with post counts, search, and category filtering
* Featured post on page 1, pagination (9 per page)
* View counting with session-based duplicate prevention
* Related posts by category
* SEO fields: meta title, description, canonical URL, OpenGraph image
* Soft deletes and draft/published workflow

The selected locale is stored in the session and the interface automatically adapts to the selected language.
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

The application separates a significant portion of its business logic from controllers through dedicated service classes.
Business logic is separated from controllers through a dedicated service layer:

A simplified structure:

```text
app/
├── Console/
│   └── Commands/
│       └── ExpirePendingOrdersCommand.php    # orders:expire-pending (scheduled)
│
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
│   │   ├── Admin/                            # Dashboard, Users, Subscriptions, Supports,
│   │   │                                     # Store, Licenses, Invoices, Database, Monitoring,
│   │   │                                     # Categories, Posts
│   │   ├── Api/
│   │   │   └── LicenseController
│   │   │
│   │   ├── Auth/
│   │   │
│   │   └── User/
│   │       ├── CartController
│   │       ├── SubscriptionDetailsController
│   │       └── UserDeviceController
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
│   │   ├── AdminMiddleware
│   │   └── SetLocale
│   │   ├── AdminMiddleware.php               # role === 'admin' (alias: admin)
│   │   ├── SetLocale.php                     # Session-based locale
│   │   └── TrackPageVisits.php               # Visit logging with cache dedup
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
│   └── CustomVerifyEmail
│   └── CustomVerifyEmail.php
│
├── Services/
│   ├── CartService.php
│   ├── CheckoutService.php
│   ├── SubscriptionService.php
│   ├── LicenseService.php
│   ├── LicenseValidatorService.php
│   ├── DeviceService.php
│   ├── DatabaseBackupService.php
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
│       └── SignatureService.php
│       └── SignatureService.php              # RSA/SHA-256 response signing
│
└── View/
    └── Components/
└── View/Components/
```

The service layer is primarily used for operations such as:
### Data Model

* Checkout processing
* Subscription lifecycle management
* License generation and validation
* Device management
* API signature generation
* Database backup operations
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

---
### Subscription Flow

## Data Model

| Table                    | Description                                |
| ------------------------ | ------------------------------------------ |
| `users`                  | Application users and roles                |
| `plans`                  | Subscription plan definitions              |
| `plan_prices`            | Plan prices based on subscription duration |
| `subscriptions`          | User subscriptions                         |
| `carts`                  | Purchase and plan-change transactions      |
| `licenses`               | Generated software licenses                |
| `license_devices`        | Devices registered to licenses             |
| `categories`             | Blog categories                            |
| `posts`                  | Blog posts                                 |
| `personal_access_tokens` | Laravel Sanctum tokens                     |

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
    |       |
    |       +-- Purchase
    |              |
    |              +-- New Subscription + License
    |
    +-- Higher-level plan
    |       |
    |       +-- Upgrade
    |              |
    |              +-- Upgrade + Remaining Time Bonus
    |
    +-- Lower-level plan
    |       |
    |       +-- Downgrade
    |              |
    |              +-- Preserve Remaining Time + Device Adjustment
    |
    +-- Same plan
            |
            +-- Renew
                   |
                   +-- Extend Subscription
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
```

The checkout process uses database transactions to keep related subscription, license, and device changes consistent.
\* In the lifetime model, "renewal" of a plan equals extending the **support period**.

---

## REST API
## REST API (Desktop Client)

The Windows desktop client communicates with ProPark through the licensing API.
The Windows/Python client communicates with AvaPark through four signed endpoints:

| Method | Endpoint                          | Description                              |
| ------ | --------------------------------- | ---------------------------------------- |
| `POST` | `/api/license/validate`           | Validate a license and register a device |
| `POST` | `/api/license/remaining-validity` | Retrieve remaining subscription validity |
| `POST` | `/api/license/deactivate-device`  | Deactivate a registered device           |
| `POST` | `/api/license/info`               | Retrieve license information             |
| Method | Endpoint                            | Description                                  |
| ------ | ----------------------------------- | -------------------------------------------- |
| `POST` | `/api/license/validate`             | Validate license + register device (first run) |
| `POST` | `/api/license/support-status`       | Support status (active/expired + expiry)     |
| `POST` | `/api/license/deactivate-device`    | Deactivate a registered device (logout)      |
| `POST` | `/api/license/info`                 | Full license info incl. support block        |

### Example Request
All endpoints accept:

```json
{
    "license_key": "PRPK-XXXX-XXXX-XXXX-XXXX",
    "license_key": "AVPK-XXXX-XXXX-XXXX-XXXX",
    "machine_fingerprint": "unique-machine-id"
}
```

### Example Response
Successful `validate` response:

```json
{
    "valid": true,
    "message": "Access granted",
    "data": {
        "license_key": "PRPK-XXXX-XXXX-XXXX-XXXX",
        "license_key": "AVPK-XXXX-XXXX-XXXX-XXXX",
        "subscription": {
            "status": "active",
            "effective_status": "active"
            "effective_status": "active",
            "is_lifetime": true
        },
        "plan": {
            "slug": "pro"
            "slug": "pro",
            "max_devices": 4
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
    "signature": "base64-encoded-rsa-signature"
    "signature": "base64-encoded-rsa-sha256-signature"
}
```

Possible API errors include:
Error responses use the same signed envelope with `"valid": false` and a message such as:

```text
Invalid or inactive license
Subscription expired
Subscription is inactive
Device limit reached
This device is not registered for this license
Trial period has expired. Please purchase a full license.
```

---
### Signature Verification

## API Response Signing
The signature covers the `data` object only: keys are recursively sorted, JSON-encoded (`JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES`), signed with RSA/SHA-256, and base64-encoded.

The licensing API signs responses using **RSA/SHA-256**.
Generate the key pair:

The Windows client can use the corresponding public key to verify the response signature.

The private key must remain on the server and should never be committed to Git.

Generate a key pair with:

```bash
openssl genrsa -out storage/app/license_private.pem 2048

    -out license_public.pem
```

The public key can then be distributed with the Windows client for response verification.
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

---

## Installation

### Requirements

* PHP 8.2 or later
* PHP 8.2 or later (with OpenSSL extension)
* Composer
* Node.js 20 or later
* npm
* MySQL or MariaDB
* OpenSSL
* Node.js 20+ and npm
* MySQL 8+ / MariaDB 10.4+
* OpenSSL CLI (for generating license signing keys)

SQLite can also be used for testing.
### 1. Clone

### 1. Clone the Repository

```bash
git clone https://github.com/AdnanMahmoudiDev/ProPark.git

cd ProPark
```

### 2. Install PHP Dependencies
### 2. Install dependencies

```bash
composer install
```

### 3. Install Frontend Dependencies

```bash
npm install
```

### 4. Create the Environment File
### 3. Environment

```bash
cp .env.example .env
```

### 5. Generate the Application Key

```bash
php artisan key:generate
```

### 6. Configure the Database
Configure the database:

Configure the database connection in `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ProPark
DB_DATABASE=avapark
DB_USERNAME=root
DB_PASSWORD=
```

### 7. Run Migrations and Seeders
Payment gateway and demo trial (defaults shown):

```bash
php artisan migrate --seed
```env
PAYMENT_DEFAULT=sep
SEP_TERMINAL_ID=your-terminal-id
SEP_CALLBACK_URL=https://your-domain.com/payment/callback
SEP_DESCRIPTION="AvaPark order payment"
SEP_CURRENCY=T

AVAPARK_DEMO_LICENSE_KEY=AVAPARK-DEMO-TRIAL
```

### 8. Create the Storage Link
### 4. Migrate and seed

```bash
php artisan migrate --seed
php artisan storage:link
```

### 9. Start the Frontend Development Server
### 5. Generate the license signing key pair

```bash
npm run dev
openssl genrsa -out storage/app/license_private.pem 2048
openssl rsa -in storage/app/license_private.pem -pubout -out license_public.pem
```

For production assets:
### 6. Run

```bash
npm run build
npm run dev          # assets
php artisan serve    # application → http://127.0.0.1:8000
```

### 10. Start Laravel
For production assets: `npm run build`.

The scheduler must be running in production so abandoned orders expire:

```bash
php artisan serve
php artisan schedule:work
```

The application will normally be available at:
Or via cron:

```text
http://127.0.0.1:8000
```cron
* * * * * cd /path-to-project && php artisan schedule:run >> /dev/null 2>&1
```

---

## Creating an Administrator
## Seeded Data

There is currently no dedicated administrator seeder.
### Plans (`PlanSeeder`)

Create a regular account first and then update its role using Laravel Tinker:
| Plan       | Slug      | Level | Device Limit |
| ---------- | --------- | ----: | -----------: |
| Eco        | `eco`     |     1 |            2 |
| Pro        | `pro`     |     2 |            4 |
| Sazmani    | `sazmani` |     3 |            8 |

Prices are set through the admin panel (seeded plans start at zero price).

### Support Packages (`SupportPackageSeeder`)

| Package            | Duration | Price (Toman) |
| ------------------ | -------: | ------------: |
| پشتیبانی ۶ ماهه    |  6 months |   1,500,000 |
| پشتیبانی ۱ ساله    | 12 months |   2,600,000 |

---

## Creating an Administrator

There is no admin seeder. Register normally, then promote the account:

```bash
php artisan tinker
```

Then:

```php
\App\Models\User::where('email', 'you@example.com')
    ->update(['role' => 'admin']);
```

---
The admin panel lives at `/admin` and is protected by the `admin` middleware alias.

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
## Testing & Tooling

Run the test suite:

```bash
php artisan test
php artisan test        # PHPUnit test suite (auth, email verification, profile)
./vendor/bin/pint       # code style formatting
composer dev            # serve + queue + pail + vite, concurrently
```

Format PHP code using Laravel Pint:

```bash
./vendor/bin/pint
```

The project also includes a Composer development script:

```bash
composer dev
```

---

## Tech Stack
## Security Notes

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
* Private RSA signing key kept in `storage/app/` (outside the repository)
* Payment callback route exempt from CSRF but guarded by order ownership + gateway verification
* Callback re-authentication regenerates the session token
* Trust-proxy configuration for correct client IPs
* Database transactions and row locking around checkout and payment verification
* Role-based access control via the `admin` middleware
* Prepared statements / query builder throughout; polymorphic items validated by type

---

## Roadmap

Planned improvements include:
* [ ] Subscription expiration notifications (email/SMS)
* [ ] Discount / coupon codes
* [ ] Queue-based processing for heavy jobs (backups, notifications)
* [ ] Advanced roles & permissions (e.g., Laravel Pennant / Spatie)
* [ ] Swagger/OpenAPI documentation for the client API
* [ ] 2FA for admin accounts
* [ ] Webhook notifications for payment events
* [ ] Multi-gateway support (Zarinpal and others are already configurable)

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
AvaPark is under **active development** and runs in production at [avapark.ir](https://www.avapark.ir).

A production deployment is currently operating under the **AvaPark** brand.
The codebase demonstrates a real-world Laravel architecture covering lifetime subscription licensing, support-period commerce, real payment-gateway integration, RSA-signed client APIs, device-based access control, financial reporting, content management, and bilingual RTL/LTR localization.

The project demonstrates a real-world Laravel application architecture involving subscription management, software licensing, device-based access control, REST API communication, administration tools, localization, database transactions, and digitally signed API responses.
---

## License

This project is released under the MIT license (see `composer.json`).
