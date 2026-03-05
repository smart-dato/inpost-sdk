# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

Laravel package (`smart-dato/inpost-sdk`) providing an InPost API SDK. Built with Spatie's laravel-package-tools. Requires PHP 8.4+ and Laravel 11/12.

## Commands

```bash
composer test              # Run tests (Pest 4)
composer test -- --filter=TestName  # Run a single test
composer analyse           # Static analysis (PHPStan level 5)
composer format            # Code formatting (Laravel Pint)
composer test-coverage     # Tests with coverage
```

## Architecture

- **Namespace:** `Smartdato\InPost`
- **Service Provider:** `InPostServiceProvider` registers 5 domain connectors + `InPost` as singletons
- **Facade:** `Smartdato\InPost\Facades\InPost` resolves `Smartdato\InPost\InPost`
- **Config:** `config/inpost-sdk.php` — `client_id`, `client_secret`, `organization_id`, `token_url`, `pickups_token_url`, `base_urls.*`
- **Auth:** `InPostAuthenticator` in `src/Auth/` — custom `Saloon\Contracts\Authenticator`, OAuth2 Client Credentials via Laravel `Http`, token cached in Laravel Cache
- **Connectors:** Abstract `InPostConnector` in `src/Connectors/`, 5 concrete connectors (Shipping, Points, Tracking, Returns, Pickups)
- **Factory:** `InPost::make(array $config)` — build instance with custom credentials without the service container
- **Resources:** `src/Resources/` — public API surface: `InPost::shipping()`, `InPost::points()`, etc.
- **Requests:** `src/Requests/{Domain}/` — Saloon requests extending `Saloon\Http\Request`
- **DTOs:** Spatie Laravel Data in `src/Data/{Domain}/` and `src/Data/Shared/`
- **Enums:** `src/Enums/` — PointType, WeightUnit, DimensionUnit, LabelFormat, PickupStatus, PointCapability
- **Exceptions:** `src/Exceptions/` — InPostApiException (RFC 7807), InPostValidationException, InPostNotFoundException
- **Tests:** Pest 4 using Orchestra Testbench with Saloon MockClient and JSON fixtures in `tests/Fixtures/`
- **PHPStan:** Level 5, analyzes `src/` and `config/`, baseline in `phpstan-baseline.neon`
