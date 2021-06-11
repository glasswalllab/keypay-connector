<?php

namespace Glasswalllab\WiiseConnector;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Glasswalllab\WiiseConnector\Skeleton\SkeletonClass
 */
class KeypayConnectorFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'keypayconnector';
    }
}
