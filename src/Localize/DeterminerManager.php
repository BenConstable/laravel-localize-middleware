<?php

namespace BenConstable\Localize;

use Illuminate\Support\Manager;
use BenConstable\Localize\Determiners\Cookie as CookieDeterminer;
use BenConstable\Localize\Determiners\Host as HostDeterminer;
use BenConstable\Localize\Determiners\Parameter as ParameterDeterminer;
use BenConstable\Localize\Determiners\Session as SessionDeterminer;

/**
 * Manager class for the different locale determiners.
 */
class DeterminerManager extends Manager
{
    /**
     * Get a cookie determiner instance.
     *
     * @return \BenConstable\Localize\Determiners\Cookie
     */
    protected function createCookieDriver()
    {
        return new CookieDeterminer(
            $this->app['config']['localize-middleware']['cookie'],
            $this->app['config']['app']['fallback_locale']
        );
    }

    /**
     * Get a host determiner instance.
     *
     * @return \BenConstable\Localize\Determiners\Host
     */
    protected function createHostDriver()
    {
        return new HostDeterminer(
            collect($this->app['config']['localize-middleware']['hosts']),
            $this->app['config']['app']['fallback_locale']
        );
    }

    /**
     * Get a parameter determiner instance.
     *
     * @return \BenConstable\Localize\Determiners\Parameter
     */
    protected function createParameterDriver()
    {
        return new ParameterDeterminer(
            $this->app['config']['localize-middleware']['parameter'],
            $this->app['config']['app']['fallback_locale']
        );
    }

    /**
     * Get a session determiner instance.
     *
     * @return \BenConstable\Localize\Determiners\Session
     */
    protected function createSessionDriver()
    {
        return new SessionDeterminer(
            $this->app['config']['localize-middleware']['session'],
            $this->app['config']['app']['fallback_locale']
        );
    }

    /**
     * Get the default localize driver name.
     *
     * @return string
     */
    public function getDefaultDriver()
    {
        return $this->app['config']['localize-middleware']['driver'];
    }
}
