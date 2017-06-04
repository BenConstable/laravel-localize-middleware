<?php

namespace Tests\BenConstable\Localize\Determiners;

use Mockery;
use PHPUnit_Framework_TestCase;
use BenConstable\Localize\Determiners\Session;

class SessionTest extends PHPUnit_Framework_TestCase
{
    private $sessionKey;
    private $fallback;
    private $determiner;

    public function setUp()
    {
        $this->sessionKey = 'locale';
        $this->fallback = 'de';
        $this->determiner = (new Session($this->sessionKey))->setFallback($this->fallback);
    }

    public function tearDown()
    {
        Mockery::close();
    }

    public function testDeterminesLocaleFromSession()
    {
        $locale = 'en';

        $request = Mockery::mock('Illuminate\Http\Request');

        $session = Mockery::mock('Illuminate\Session\Store');

        $request
            ->shouldReceive('session')
            ->andReturn($session);

        $session
            ->shouldReceive('get')
            ->with($this->sessionKey, $this->fallback)
            ->andReturn($locale);

        $result = $this->determiner->determineLocale($request);

        $this->assertEquals($result, $locale);
    }

    public function testReturnsFallbackLocaleIfNeeded()
    {
        $request = Mockery::mock('Illuminate\Http\Request');

        $session = Mockery::mock('Illuminate\Session\Store');

        $request
            ->shouldReceive('session')
            ->andReturn($session);

        $session
            ->shouldReceive('get')
            ->with($this->sessionKey, $this->fallback)
            ->andReturn($this->fallback);

        $result = $this->determiner->determineLocale($request);

        $this->assertEquals($result, $this->fallback);
    }
}
