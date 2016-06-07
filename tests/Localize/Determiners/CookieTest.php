<?php

namespace BenConstable\Test\Localize\Determiners;

use Mockery;
use PHPUnit_Framework_TestCase;
use BenConstable\Localize\Determiners\Cookie;

class CookieTest extends PHPUnit_Framework_TestCase
{
    private $cookieName;
    private $fallback;
    private $determiner;

    public function setUp()
    {
        $this->cookieName = 'locale';
        $this->fallback = 'de';
        $this->determiner = (new Cookie($this->cookieName))->setFallback($this->fallback);
    }

    public function tearDown()
    {
        Mockery::close();
    }

    public function testDeterminesLocaleFromCookie()
    {
        $locale = 'en';

        $request = Mockery::mock('Illuminate\Http\Request');

        $request
            ->shouldReceive('cookie')
            ->with($this->cookieName, $this->fallback)
            ->andReturn($locale);

        $result = $this->determiner->determineLocale($request);

        $this->assertEquals($result, $locale);
    }

    public function testReturnsFallbackLocaleIfNeeded()
    {
        $request = Mockery::mock('Illuminate\Http\Request');

        $request
            ->shouldReceive('cookie')
            ->with($this->cookieName, $this->fallback)
            ->andReturn($this->fallback);

        $result = $this->determiner->determineLocale($request);

        $this->assertEquals($result, $this->fallback);
    }
}
