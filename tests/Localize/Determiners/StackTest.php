<?php

namespace Tests\BenConstable\Localize\Determiners;

use Mockery;
use PHPUnit_Framework_TestCase;
use Illuminate\Support\Collection;
use BenConstable\Localize\Determiners\Stack;
use BenConstable\Localize\Determiners\Cookie;
use BenConstable\Localize\Determiners\Session;
use BenConstable\Localize\Determiners\Parameter;

class StackTest extends PHPUnit_Framework_TestCase
{
    public function tearDown()
    {
        Mockery::close();
    }

    /** @test **/
    public function determine_locale()
    {
        $determiner = new Stack(new Collection([
            new Parameter('locale'),
            new Cookie('locale'),
            new Session('locale')
        ]));

        $request = $this->mockRequest([
            'parameter' => 'en',
            'cookie' => null,
            'session' => null
        ]);
        $result = $determiner->determineLocale($request);
        $this->assertEquals($result, 'en');

        $request = $this->mockRequest([
            'parameter' => null,
            'cookie' => 'fr',
            'session' => null
        ]);
        $result = $determiner->determineLocale($request);
        $this->assertEquals($result, 'fr');

        $request = $this->mockRequest([
            'parameter' => null,
            'cookie' => null,
            'session' => 'es'
        ]);
        $result = $determiner->determineLocale($request);
        $this->assertEquals($result, 'es');

        $request = $this->mockRequest([
            'parameter' => 'en',
            'cookie' => 'fr',
            'session' => null
        ]);
        $result = $determiner->determineLocale($request);
        $this->assertEquals($result, 'en');

        $request = $this->mockRequest([
            'parameter' => 'en',
            'cookie' => null,
            'session' => 'es'
        ]);
        $result = $determiner->determineLocale($request);
        $this->assertEquals($result, 'en');

        $request = $this->mockRequest([
            'parameter' => null,
            'cookie' => 'fr',
            'session' => 'es'
        ]);
        $result = $determiner->determineLocale($request);
        $this->assertEquals($result, 'fr');
    }

    /** @test **/
    public function fallback_if_no_locale_found()
    {
        $fallback = 'de';

        $determiner = (new Stack(new Collection([
            new Parameter('locale'),
            new Cookie('locale'),
            new Session('locale')
        ])))->setFallback($fallback);

        $request = $this->mockRequest([
            'parameter' => null,
            'cookie' => null,
            'session' => null
        ]);

        $result = $determiner->determineLocale($request);

        $this->assertEquals($result, $fallback);
    }

    private function mockRequest($results)
    {
        $request = Mockery::mock('Illuminate\Http\Request');
        $session = Mockery::mock('Illuminate\Session\Store');

        $request
            ->shouldReceive('session')
            ->andReturn($session);

        $request
            ->shouldReceive('input')
            ->with('locale', null)
            ->andReturn($results['parameter']);

        $request
            ->shouldReceive('cookie')
            ->with('locale', null)
            ->andReturn($results['cookie']);

        $session
            ->shouldReceive('get')
            ->with('locale', null)
            ->andReturn($results['session']);

        return $request;
    }
}
