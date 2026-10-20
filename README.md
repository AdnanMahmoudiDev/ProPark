# AvaPark

**A web-based licensing, sales, and management platform for Windows parking management software.**

AvaPark is the web platform behind the commercial operation of the AvaPark Windows parking management application. It provides the infrastructure required to sell the software, issue and validate licenses, manage device activations, process online payments, and deliver technical support.

Instead of handling sales, licensing, and customer support separately, AvaPark brings these operations together in one centralized platform. Customers can purchase software plans, activate their licenses, manage registered devices, view invoices, and purchase support extensions. Administrators can manage customers, licenses, pricing, payments, support packages, and other business operations through a dedicated administration panel.

AvaPark also provides a secure REST API that connects the Windows application to the web platform, allowing the desktop software to validate licenses, check device authorization, and retrieve license and support information.

**In short, AvaPark is the web-based commercial and licensing infrastructure that connects the AvaPark Windows application with its customers, payments, licenses, devices, and support services.**

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

 **Live Website:** [https://www.avapark.ir](https://www.avapark.ir)

---

## Table of Contents

- [Key Features](#key-features)
- [How AvaPark Works](#how-avapark-works)
- [License and Support Model](#license-and-support-model)
- [Software Plans](#software-plans)
- [Customer Dashboard](#customer-dashboard)
- [Administration Panel](#administration-panel)
- [Windows Client API](#windows-client-api)
- [API Response Signing](#api-response-signing)
- [Technology Stack](#technology-stack)
- [Requirements](#requirements)
- [Installation](#installation)
- [Configuration](#configuration)
- [Database Seeding](#database-seeding)
- [Development and Testing](#development-and-testing)
- [Security Considerations](#security-considerations)
- [Roadmap](#roadmap)
- [License](#license)

---

## Key Features

### Software Licensing and Device Management

- Issue and manage software licenses.
- Support lifetime software licenses.
- Activate licenses on authorized devices.
- Enforce device limits according to the purchased plan.
- Associate activations with device fingerprints.
- Validate licenses through the Windows client API.
- Deactivate registered devices when permitted.
- Manage license and device information through the customer dashboard.

### Online Sales and Payments

- Display software plans and their pricing.
- Support the complete purchase and checkout flow.
- Integrate with the SEP (Saman Electronic Payment) gateway.
- Verify payment results on the server.
- Process payment callbacks with duplicate-processing protection.
- Maintain order and payment records.
- Generate and display invoices.
- Support plan changes and additional support purchases.

### Technical Support Management

- Include an initial technical support period with a license purchase.
- Offer paid support extensions.
- Support six-month and twelve-month support packages.
- Track support validity independently of the lifetime license.
- Display support status to customers and administrators.

### Customer Experience

- User registration and authentication.
- Dedicated customer dashboard.
- License and device management.
- Purchase history and order details.
- Invoice access.
- Support status and extension options.
- Persian and English interfaces.
- Jalali date support.

### Administration and Website Management

- Administrative dashboard and business overview.
- Customer and account management.
- License and device management.
- Software plan and pricing management.
- Order and payment management.
- Technical support package management.
- Blog and website content management.
- Backup functionality.
- Monitoring and page analytics.

---

## How AvaPark Works

The platform connects the customer, the web application, the payment gateway, and the Windows software.

1. **Plan selection:** A customer selects a software plan from the website.
2. **Checkout:** AvaPark creates an order and directs the customer through the payment process.
3. **Payment verification:** The server verifies the payment result through the payment integration.
4. **License issuance:** After successful payment processing, the platform issues the corresponding license.
5. **Device activation:** The Windows application communicates with the API to validate the license and check device authorization.
6. **Customer management:** The customer can review their license, registered devices, invoices, purchases, and support status.
7. **Ongoing support:** When the included support period expires, the customer can purchase an eligible support extension.

The software license and technical support period are managed separately. A lifetime license does not automatically mean lifetime technical support.

---

## License and Support Model

AvaPark separates software ownership rights represented by a license from access to technical support services.

| Item | Description |
|---|---|
| Software license | Lifetime validity, according to the applicable license terms |
| Technical support | Time-limited service |
| Initial support | Six months included with the license, according to the current business model |
| Support extension | Available through paid support packages |
| Device activation | Subject to the device limit of the purchased plan |

**Important:** The license remains lifetime-valid under the applicable terms, while technical support may expire and require renewal. License validity does not remove device limits or other applicable licensing conditions.

---

## Software Plans

AvaPark supports three software plan levels:

| Plan | Level | Maximum Devices |
|---|---:|---:|
| Eco | 1 | 2 |
| Pro | 2 | 4 |
| Sazmani (Enterprise) | 3 | 8 |

Plan pricing is configurable through the administration panel.

### Support Packages

The current configured support packages are:

| Package | Duration | Price |
|---|---|---:|
| Six-month support | 6 months | 1,500,000 Toman |
| Twelve-month support | 12 months | 2,600,000 Toman |

Prices and available packages should be verified against the live application and administration settings before publication, as they may change.

---

## Customer Dashboard

The customer dashboard provides a central place to manage purchases and software access.

Depending on the user's account and the available features, customers can:

- View their software licenses.
- Review license details and status.
- Manage registered devices.
- Review orders and purchase history.
- Access invoices.
- Check technical support validity.
- Purchase available support extensions.
- Access account-related features.

---

## Administration Panel

AvaPark includes a dedicated administration panel for managing the platform's commercial and operational activities.

Administrative features include:

- Customer and user management.
- License and device administration.
- Software plan and pricing configuration.
- Order and payment management.
- Support package configuration.
- Website and blog content management.
- Dashboard statistics and financial reporting.
- Backup and monitoring functionality.

Access to administrative functionality should be restricted to authorized users.

---

## Windows Client API

AvaPark exposes REST API endpoints for communication between the Windows application and the web platform.

The API supports license validation, support-status checks, device deactivation, and license information retrieval.

### Available Endpoints

| Method | Endpoint | Purpose |
|---|---|---|
| `POST` | `/api/license/validate` | Validate a license and check its authorization |
| `POST` | `/api/license/support-status` | Retrieve technical support status |
| `POST` | `/api/license/deactivate-device` | Request device deactivation |
| `POST` | `/api/license/info` | Retrieve license information |

Requests should include the parameters required by the relevant endpoint, such as license identifiers and device information.

The exact request fields, validation rules, and response schemas are defined by the API implementation. Consult the corresponding routes and controllers before integrating a client.

### License Validation

The Windows application uses the validation endpoint to communicate with the server and check whether a license can be used on a device.

The platform enforces device limits on the server side rather than relying exclusively on client-side checks.

### Support Status

The support-status endpoint allows the desktop application to retrieve information about the license's technical support period.

Support expiration is independent of lifetime license validity.

### Device Deactivation

The deactivation endpoint allows the client to request the removal of a device activation, subject to the platform's validation and authorization rules.

### License Information

The license-information endpoint provides the license details supported by the API implementation.

### Trial Access

The platform also supports a demo trial associated with a device. The precise trial eligibility and enforcement rules depend on the current implementation.

---

## API Response Signing

AvaPark uses cryptographic signing for API responses to help the Windows application verify that responses originated from the expected server and have not been modified.

The documented implementation uses:

- RSA digital signatures.
- SHA-256 as the signature hash algorithm.
- Server-side signing.
- Client-side signature verification using the corresponding public key.

The Windows application must verify signed responses before trusting the protected data.

**Security note:** Private signing keys must remain secret and must never be embedded in the distributed Windows application. Only the public key required for signature verification should be distributed to the client.

---

## Technology Stack

AvaPark is built with the following technologies and libraries.

| Technology | Purpose |
|---|---|
| PHP 8.2+ | Backend runtime |
| Laravel 11 | Web application framework |
| Laravel Breeze | Authentication scaffolding |
| Laravel Sanctum | API authentication capabilities |
| Blade | Server-rendered templates |
| Alpine.js | Lightweight frontend interactions |
| Tailwind CSS | Styling and responsive UI |
| Vite | Frontend asset compilation |
| TinyMCE | Rich-text content editing |
| SEP payment integration | Online payment processing |
| Morilog Jalali | Jalali date support |
| MySQL / MariaDB | Production database options |
| SQLite | Lightweight testing database |
| PHPUnit 11 | Automated testing |

---

## Requirements

Before installing AvaPark, ensure that your environment includes:

- PHP 8.2 or later.
- Composer.
- Node.js and npm.
- A supported database, such as MySQL or MariaDB.
- A web server compatible with Laravel.
- The PHP extensions required by Laravel and the project's dependencies.

A valid SEP merchant configuration is required to process real payments.

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

### 3. Configure Environment Variables

Create your environment file:

```bash
cp .env.example .env
```

On Windows, you can copy `.env.example` to `.env` manually or run:

```powershell
Copy-Item .env.example .env
```

### 4. Generate the Application Key

```bash
php artisan key:generate
```

### 5. Configure the Database

Update the database settings in `.env` to match your local environment.

For example:

```dotenv
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=avapark
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

Create the database before running migrations.

### 6. Run Migrations

```bash
php artisan migrate
```

If the project provides seeders and you want to populate the database with development data, see [Database Seeding](#database-seeding).

### 7. Build Frontend Assets

For development:

```bash
npm run dev
```

For production:

```bash
npm run build
```

### 8. Start the Development Server

```bash
php artisan serve
```

Open the local URL displayed by Artisan in your browser.

For a production deployment, configure the web server's document root to point to Laravel's `public` directory and follow Laravel's deployment recommendations.

---

## Configuration

### Payment Gateway

Configure the SEP payment integration using the environment variables and application settings required by the current implementation.

Before enabling real transactions:

- Use the correct merchant credentials.
- Configure the payment gateway's callback URL.
- Verify successful and unsuccessful payment flows.
- Confirm that payment verification is performed server-side.
- Test callback handling and duplicate-processing protection.
- Never commit production credentials to version control.

The exact environment variable names should be taken from the project's configuration files and payment integration code.

### Application Environment

For production, configure the appropriate application URL, environment, database credentials, logging, caching, and other deployment settings in `.env`.

Do not commit `.env` or other files containing secrets to the repository.

### Storage and Cache

After deployment or configuration changes, the following commands may be useful:

```bash
php artisan optimize:clear
php artisan storage:link
```

Run only the commands applicable to your deployment and storage configuration.

---

## Database Seeding

The project includes plan seed data for development and initial setup.

The documented default plan structure is:

| Plan | Level | Device Limit |
|---|---:|---:|
| Eco | 1 | 2 |
| Pro | 2 | 4 |
| Sazmani | 3 | 8 |

Plan prices are configured through the administration panel.

The documented support packages are:

- Six months: 1,500,000 Toman.
- Twelve months: 2,600,000 Toman.

To inspect the available seeders:

```bash
php artisan db:seed --help
```

To run the project's seeders:

```bash
php artisan db:seed
```

**Warning:** Running seeders against an existing database may create or modify data, depending on their implementation. Review the seeders before running them in production.

---

## Development and Testing

### Run the Application

```bash
php artisan serve
```

### Compile Frontend Assets

```bash
npm run dev
```

### Run Automated Tests

```bash
php artisan test
```

The project uses PHPUnit 11 for automated testing.

For reliable test results, configure a dedicated testing database and review the test environment settings before running the test suite.

### Useful Artisan Commands

Clear cached application configuration and data:

```bash
php artisan optimize:clear
```

Inspect registered routes:

```bash
php artisan route:list
```

Run database migrations:

```bash
php artisan migrate
```

---

## Security Considerations

Because AvaPark manages commercial transactions and software licenses, security is an important part of its design and operation.

Recommended practices include:

- Keep production credentials and private keys out of version control.
- Enforce authorization on protected dashboard and administrative actions.
- Validate API requests on the server.
- Enforce device limits and license rules server-side.
- Verify payment results on the server rather than trusting browser redirects.
- Handle payment callbacks safely and prevent duplicate order settlement.
- Verify API response signatures in the Windows client.
- Keep private signing keys on the server.
- Use HTTPS in production.
- Keep PHP, Laravel, and third-party dependencies updated.
- Restrict administrative access to authorized personnel.

These are operational recommendations; the security of a deployed system also depends on its actual configuration, implementation, and maintenance.

---

## Roadmap

Potential areas for future development include:

- Customer and transaction notifications.
- Discount coupons and promotional codes.
- Queue-based processing for background tasks.
- More granular role and permission management.
- OpenAPI documentation for the REST API.
- Two-factor authentication.
- Expanded payment webhook support.

Roadmap items represent potential improvements and should not be interpreted as currently implemented features.

---

## License

AvaPark is proprietary software.

Copyright (c) 2026 Adnan Mahmoudi. All rights reserved.

Use, copying, modification, redistribution, sublicensing, and the creation of derivative works are not permitted except where expressly authorized by the copyright holder through a separate written license or agreement.

Commercial licenses and technical support services are subject to their applicable terms and agreements.

Third-party dependencies remain subject to their respective licenses.

---

**AvaPark — The web platform for selling, licensing, and managing Windows parking management software.**
