<?php

namespace BenConstable\Localize;

use Illuminate\Support\Manager;
use Illuminate\Support\Collection;
use BenConstable\Localize\Determiners;

/**
 * Manager class for the different locale determiners.
 */
class DeterminerManager extends Manager
{
    /**
     * Get a cookie determiner instance.
     *
     * @return  \BenConstable\Localize\Determiners\Cookie
     */
    protected function createCookieDriver()
    {
        $determiner = new Determiners\Cookie(
            $this->app['config']['localize-middleware']['cookie']
        );

        $determiner->setFallback($this->app['config']['app']['fallback_locale']);

        return $determiner;
    }

    /**
     * Get a host determiner instance.
     *
     * @return  \BenConstable\Localize\Determiners\Host
     */
    protected function createHostDriver()
    {
        $determiner = new Determiners\Host(
            new Collection($this->app['config']['localize-middleware']['hosts'])
        );

        $determiner->setFallback($this->app['config']['app']['fallback_locale']);

        return $determiner;
    }

    /**
     * Get a parameter determiner instance.
     *
     * @return  \BenConstable\Localize\Determiners\Parameter
     */
    protected function createParameterDriver()
    {
        $determiner = new Determiners\Parameter(
            $this->app['config']['localize-middleware']['parameter']
        );

        $determiner->setFallback($this->app['config']['app']['fallback_locale']);

        return $determiner;
    }

    /**
     * Get a header determiner instance.
     *
     * @return  \BenConstable\Localize\Determiners\Header
     */
    protected function createHeaderDriver()
    {
        $determiner = new Determiners\Header(
            $this->app['config']['localize-middleware']['header']
        );

        $determiner->setFallback($this->app['config']['app']['fallback_locale']);

        return $determiner;
    }

    /**
     * Get a session determiner instance.
     *
     * @return  \BenConstable\Localize\Determiners\Session
     */
    protected function createSessionDriver()
    {
        $determiner = new Determiners\Session(
            $this->app['config']['localize-middleware']['session']
        );

        $determiner->setFallback($this->app['config']['app']['fallback_locale']);

        return $determiner;
    }

    /**
     * Get a stack determiner instance.
     *
     * @return  \BenConstable\Localize\Determiners\Stack
     */
    protected function createStackDriver()
    {
        $determiners = (new Collection((array) $this->app['config']['localize-middleware']['driver']))
            ->filter(function ($driver) {
                return $driver !== 'stack';
            })
            ->map(function ($driver) {
                return $this->driver($driver)->setFallback(null);
            });

        return (new Determiners\Stack($determiners))
            ->setFallback($this->app['config']['app']['fallback_locale']);
    }

    /**
     * Get the default localize driver name.
     *
     * @return  string
     */
    public function getDefaultDriver()
    {
        $driver = $this->app['config']['localize-middleware']['driver'];

        return is_array($driver) ? 'stack' : $driver;
    }
}
