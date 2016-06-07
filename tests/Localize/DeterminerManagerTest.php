<?php

namespace BenConstable\Test\Localize;

use Mockery;
use PHPUnit_Framework_TestCase;
use BenConstable\Localize\DeterminerManager;
use BenConstable\Localize\Determiners;

class DeterminerManagerTest extends PHPUnit_Framework_TestCase
{
    private $app;

    public function setUp()
    {
        $this->app = [
            'config' => [
                'localize-middleware' => require(__DIR__ . '/../../src/config/localize-middleware.php'),
                'app' => [
                    'fallback_locale' => 'de'
                ]
            ]
        ];
    }

    public function tearDown()
    {
        Mockery::close();
    }

    public function testThatItCreatesACookieDeterminer()
    {
        $manager = new DeterminerManager($this->app);

        $this->assertInstanceOf(Determiners\Cookie::class, $manager->driver('cookie'));
    }

    public function testThatItCreatesAHostDeterminer()
    {
        $manager = new DeterminerManager($this->app);

        $this->assertInstanceOf(Determiners\Host::class, $manager->driver('host'));
    }

    public function testThatItCreatesAParameterDeterminer()
    {
        $manager = new DeterminerManager($this->app);

        $this->assertInstanceOf(Determiners\Parameter::class, $manager->driver('parameter'));
    }

    public function testThatItCreatesASessionDeterminer()
    {
        $manager = new DeterminerManager($this->app);

        $this->assertInstanceOf(Determiners\Session::class, $manager->driver('session'));
    }

    public function testThatItCreatesAHeaderDeterminer()
    {
        $manager = new DeterminerManager($this->app);

        $this->assertInstanceOf(Determiners\Header::class, $manager->driver('header'));
    }

    public function testThatItCreatesAStackDeterminer()
    {
        $manager = new DeterminerManager($this->app);

        $determiner = $manager->driver('stack');

        $this->assertInstanceOf(Determiners\Stack::class, $determiner);

        $this->assertCount(1, $determiner->getDeterminers());

        $this->assertInstanceOf(Determiners\Parameter::class, $determiner->getDeterminers()->first());
    }

    public function testThatItReturnsADefaultDeterminer()
    {
        $manager = new DeterminerManager($this->app);

        $this->assertInstanceOf(Determiners\DeterminerInterface::class, $manager->driver());
    }
}
