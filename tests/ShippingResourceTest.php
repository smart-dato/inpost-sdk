<?php

use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use Smartdato\InPost\Auth\InPostAuthenticator;
use Smartdato\InPost\Connectors\InPostConnector;
use Smartdato\InPost\Data\Shared\ContactData;
use Smartdato\InPost\Data\Shared\DimensionsData;
use Smartdato\InPost\Data\Shared\LabelData;
use Smartdato\InPost\Data\Shared\LocationData;
use Smartdato\InPost\Data\Shared\WeightData;
use Smartdato\InPost\Data\Shipping\CreateShipmentData;
use Smartdato\InPost\Data\Shipping\ParcelData;
use Smartdato\InPost\Data\Shipping\ShipmentData;
use Smartdato\InPost\Resources\ShippingResource;

function shippingResource(MockClient $mockClient): ShippingResource
{
    $auth = new InPostAuthenticator('test-id', 'test-secret', 'https://token.test', 'api:shipments:read');
    $connector = new InPostConnector($auth, 'https://api.test/shipping/v2');
    $connector->withMockClient($mockClient);

    return new ShippingResource($connector, 'org-123');
}

it('can create a shipment', function () {
    $mockClient = new MockClient([
        MockResponse::make(fixtureJson('Shipping/create-shipment'), 201),
    ]);

    $result = shippingResource($mockClient)->create(new CreateShipmentData(
        sender: new ContactData(name: 'Jan Kowalski', email: 'jan@example.com'),
        recipient: new ContactData(name: 'Anna Nowak', email: 'anna@example.com'),
        origin: new LocationData(pointId: 'KRA01A'),
        destination: new LocationData(pointId: 'WAW02B'),
        parcels: [
            new ParcelData(
                type: 'standardParcel',
                dimensions: new DimensionsData(length: 200, width: 150, height: 100),
                weight: new WeightData(amount: 2.5),
            ),
        ],
    ));

    expect($result)
        ->toBeInstanceOf(ShipmentData::class)
        ->id->toBe('ship_123')
        ->status->toBe('created')
        ->trackingNumber->toBe('6340012345678901234');
});

it('can get a shipment', function () {
    $mockClient = new MockClient([
        MockResponse::make(fixtureJson('Shipping/get-shipment')),
    ]);

    $result = shippingResource($mockClient)->get('6340012345678901234');

    expect($result)
        ->toBeInstanceOf(ShipmentData::class)
        ->status->toBe('in_transit')
        ->trackingNumber->toBe('6340012345678901234');
});

it('can get a shipment label', function () {
    $mockClient = new MockClient([
        MockResponse::make(body: 'PDF-CONTENT', status: 200, headers: ['Content-Type' => 'application/pdf']),
    ]);

    $result = shippingResource($mockClient)->label('6340012345678901234');

    expect($result)
        ->toBeInstanceOf(LabelData::class)
        ->content->toBe(base64_encode('PDF-CONTENT'))
        ->contentType->toBe('application/pdf');
});
