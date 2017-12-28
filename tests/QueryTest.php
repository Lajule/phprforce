<?php
declare(strict_types=1);

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;

use PHPUnit\Framework\TestCase;

use PHPRForce\Query;

final class QueryTest extends TestCase
{
    public function testShouldExecuteQuery(): void
    {
        $expected = ['done' => true];

        $mock = new MockHandler(
            [
                new Response(200, [], json_encode($expected))
            ]
        );

        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);

        $query = new Query(
            $client,
            [
                'instance_url' => 'URL',
                'access_token' => 'ACCESS-TOKEN'
            ]
        );

        $this->assertEquals($query->execute('QUERY'), $expected);
    }

    public function testShouldReturnNextRecords(): void
    {
        $expected = ['done' => true];

        $mock = new MockHandler(
            [
                new Response(200, [], json_encode($expected))
            ]
        );

        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);

        $query = new Query(
            $client,
            [
                'instance_url' => 'URL',
                'access_token' => 'ACCESS-TOKEN'
            ]
        );

        $this->assertEquals($query->nextRecords('URL'), $expected);
    }
}
