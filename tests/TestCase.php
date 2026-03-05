<?php

namespace Smartdato\InPost\Tests;

use Illuminate\Support\Facades\Http;
use Orchestra\Testbench\TestCase as Orchestra;
use Smartdato\InPost\InPostServiceProvider;
use Spatie\LaravelData\LaravelDataServiceProvider;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        Http::fake([
            '*/oauth2/token' => Http::response([
                'access_token' => 'test-access-token',
                'token_type' => 'Bearer',
                'expires_in' => 3600,
            ]),
            '*token*' => Http::response([
                'access_token' => 'test-access-token',
                'token_type' => 'Bearer',
                'expires_in' => 3600,
            ]),
        ]);
    }

    protected function getPackageProviders($app)
    {
        return [
            LaravelDataServiceProvider::class,
            InPostServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        config()->set('inpost-sdk.client_id', 'test-client-id');
        config()->set('inpost-sdk.client_secret', 'test-client-secret');
        config()->set('inpost-sdk.organization_id', 'test-org-id');
        config()->set('data.max_transformation_depth', null);
        config()->set('data.throw_when_max_transformation_depth_reached', false);
    }
}
