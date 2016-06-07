<?php

namespace BenConstable\Localize;

use Illuminate\Support\Facades\Facade;

/**
 * Facade for BenConstable\Localize\DeterminerManager.
 */
class DeterminerFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return  string
     */
    public static function getFacadeAccessor()
    {
        return DeterminerManager::class;
    }
}
