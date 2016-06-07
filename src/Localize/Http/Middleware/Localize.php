<?php

namespace BenConstable\Localize\Http\Middleware;

use Closure;
use Illuminate\Foundation\Application;
use BenConstable\Localize\DeterminerManager;

/**
 * This middleware localizes the application using the configured
 * locale determiner.
 */
class Localize
{
    /**
     * Laravel application.
     *
     * @var  \Illuminate\Foundation\Application
     */
    private $app;

    /**
     * Application localizer.
     *
     * @var  \BenConstable\Localize\DeterminerManager
     */
    private $determinerManager;

    /**
     * Constructor.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @param  \BenConstable\Localize\DeterminerManager  $determinerManager
     * @return  void
     */
    public function __construct(
        Application $app,
        DeterminerManager $determinerManager
    ) {
        $this->app = $app;
        $this->determinerManager = $determinerManager;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return  mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        $locale = $this->determinerManager->determineLocale($request);

        $this->app->setLocale($locale);

        return $next($request);
    }
}
