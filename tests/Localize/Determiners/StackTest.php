<?php

namespace BenConstable\Test\Localize\Determiners;

use Mockery;
use PHPUnit_Framework_TestCase;
use Illuminate\Support\Collection;
use BenConstable\Localize\Determiners\Stack;
use BenConstable\Localize\Determiners\Cookie;
use BenConstable\Localize\Determiners\Session;
use BenConstable\Localize\Determiners\Parameter;

class StackTest extends PHPUnit_Framework_TestCase
{
    private $fallback;
    private $stack;
    private $determiner;

    public function setUp()
    {
        $this->fallback = 'de';

        $this->stack = new Collection([
            new Parameter('locale'),
            new Cookie('locale'),
            new Session('locale')
        ]);

        $this->determiner = (new Stack($this->stack))->setFallback($this->fallback);
    }

    public function tearDown()
    {
        Mockery::close();
    }

    public function testDeterminesLocaleFromStack()
    {
        $request = $this->mockRequest([
            'parameter' => 'en',
            'cookie' => null,
            'session' => null
        ]);
        $result = $this->determiner->determineLocale($request);
        $this->assertEquals($result, 'en');

        $request = $this->mockRequest([
            'parameter' => null,
            'cookie' => 'fr',
            'session' => null
        ]);
        $result = $this->determiner->determineLocale($request);
        $this->assertEquals($result, 'fr');

        $request = $this->mockRequest([
            'parameter' => null,
            'cookie' => null,
            'session' => 'es'
        ]);
        $result = $this->determiner->determineLocale($request);
        $this->assertEquals($result, 'es');

        $request = $this->mockRequest([
            'parameter' => 'en',
            'cookie' => 'fr',
            'session' => null
        ]);
        $result = $this->determiner->determineLocale($request);
        $this->assertEquals($result, 'en');

        $request = $this->mockRequest([
            'parameter' => 'en',
            'cookie' => null,
            'session' => 'es'
        ]);
        $result = $this->determiner->determineLocale($request);
        $this->assertEquals($result, 'en');

        $request = $this->mockRequest([
            'parameter' => null,
            'cookie' => 'fr',
            'session' => 'es'
        ]);
        $result = $this->determiner->determineLocale($request);
        $this->assertEquals($result, 'fr');
    }

    public function testUsesFallbackIfNothingFoundInStack()
    {
        $request = $this->mockRequest([
            'parameter' => null,
            'cookie' => null,
            'session' => null
        ]);
        $result = $this->determiner->determineLocale($request);
        $this->assertEquals($result, 'de');
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
