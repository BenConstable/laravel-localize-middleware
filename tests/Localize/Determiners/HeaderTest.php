<?php

namespace Tests\BenConstable\Localize\Determiners;

use Mockery;
use PHPUnit_Framework_TestCase;
use BenConstable\Localize\Determiners\Header;

class HeaderTest extends PHPUnit_Framework_TestCase
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

        $request
            ->shouldReceive('header')
            ->with('Accept-Language', null)
            ->andReturn($locale);

        $result = (new Header('Accept-Language'))->determineLocale($request);

        $this->assertEquals($result, $locale);
    }

    /** @test **/
    public function fallback_if_no_locale_found()
    {
        $fallback = 'de';

        $request = Mockery::mock('Illuminate\Http\Request');

        $request
            ->shouldReceive('header')
            ->with('Accept-Language', $fallback)
            ->andReturn($fallback);

        $result = (new Header('Accept-Language'))->setFallback($fallback)->determineLocale($request);

        $this->assertEquals($result, $fallback);
    }
}
