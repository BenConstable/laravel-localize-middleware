<?php

namespace Tests\BenConstable\Localize\Determiners;

use Mockery;
use PHPUnit_Framework_TestCase;
use BenConstable\Localize\Determiners\Host;
use Illuminate\Support\Collection;

class HostTest extends PHPUnit_Framework_TestCase
{
    public function tearDown()
    {
        Mockery::close();
    }

    /** @test **/
    public function determine_locale()
    {
        $determiner = new Host(new Collection([
            'en' => 'en.example.host',
            'fr' => 'france.example.host'
        ]));

        $request = Mockery::mock('Illuminate\Http\Request');
        $request->shouldReceive('getHost')->andReturn('france.example.host');
        $locale = $determiner->determineLocale($request);
        $this->assertEquals('fr', $locale);

        $request = Mockery::mock('Illuminate\Http\Request');
        $request->shouldReceive('getHost')->andReturn('en.example.host');
        $locale = $determiner->determineLocale($request);
        $this->assertEquals('en', $locale);
    }

    /** @test **/
    public function fallback_if_no_locale_found()
    {
        $determiner = (new Host(new Collection()))->setFallback('de');

        $request = Mockery::mock('Illuminate\Http\Request');
        $request->shouldReceive('getHost')->andReturn('other.example.host');
        $locale = $determiner->determineLocale($request);
        $this->assertEquals('de', $locale);
    }
}
