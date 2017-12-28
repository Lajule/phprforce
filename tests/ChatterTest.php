<?php
declare(strict_types=1);

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;

use PHPUnit\Framework\TestCase;

use PHPRForce\Chatter;

final class ChatterTest extends TestCase
{
    public function testShouldRetrieveResource(): void
    {
        $expected = ['Id' => 'ID'];

        $mock = new MockHandler(
            [
                new Response(200, [], json_encode($expected))
            ]
        );

        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);

        $chatter = new Chatter(
            $client,
            [
                'instance_url' => 'URL',
                'access_token' => 'ACCESS-TOKEN'
            ],
            '/RESOURCE'
        );

        $this->assertEquals($chatter->retrieve(), $expected);
    }

    public function testShouldCreateResource(): void
    {
        $expected = ['Id' => 'ID'];

        $mock = new MockHandler(
            [
                new Response(200, [], json_encode($expected))
            ]
        );

        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);

        $chatter = new Chatter(
            $client,
            [
                'instance_url' => 'URL',
                'access_token' => 'ACCESS-TOKEN'
            ],
            '/RESOURCE'
        );

        $this->assertEquals($chatter->create(['body' => 'BODY']), $expected);
    }
}
