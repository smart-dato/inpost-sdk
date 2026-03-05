<?php

namespace Smartdato\InPost\Facades;

use Illuminate\Support\Facades\Facade;
use Smartdato\InPost\Resources\PickupsResource;
use Smartdato\InPost\Resources\PointsResource;
use Smartdato\InPost\Resources\ReturnsResource;
use Smartdato\InPost\Resources\ShippingResource;
use Smartdato\InPost\Resources\TrackingResource;

/**
 * @method static ShippingResource shipping()
 * @method static PointsResource points()
 * @method static TrackingResource tracking()
 * @method static ReturnsResource returns()
 * @method static PickupsResource pickups()
 * @method static \Smartdato\InPost\InPost make(array $config)
 *
 * @see \Smartdato\InPost\InPost
 */
class InPost extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Smartdato\InPost\InPost::class;
    }
}
