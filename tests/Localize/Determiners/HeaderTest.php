<?php

namespace BenConstable\Test\Localize\Determiners;

use Mockery;
use PHPUnit_Framework_TestCase;
use BenConstable\Localize\Determiners\Header;

class HeaderTest extends PHPUnit_Framework_TestCase
{
    private $header;
    private $fallback;
    private $determiner;

    public function setUp()
    {
        $this->header = 'Accept-Language';
        $this->fallback = 'de';
        $this->determiner = new Header($this->header, $this->fallback);
    }

    public function tearDown()
    {
        Mockery::close();
    }

    public function testDeterminesLocaleFromHeader()
    {
        $locale = 'en';

        $request = Mockery::mock('Illuminate\Http\Request');

        $request
            ->shouldReceive('header')
            ->with($this->header, $this->fallback)
            ->andReturn($locale);

        $result = $this->determiner->determineLocale($request);

        $this->assertEquals($result, $locale);
    }

    public function testReturnsFallbackLocaleIfNeeded()
    {
        $request = Mockery::mock('Illuminate\Http\Request');

        $request
            ->shouldReceive('header')
            ->with($this->header, $this->fallback)
            ->andReturn($this->fallback);

        $result = $this->determiner->determineLocale($request);

        $this->assertEquals($result, $this->fallback);
    }
}
