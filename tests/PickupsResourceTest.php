<?php

use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use Smartdato\InPost\Auth\InPostAuthenticator;
use Smartdato\InPost\Connectors\PickupsConnector;
use Smartdato\InPost\Data\Pickups\ContactPersonData;
use Smartdato\InPost\Data\Pickups\CreateOneTimePickupData;
use Smartdato\InPost\Data\Pickups\CutoffTimeData;
use Smartdato\InPost\Data\Pickups\OneTimePickupData;
use Smartdato\InPost\Data\Pickups\PickupTimeData;
use Smartdato\InPost\Data\Shared\AddressData;
use Smartdato\InPost\Resources\PickupsResource;

function pickupsResource(MockClient $mockClient): PickupsResource
{
    $auth = new InPostAuthenticator('test-id', 'test-secret', 'https://token.test', 'api:one-time-pickups:read');
    $connector = new PickupsConnector($auth, 'https://api.test/pickups/v1');
    $connector->withMockClient($mockClient);

    return new PickupsResource($connector, 'org-123');
}

it('can create a one-time pickup', function () {
    $mockClient = new MockClient([
        MockResponse::make(fixtureJson('Pickups/create-pickup'), 201),
    ]);

    $result = pickupsResource($mockClient)->create(new CreateOneTimePickupData(
        address: new AddressData(street: 'ul. Testowa', buildingNumber: '5', city: 'Warszawa', postalCode: '00-001', countryCode: 'PL'),
        contactPerson: new ContactPersonData(name: 'Jan Kowalski', email: 'jan@example.com', phone: '+48123456789'),
        pickupTime: new PickupTimeData(date: '2026-03-06', timeFrom: '10:00', timeTo: '14:00'),
        parcelCount: 3,
    ));

    expect($result)
        ->toBeInstanceOf(OneTimePickupData::class)
        ->id->toBe('pickup_789')
        ->status->toBe(\Smartdato\InPost\Enums\PickupStatus::REQUESTED);
});

it('can get a one-time pickup', function () {
    $mockClient = new MockClient([
        MockResponse::make(fixtureJson('Pickups/create-pickup')),
    ]);

    $result = pickupsResource($mockClient)->get('pickup_789');

    expect($result)
        ->toBeInstanceOf(OneTimePickupData::class)
        ->id->toBe('pickup_789');
});

it('can get cutoff time', function () {
    $mockClient = new MockClient([
        MockResponse::make(fixtureJson('Pickups/cutoff-time')),
    ]);

    $result = pickupsResource($mockClient)->cutoffTime('00-001');

    expect($result)
        ->toBeInstanceOf(CutoffTimeData::class)
        ->cutoffTime->toBe('15:00')
        ->pickupDate->toBe('2026-03-06');
});

it('can cancel a one-time pickup', function () {
    $mockClient = new MockClient([
        MockResponse::make(body: '', status: 204),
    ]);

    pickupsResource($mockClient)->cancel('pickup_789');

    $this->assertTrue(true);
});
