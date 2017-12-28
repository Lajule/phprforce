<?php
declare(strict_types=1);

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;

use PHPUnit\Framework\TestCase;

use PHPRForce\Batch;

final class BatchTest extends TestCase
{
    public function testShouldExecuteBatch(): void
    {
        $expected = ['hasErrors' => false];

        $mock = new MockHandler(
            [
                new Response(200, [], json_encode($expected))
            ]
        );

        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);

        $batch = new Batch(
            $client,
            [
                'instance_url' => 'URL',
                'access_token' => 'ACCESS-TOKEN'
            ]
        );

        $this->assertEquals(
            $batch->execute(['batchRequests' => 'REQUESTS']),
            $expected
        );
    }
}
