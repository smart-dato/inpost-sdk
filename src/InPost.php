<?php

namespace Smartdato\InPost;

use Smartdato\InPost\Auth\InPostAuthenticator;
use Smartdato\InPost\Connectors\PickupsConnector;
use Smartdato\InPost\Connectors\PointsConnector;
use Smartdato\InPost\Connectors\ReturnsConnector;
use Smartdato\InPost\Connectors\ShippingConnector;
use Smartdato\InPost\Connectors\TrackingConnector;
use Smartdato\InPost\Resources\PickupsResource;
use Smartdato\InPost\Resources\PointsResource;
use Smartdato\InPost\Resources\ReturnsResource;
use Smartdato\InPost\Resources\ShippingResource;
use Smartdato\InPost\Resources\TrackingResource;

class InPost
{
    private ?ShippingResource $shippingResource = null;

    private ?PointsResource $pointsResource = null;

    private ?TrackingResource $trackingResource = null;

    private ?ReturnsResource $returnsResource = null;

    private ?PickupsResource $pickupsResource = null;

    public function __construct(
        protected ShippingConnector $shippingConnector,
        protected PointsConnector $pointsConnector,
        protected TrackingConnector $trackingConnector,
        protected ReturnsConnector $returnsConnector,
        protected PickupsConnector $pickupsConnector,
        protected string $organizationId,
    ) {}

    /**
     * Build an instance manually without the service container.
     *
     * @param  array{
     *     client_id: string,
     *     client_secret: string,
     *     organization_id: string,
     *     token_url?: string,
     *     pickups_token_url?: string,
     *     shipping_url?: string,
     *     points_url?: string,
     *     tracking_url?: string,
     *     returns_url?: string,
     *     pickups_url?: string,
     * }  $config
     */
    public static function make(array $config): self
    {
        $tokenUrl = $config['token_url'] ?? 'https://api.inpost-group.com/oauth2/token';
        $pickupsTokenUrl = $config['pickups_token_url'] ?? 'https://account.inpost-group.com/oauth2/token';

        $mainAuth = new InPostAuthenticator(
            clientId: $config['client_id'],
            clientSecret: $config['client_secret'],
            tokenUrl: $tokenUrl,
            scope: 'api:shipments:read api:shipments:write api:points:read api:tracking:read api:returns:read api:returns:write',
        );

        $pickupsAuth = new InPostAuthenticator(
            clientId: $config['client_id'],
            clientSecret: $config['client_secret'],
            tokenUrl: $pickupsTokenUrl,
            scope: 'api:one-time-pickups:read api:one-time-pickups:write',
        );

        return new self(
            shippingConnector: new ShippingConnector($mainAuth, $config['shipping_url'] ?? null),
            pointsConnector: new PointsConnector($mainAuth, $config['points_url'] ?? null),
            trackingConnector: new TrackingConnector($mainAuth, $config['tracking_url'] ?? null),
            returnsConnector: new ReturnsConnector($mainAuth, $config['returns_url'] ?? null),
            pickupsConnector: new PickupsConnector($pickupsAuth, $config['pickups_url'] ?? null),
            organizationId: $config['organization_id'],
        );
    }

    public function shipping(): ShippingResource
    {
        return $this->shippingResource ??= new ShippingResource($this->shippingConnector, $this->organizationId);
    }

    public function points(): PointsResource
    {
        return $this->pointsResource ??= new PointsResource($this->pointsConnector);
    }

    public function tracking(): TrackingResource
    {
        return $this->trackingResource ??= new TrackingResource($this->trackingConnector);
    }

    public function returns(): ReturnsResource
    {
        return $this->returnsResource ??= new ReturnsResource($this->returnsConnector, $this->organizationId);
    }

    public function pickups(): PickupsResource
    {
        return $this->pickupsResource ??= new PickupsResource($this->pickupsConnector, $this->organizationId);
    }
}
