<?php

namespace BenConstable\Test\Localize;

use Mockery;
use PHPUnit_Framework_TestCase;
use BenConstable\Localize\DeterminerManager;
use BenConstable\Localize\Determiners\DeterminerInterface;
use BenConstable\Localize\Determiners\Cookie as CookieDeterminer;
use BenConstable\Localize\Determiners\Host as HostDeterminer;
use BenConstable\Localize\Determiners\Parameter as ParameterDeterminer;
use BenConstable\Localize\Determiners\Header as HeaderDeterminer;
use BenConstable\Localize\Determiners\Session as SessionDeterminer;
use BenConstable\Localize\Determiners\Stack as StackDeterminer;

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

        $this->assertInstanceOf(CookieDeterminer::class, $manager->driver('cookie'));
    }

    public function testThatItCreatesAHostDeterminer()
    {
        $manager = new DeterminerManager($this->app);

        $this->assertInstanceOf(HostDeterminer::class, $manager->driver('host'));
    }

    public function testThatItCreatesAParameterDeterminer()
    {
        $manager = new DeterminerManager($this->app);

        $this->assertInstanceOf(ParameterDeterminer::class, $manager->driver('parameter'));
    }

    public function testThatItCreatesASessionDeterminer()
    {
        $manager = new DeterminerManager($this->app);

        $this->assertInstanceOf(SessionDeterminer::class, $manager->driver('session'));
    }

    public function testThatItCreatesAHeaderDeterminer()
    {
        $manager = new DeterminerManager($this->app);

        $this->assertInstanceOf(HeaderDeterminer::class, $manager->driver('header'));
    }

    public function testThatItCreatesAStackDeterminer()
    {
        $manager = new DeterminerManager($this->app);

        $determiner = $manager->driver('stack');

        $this->assertInstanceOf(StackDeterminer::class, $determiner);

        $this->assertCount(1, $determiner->getDeterminers());

        $this->assertInstanceOf(ParameterDeterminer::class, $determiner->getDeterminers()->first());
    }

    public function testThatItReturnsADefaultDeterminer()
    {
        $manager = new DeterminerManager($this->app);

        $this->assertInstanceOf(DeterminerInterface::class, $manager->driver());
    }
}
