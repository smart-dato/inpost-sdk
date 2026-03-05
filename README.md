# InPost SDK for Laravel

[![Latest Version on Packagist](https://img.shields.io/packagist/v/smart-dato/inpost-sdk.svg?style=flat-square)](https://packagist.org/packages/smart-dato/inpost-sdk)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/smart-dato/inpost-sdk/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/smart-dato/inpost-sdk/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/smart-dato/inpost-sdk/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/smart-dato/inpost-sdk/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/smart-dato/inpost-sdk.svg?style=flat-square)](https://packagist.org/packages/smart-dato/inpost-sdk)

A Laravel SDK for the InPost API, covering Shipping, Points, Tracking, Returns, and One-Time Pickups. Built with [Saloon v3](https://docs.saloon.dev) and [Spatie Laravel Data](https://spatie.be/docs/laravel-data).

## Requirements

- PHP 8.4+
- Laravel 11 or 12

## Installation

```bash
composer require smart-dato/inpost-sdk
```

Publish the config file:

```bash
php artisan vendor:publish --tag="inpost-sdk-config"
```

## Configuration

Add the following to your `.env` file:

```env
INPOST_CLIENT_ID=your-client-id
INPOST_CLIENT_SECRET=your-client-secret
INPOST_ORGANIZATION_ID=your-organization-id
```

For staging environments, override the token and base URLs:

```env
INPOST_TOKEN_URL=https://stage-api.inpost-group.com/oauth2/token
INPOST_SHIPPING_URL=https://stage-api.inpost-group.com/shipping/v2
INPOST_POINTS_URL=https://stage-api.inpost-group.com/location/v1
INPOST_TRACKING_URL=https://stage-api.inpost-group.com/tracking/v1
INPOST_RETURNS_URL=https://stage-api.inpost-group.com/returns/v1
INPOST_PICKUPS_URL=https://stage-api.inpost.pl/pickups/v1
INPOST_PICKUPS_TOKEN_URL=https://stage-account.inpost-group.com/oauth2/token
```

Published config (`config/inpost-sdk.php`):

```php
return [
    'client_id' => env('INPOST_CLIENT_ID', ''),
    'client_secret' => env('INPOST_CLIENT_SECRET', ''),
    'organization_id' => env('INPOST_ORGANIZATION_ID', ''),
    'token_url' => env('INPOST_TOKEN_URL', 'https://api.inpost-group.com/oauth2/token'),
    'pickups_token_url' => env('INPOST_PICKUPS_TOKEN_URL', 'https://account.inpost-group.com/oauth2/token'),
    'base_urls' => [
        'shipping' => env('INPOST_SHIPPING_URL', 'https://api.inpost-group.com/shipping/v2'),
        'points'   => env('INPOST_POINTS_URL', 'https://api.inpost-group.com/location/v1'),
        'tracking' => env('INPOST_TRACKING_URL', 'https://api.inpost-group.com/tracking/v1'),
        'returns'  => env('INPOST_RETURNS_URL', 'https://api.inpost-group.com/returns/v1'),
        'pickups'  => env('INPOST_PICKUPS_URL', 'https://api.inpost.pl/pickups/v1'),
    ],
];
```

## Usage

Access the SDK via the `InPost` facade or by injecting `Smartdato\InPost\InPost`.

### Shipping

```php
use Smartdato\InPost\Facades\InPost;
use Smartdato\InPost\Data\Shipping\CreateShipmentData;
use Smartdato\InPost\Data\Shipping\SenderData;
use Smartdato\InPost\Data\Shipping\RecipientData;
use Smartdato\InPost\Data\Shipping\OriginData;
use Smartdato\InPost\Data\Shipping\DestinationData;
use Smartdato\InPost\Data\Shipping\ParcelData;
use Smartdato\InPost\Data\Shared\DimensionsData;
use Smartdato\InPost\Data\Shared\WeightData;
use Smartdato\InPost\Enums\LabelFormat;

// Create a shipment
$shipment = InPost::shipping()->create(new CreateShipmentData(
    sender: new SenderData(name: 'Jan Kowalski', email: 'jan@example.com', phone: '+48123456789'),
    recipient: new RecipientData(name: 'Anna Nowak', email: 'anna@example.com', phone: '+48987654321'),
    origin: new OriginData(pointId: 'KRA01A'),
    destination: new DestinationData(pointId: 'WAW02B'),
    parcels: [
        new ParcelData(
            type: 'standardParcel',
            dimensions: new DimensionsData(length: 200, width: 150, height: 100),
            weight: new WeightData(amount: 2.5),
        ),
    ],
));

echo $shipment->trackingNumber; // "6340012345678901234"

// Get a shipment
$shipment = InPost::shipping()->get('6340012345678901234');

// Get a shipment label (PDF or ZPL)
$label = InPost::shipping()->label('6340012345678901234', LabelFormat::PDF);
echo $label->contentType; // "application/pdf"
// $label->content contains the base64-encoded label
```

### Points

```php
use Smartdato\InPost\Facades\InPost;

// List points with optional filters
$points = InPost::points()->list(['type' => 'APM', 'city' => 'Krakow']);

foreach ($points->items as $point) {
    echo "{$point->id} — {$point->name}\n";
}

// Get a specific point
$point = InPost::points()->get('KRA01A');
echo $point->coordinates->latitude;

// Search by location
$nearby = InPost::points()->searchByLocation(
    latitude: 50.0647,
    longitude: 19.945,
    distance: 5000, // meters
);
```

### Tracking

```php
use Smartdato\InPost\Facades\InPost;

// Track up to 10 parcels at once
$result = InPost::tracking()->track(['6340012345678901234', '6340098765432101234']);

foreach ($result->parcels as $parcel) {
    echo "{$parcel->trackingNumber}: {$parcel->status}\n";

    foreach ($parcel->events as $event) {
        echo "  [{$event->datetime}] {$event->description}\n";
    }
}
```

### Returns

```php
use Smartdato\InPost\Facades\InPost;
use Smartdato\InPost\Data\Returns\CreateReturnShipmentData;

// Create a return shipment
$return = InPost::returns()->create(new CreateReturnShipmentData(
    senderName: 'Anna Nowak',
    senderEmail: 'anna@example.com',
    senderPhone: '+48987654321',
    originPointId: 'WAW02B',
    destinationPointId: 'KRA01A',
    reference: 'RET-2026-001',
));

echo $return->trackingNumber;

// Get a return shipment
$return = InPost::returns()->get('ret_456');

// Get a return label
$label = InPost::returns()->label('ret_456');
```

### Pickups

```php
use Smartdato\InPost\Facades\InPost;
use Smartdato\InPost\Data\Pickups\CreateOneTimePickupData;
use Smartdato\InPost\Data\Pickups\ContactPersonData;
use Smartdato\InPost\Data\Pickups\PickupTimeData;
use Smartdato\InPost\Data\Shared\AddressData;

// Create a one-time pickup
$pickup = InPost::pickups()->create(new CreateOneTimePickupData(
    address: new AddressData(
        street: 'ul. Testowa',
        buildingNumber: '5',
        city: 'Warszawa',
        postalCode: '00-001',
        countryCode: 'PL',
    ),
    contactPerson: new ContactPersonData(
        name: 'Jan Kowalski',
        email: 'jan@example.com',
        phone: '+48123456789',
    ),
    pickupTime: new PickupTimeData(
        date: '2026-03-06',
        timeFrom: '10:00',
        timeTo: '14:00',
    ),
    parcelCount: 3,
));

echo $pickup->id;

// List pickups
$pickups = InPost::pickups()->list();

// Get a pickup
$pickup = InPost::pickups()->get('pickup_789');

// Cancel a pickup
InPost::pickups()->cancel('pickup_789');

// Check cutoff time for a postal code
$cutoff = InPost::pickups()->cutoffTime('00-001');
echo "Order by {$cutoff->cutoffTime} for pickup on {$cutoff->pickupDate}";
```

## Error Handling

The SDK throws typed exceptions for API errors:

```php
use Smartdato\InPost\Exceptions\InPostApiException;
use Smartdato\InPost\Exceptions\InPostValidationException;
use Smartdato\InPost\Exceptions\InPostNotFoundException;

try {
    $shipment = InPost::shipping()->get('invalid-tracking-number');
} catch (InPostNotFoundException $e) {
    // 404 — resource not found
    echo $e->getMessage();
} catch (InPostValidationException $e) {
    // 400 — validation errors
    echo $e->detail;
    foreach ($e->errors as $field => $messages) {
        echo "$field: " . implode(', ', $messages) . "\n";
    }
} catch (InPostApiException $e) {
    // Other API errors (RFC 7807 problem details)
    echo $e->title;
    echo $e->detail;
    echo $e->response->status();
}
```

## Authentication

The SDK uses OAuth2 Client Credentials flow. Tokens are automatically cached in Laravel's cache store and refreshed when expired. No manual token management is needed.

### Using Different Credentials

You can create an SDK instance with custom credentials on the fly using `InPost::make()`, bypassing the service container entirely. This is useful for multi-tenant applications or when you need to connect to different InPost accounts:

```php
use Smartdato\InPost\InPost;

$client = InPost::make([
    'client_id' => 'other-client-id',
    'client_secret' => 'other-client-secret',
    'organization_id' => 'other-org-id',
]);

// Use it like normal
$shipment = $client->shipping()->create($data);
$points = $client->points()->list();
```

You can also override URLs (e.g. for staging):

```php
$client = InPost::make([
    'client_id' => 'staging-client-id',
    'client_secret' => 'staging-client-secret',
    'organization_id' => 'staging-org-id',
    'token_url' => 'https://stage-api.inpost-group.com/oauth2/token',
    'shipping_url' => 'https://stage-api.inpost-group.com/shipping/v2',
    'points_url' => 'https://stage-api.inpost-group.com/location/v1',
    'tracking_url' => 'https://stage-api.inpost-group.com/tracking/v1',
    'returns_url' => 'https://stage-api.inpost-group.com/returns/v1',
    'pickups_url' => 'https://stage-api.inpost.pl/pickups/v1',
    'pickups_token_url' => 'https://stage-account.inpost-group.com/oauth2/token',
]);
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [SmartDato](https://github.com/smart-dato)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
