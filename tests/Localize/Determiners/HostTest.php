<?php

namespace Tests\BenConstable\Localize\Determiners;

use Mockery;
use PHPUnit_Framework_TestCase;
use BenConstable\Localize\Determiners\Host;
use Illuminate\Support\Collection;

class HostTest extends PHPUnit_Framework_TestCase
{
    private $determiner;

    public function setUp()
    {
        $this->determiner = (new Host(new Collection([
            'en' => 'en.example.host',
            'fr' => 'france.example.host'
        ])))->setFallback('de');
    }

    public function tearDown()
    {
        Mockery::close();
    }

    public function testDeterminesLocaleFromHost()
    {
        // One

        $request = Mockery::mock('Illuminate\Http\Request');

        $request
            ->shouldReceive('getHost')
            ->andReturn('france.example.host');

        $locale = $this->determiner->determineLocale($request);

        $this->assertEquals('fr', $locale);

        // Two

        $request = Mockery::mock('Illuminate\Http\Request');

        $request
            ->shouldReceive('getHost')
            ->andReturn('en.example.host');

        $locale = $this->determiner->determineLocale($request);

        $this->assertEquals('en', $locale);
    }

    public function testReturnsFallbackLocaleIfNeeded()
    {
        // One

        $request = Mockery::mock('Illuminate\Http\Request');

        $request
            ->shouldReceive('getHost')
            ->andReturn('other.example.host');

        $locale = $this->determiner->determineLocale($request);

        $this->assertEquals('de', $locale);

        // Two

        $determiner = (new Host(new Collection([])))->setFallback('es');

        $locale = $determiner->determineLocale($request);

        $this->assertEquals('es', $locale);
    }
}
