# Global Logistics & Fleet Tracking System (GLFTS)

A Laravel 11 backend project for managing vehicles, drivers, shipments, and maintenance logs for a logistics company.

## Features

- **Eloquent Relationships:** Many-to-Many (Vehicles & Shipments), Polymorphic (Comments).
- **Service Layer (State Machine):** Enforces shipment lifecycles (`Pending` → `Loading` → `In_Transit` → `Delivered`).
- **Observer Pattern:** Updates driver status automatically when shipment leaves for transit.
- **Custom Validation Rule:** `CheckVehicleCapacity` ensures vehicles are not overloaded.
- **API Endpoints:** Live Dashboard, Geospatial Search, Capacity Calculator.
- **Artisan Command:** Automated maintenance alert check (`php artisan fleet:maintenance-check`).
- **Security:** API Rate limiting (`throttle:60,1`), Eloquent Cast Encryption for financials (`cost`), Custom `CheckCertification` Middleware.

## Requirements

- PHP 8.2+
- Composer
- Docker (Optional for local, required for CI/CD simulation)
- MySQL / SQLite

## Setup Instructions (Local without Docker)

1. Clone the repository.
2. Run `composer install`.
3. Copy `.env.example` to `.env` and configure your database settings.
   - For Production settings, ensure `APP_ENV=production` and `APP_DEBUG=false`.
4. Run `php artisan key:generate`.
5. Run migrations and seed the database: `php artisan migrate --seed`.
6. Start the local development server: `php artisan serve`.

## Docker Setup

A `docker-compose.yml` file is included for full local development (PHP/Laravel, Nginx, MySQL).

1. Ensure Docker Desktop is installed.
2. Run `docker-compose up -d --build`.
3. The application will be served at `http://localhost:8000`.

## CI/CD Simulation

To run tests and static analysis automatically, you can set up a GitHub Actions workflow `.github/workflows/ci.yml`:

```yaml
name: CI

on: [push, pull_request]

jobs:
  test:
    runs-on: ubuntu-latest
    steps:
      - uses: actions/checkout@v2
      - name: Setup PHP
        uses: shivammathur/setup-php@v2
        with:
          php-version: '8.2'
          tools: phpstan
      - name: Install dependencies
        run: composer install -q --no-ansi --no-interaction --no-scripts --no-progress
      - name: PHPStan Analysis
        run: vendor/bin/phpstan analyse app tests
      - name: Execute tests via PHPUnit/Pest
        run: php artisan test
```

## Demo Credentials

- **Admin (Operations Manager)**
  - email: admin@glfts.com
  - password: password123
- **Dispatcher (Officer)**
  - email: dispatcher@glfts.com
  - password: password123

*(Note: In the demo seed, users are randomly generated, but you can create these specific accounts natively in UserSeeder)*

## API Documentation

API Documentation is generated via Scribe.
To view it, navigate to `/docs` or run `php artisan scribe:generate`.
