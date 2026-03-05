<?php

/**
 * Integration tests against the InPost Stage API.
 *
 * These tests hit the real stage environment — run them manually:
 *   vendor/bin/pest --group=sandbox
 *
 * Stage credentials are committed for convenience (non-production).
 */

use Illuminate\Http\Client\Factory;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Smartdato\InPost\Data\Points\PointData;
use Smartdato\InPost\Data\Points\PointListData;
use Smartdato\InPost\Data\Shared\ContactData;
use Smartdato\InPost\Data\Shared\DimensionsData;
use Smartdato\InPost\Data\Shared\LocationData;
use Smartdato\InPost\Data\Shared\WeightData;
use Smartdato\InPost\Data\Shipping\CreateShipmentData;
use Smartdato\InPost\Data\Shipping\ParcelData;
use Smartdato\InPost\Data\Shipping\ShipmentData;
use Smartdato\InPost\InPost;

beforeEach(function () {
    // Replace the HTTP client with a fresh instance to remove TestCase fakes
    Http::swap(new Factory);
    // Clear cached tokens from previous tests
    Cache::flush();
});

const STAGE_SCOPE = 'api:points:read api:shipments:write api:shipments:read api:tracking:read';

const STAGE_CONFIG = [
    'client_id' => 'app-vv3yrr6bwm',
    'client_secret' => 'iuPaHP6WlSsj67yLoiJMhPSIE2QyveFRDsr24kfF',
    'organization_id' => '938a71e8-67fd-40f6-954f-117d33af372d',
    'scope' => STAGE_SCOPE,
    'token_url' => 'https://stage-api.inpost-group.com/oauth2/token',
    'shipping_url' => 'https://stage-api.inpost-group.com/shipping/v2',
    'points_url' => 'https://stage-api.inpost-group.com/location/v1',
    'tracking_url' => 'https://stage-api.inpost-group.com/tracking/v1',
    'returns_url' => 'https://stage-api.inpost-group.com/returns/v1',
];

function sandboxInPost(): InPost
{
    return InPost::make(STAGE_CONFIG);
}

function sandboxShipmentData(): CreateShipmentData
{
    return new CreateShipmentData(
        sender: new ContactData(
            firstName: 'Jan',
            lastName: 'Kowalski',
            email: 'jan@example.com',
            phone: '48600123456',
        ),
        recipient: new ContactData(
            firstName: 'Anna',
            lastName: 'Nowak',
            email: 'anna@example.com',
            phone: '48600654321',
        ),
        origin: new LocationData(
            countryCode: 'PL',
            street: 'Warszawska 12',
            city: 'Krakow',
            postalCode: '30-001',
            shippingMethod: 'COURIER',
            shippingMethods: ['COURIER'],
        ),
        destination: new LocationData(
            countryCode: 'PL',
            street: 'Nowy Swiat 10',
            city: 'Warszawa',
            postalCode: '00-001',
            shippingMethod: 'COURIER',
        ),
        parcels: [
            new ParcelData(
                type: 'STANDARD',
                dimensions: new DimensionsData(length: 200, width: 150, height: 100),
                weight: new WeightData(amount: 2.5),
            ),
        ],
    );
}

it('can obtain an OAuth token from the stage API', function () {
    $inpost = sandboxInPost();

    // Trigger authentication by making any request
    $result = $inpost->points()->list(['per_page' => 1]);

    expect($result)->toBeInstanceOf(PointListData::class);
})->group('sandbox');

it('can list points from the stage API', function () {
    $result = sandboxInPost()->points()->list(['per_page' => 5]);

    expect($result)
        ->toBeInstanceOf(PointListData::class)
        ->items->toBeArray()
        ->items->not->toBeEmpty();
})->group('sandbox');

it('can get a single point from the stage API', function () {
    // First list to get a valid point ID
    $list = sandboxInPost()->points()->list(['per_page' => 1]);
    $pointId = $list->items[0]->id;

    $result = sandboxInPost()->points()->get($pointId);

    expect($result)
        ->toBeInstanceOf(PointData::class)
        ->id->toBe($pointId);
})->group('sandbox');

it('can create a shipment on the stage API', function () {
    $result = sandboxInPost()->shipping()->create(sandboxShipmentData());

    expect($result)
        ->toBeInstanceOf(ShipmentData::class)
        ->trackingNumber->not->toBeEmpty();
})->group('sandbox');

it('can get a shipment from the stage API', function () {
    $inpost = sandboxInPost();

    $created = $inpost->shipping()->create(sandboxShipmentData());

    $result = $inpost->shipping()->get($created->trackingNumber);

    expect($result)
        ->toBeInstanceOf(ShipmentData::class)
        ->trackingNumber->toBe($created->trackingNumber);
})->group('sandbox');
