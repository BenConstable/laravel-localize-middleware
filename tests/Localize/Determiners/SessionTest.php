<?php

namespace Tests\BenConstable\Localize\Determiners;

use Mockery;
use PHPUnit_Framework_TestCase;
use BenConstable\Localize\Determiners\Session;

class SessionTest extends PHPUnit_Framework_TestCase
{
    public function tearDown()
    {
        Mockery::close();
    }

    /** @test **/
    public function determine_locale()
    {
        $locale = 'en';

        $request = Mockery::mock('Illuminate\Http\Request');
        $session = Mockery::mock('Illuminate\Session\Store');

        $request
            ->shouldReceive('session')
            ->andReturn($session);

        $session
            ->shouldReceive('get')
            ->with('locale', null)
            ->andReturn($locale);

        $result = (new Session('locale'))->determineLocale($request);

        $this->assertEquals($result, $locale);
    }

    /** @test **/
    public function fallback_if_no_locale_found()
    {
        $fallback = 'de';

        $request = Mockery::mock('Illuminate\Http\Request');
        $session = Mockery::mock('Illuminate\Session\Store');

        $request
            ->shouldReceive('session')
            ->andReturn($session);

        $session
            ->shouldReceive('get')
            ->with('locale', $fallback)
            ->andReturn($fallback);

        $result = (new Session('locale'))->setFallback($fallback)->determineLocale($request);

        $this->assertEquals($result, $fallback);
    }
}
