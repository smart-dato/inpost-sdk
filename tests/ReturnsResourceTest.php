<?php

use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use Smartdato\InPost\Auth\InPostAuthenticator;
use Smartdato\InPost\Connectors\ReturnsConnector;
use Smartdato\InPost\Data\Returns\CreateReturnShipmentData;
use Smartdato\InPost\Data\Returns\ReturnShipmentData;
use Smartdato\InPost\Resources\ReturnsResource;

function returnsResource(MockClient $mockClient): ReturnsResource
{
    $auth = new InPostAuthenticator('test-id', 'test-secret', 'https://token.test', 'api:returns:read');
    $connector = new ReturnsConnector($auth, 'https://api.test/returns/v1');
    $connector->withMockClient($mockClient);

    return new ReturnsResource($connector, 'org-123');
}

it('can create a return shipment', function () {
    $mockClient = new MockClient([
        MockResponse::make(fixtureJson('Returns/create-return'), 201),
    ]);

    $result = returnsResource($mockClient)->create(new CreateReturnShipmentData(
        senderName: 'Anna Nowak',
        senderEmail: 'anna@example.com',
        senderPhone: '+48987654321',
        originPointId: 'WAW02B',
        destinationPointId: 'KRA01A',
        reference: 'RET-2026-001',
    ));

    expect($result)
        ->toBeInstanceOf(ReturnShipmentData::class)
        ->id->toBe('ret_456')
        ->status->toBe('created')
        ->trackingNumber->toBe('6340098765432101234');
});

it('can get a return shipment', function () {
    $mockClient = new MockClient([
        MockResponse::make(fixtureJson('Returns/create-return')),
    ]);

    $result = returnsResource($mockClient)->get('ret_456');

    expect($result)
        ->toBeInstanceOf(ReturnShipmentData::class)
        ->id->toBe('ret_456');
});
