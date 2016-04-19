<?php

namespace BenConstable\Test\Localize\Determiners;

use Mockery;
use PHPUnit_Framework_TestCase;
use BenConstable\Localize\Determiners\Parameter;

class ParameterTest extends PHPUnit_Framework_TestCase
{
    private $requestParameter;
    private $fallback;
    private $determiner;

    public function setUp()
    {
        $this->requestParameter = 'locale';
        $this->fallback = 'de';
        $this->determiner = new Parameter($this->requestParameter, $this->fallback);
    }

    public function tearDown()
    {
        Mockery::close();
    }

    public function testDeterminesLocaleFromRequestParameter()
    {
        $locale = 'en';

        $request = Mockery::mock('Illuminate\Http\Request');

        $request
            ->shouldReceive('input')
            ->with($this->requestParameter, $this->fallback)
            ->andReturn($locale);

        $result = $this->determiner->determineLocale($request);

        $this->assertEquals($result, $locale);
    }

    public function testReturnsFallbackLocaleIfNeeded()
    {
        $request = Mockery::mock('Illuminate\Http\Request');

        $request
            ->shouldReceive('input')
            ->with($this->requestParameter, $this->fallback)
            ->andReturn($this->fallback);

        $result = $this->determiner->determineLocale($request);

        $this->assertEquals($result, $this->fallback);
    }
}
