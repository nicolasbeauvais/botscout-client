<?php

namespace NicolasBeauvais\BotScout\Test;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use NicolasBeauvais\BotScout\BotScout;
use PHPUnit\Framework\TestCase;

class BotScoutTest extends TestCase
{
    /**
     * @var BotScout
     */
    protected static $botScout;

    public static function setUpBeforeClass()
    {
        parent::setUp();

        // Create a mock and queue two responses.
        $mock = new MockHandler([
            new Response(200, [], 'Y|MULTI|IP|11|MAIL|1|NAME|22'),
            new Response(200, [], 'N|MULTI|IP|0|MAIL|0|NAME|0'),
            new Response(200, [], 'Y|ALL|22|NAME'),
            new Response(200, [], 'Y|NAME|8'),
            new Response(200, [], 'Y|MAIL|14'),
            new Response(200, [], 'Y|IP|10'),
            new Response(200, [], '! Missing or Malformed Data - Halting.'),
        ]);

        $client = new Client(['handler' => HandlerStack::create($mock)]);

        self::$botScout = new BotScout($client, 'api_key');
    }

    public function test_multi_fail()
    {
        $response = self::$botScout->multi('name', 'email@test.com', '127.0.0.1');

        $this->assertTrue($response->getMatched());
        $this->assertFalse($response->isValid());
        $this->assertEquals('MULTI', $response->getType());
        $this->assertEquals(11, $response->getIp());
        $this->assertEquals(1, $response->getMail());
        $this->assertEquals(22, $response->getName());
    }

    public function test_multi()
    {
        $response = self::$botScout->multi('John Doe', 'email@test.com', '127.0.0.1');

        $this->assertFalse($response->getMatched());
        $this->assertTrue($response->isValid());
        $this->assertEquals('MULTI', $response->getType());
        $this->assertEquals(0, $response->getIp());
        $this->assertEquals(0, $response->getMail());
        $this->assertEquals(0, $response->getName());
    }

    public function test_all()
    {
        $response = self::$botScout->all('John Doe', 'email@test.com', '127.0.0.1');

        $this->assertTrue($response->getMatched());
        $this->assertFalse($response->isValid());
        $this->assertEquals('ALL', $response->getType());
        $this->assertEquals(22, $response->getAll());
        $this->assertEquals('NAME', $response->getEvaluation());
    }

    public function test_name()
    {
        $response = self::$botScout->name('John Doe');

        $this->assertTrue($response->getMatched());
        $this->assertFalse($response->isValid());
        $this->assertEquals('NAME', $response->getType());
        $this->assertEquals(8, $response->getName());
    }

    public function test_email()
    {
        $response = self::$botScout->mail('email@test.com');

        $this->assertTrue($response->getMatched());
        $this->assertFalse($response->isValid());
        $this->assertEquals('MAIL', $response->getType());
        $this->assertEquals(14, $response->getMail());
    }

    public function test_ip()
    {
        $response = self::$botScout->ip('127.0.0.1');

        $this->assertTrue($response->getMatched());
        $this->assertFalse($response->isValid());
        $this->assertEquals('IP', $response->getType());
        $this->assertEquals(10, $response->getIp());
    }

    public function test_error()
    {
        $this->expectException(\Exception::class);

        $response = self::$botScout->ip('127.0.0.1');
    }
}
