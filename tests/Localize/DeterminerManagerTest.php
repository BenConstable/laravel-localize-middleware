<?php

namespace Tests\BenConstable\Localize;

use Mockery;
use PHPUnit_Framework_TestCase;
use BenConstable\Localize\Determiners;
use BenConstable\Localize\DeterminerManager;

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

    /** @test **/
    public function create_a_cookie_determiner()
    {
        $manager = new DeterminerManager($this->app);

        $this->assertInstanceOf(Determiners\Cookie::class, $manager->driver('cookie'));
    }

    /** @test **/
    public function create_a_host_determiner()
    {
        $manager = new DeterminerManager($this->app);

        $this->assertInstanceOf(Determiners\Host::class, $manager->driver('host'));
    }

    /** @test **/
    public function create_a_parameter_determiner()
    {
        $manager = new DeterminerManager($this->app);

        $this->assertInstanceOf(Determiners\Parameter::class, $manager->driver('parameter'));
    }

    /** @test **/
    public function create_a_session_determiner()
    {
        $manager = new DeterminerManager($this->app);

        $this->assertInstanceOf(Determiners\Session::class, $manager->driver('session'));
    }

    /** @test **/
    public function create_a_header_determiner()
    {
        $manager = new DeterminerManager($this->app);

        $this->assertInstanceOf(Determiners\Header::class, $manager->driver('header'));
    }

    /** @test **/
    public function create_a_stack_determiner()
    {
        $manager = new DeterminerManager($this->app);

        $determiner = $manager->driver('stack');

        $this->assertInstanceOf(Determiners\Stack::class, $determiner);

        $this->assertCount(1, $determiner->getDeterminers());

        $this->assertInstanceOf(Determiners\Parameter::class, $determiner->getDeterminers()->first());
    }

    /** @test **/
    public function create_a_default_determiner()
    {
        $manager = new DeterminerManager($this->app);

        $this->assertInstanceOf(Determiners\DeterminerInterface::class, $manager->driver());
    }
}
