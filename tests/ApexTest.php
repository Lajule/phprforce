<?php
declare(strict_types=1);

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Exception\RequestException;

use PHPUnit\Framework\TestCase;

use PHPRForce\Apex;

final class ApexTest extends TestCase
{
    public function testShouldCallGetMethod(): void
    {
        $expected = ['field' => 'FIELD'];

        $mock = new MockHandler([
            new Response(200, [], json_encode($expected))
        ]);

        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);

        $apex = new Apex(
            $client,
            [
                'instance_url' => 'URL',
                'access_token' => 'ACCESS-TOKEN'
            ],
            '/PATH'
        );

        $this->assertEquals($apex->get(), $expected);
    }

    public function testShouldCallPostMethod(): void
    {
        $expected = ['field' => 'FIELD'];

        $mock = new MockHandler([
            new Response(200, [], json_encode($expected))
        ]);

        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);

        $apex = new Apex(
            $client,
            [
                'instance_url' => 'URL',
                'access_token' => 'ACCESS-TOKEN'
            ],
            '/PATH'
        );

        $this->assertEquals($apex->post(['param' => 'PARAM']), $expected);
    }

    public function testShoulNotCallPutMethod(): void
    {
        $this->expectException(RequestException::class);

        $mock = new MockHandler([
            new RequestException('PUT failed', new Request('PUT', 'put'))
        ]);

        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);

        $apex = new Apex(
            $client,
            [
                'instance_url' => 'URL',
                'access_token' => 'ACCESS-TOKEN'
            ],
            '/PATH'
        );

        $apex->put(['param' => 'PARAM']);
    }

    public function testShoulNotCallPatchMethod(): void
    {
        $this->expectException(RequestException::class);

        $mock = new MockHandler([
            new RequestException('PATCH failed', new Request('PATCH', 'patch'))
        ]);

        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);

        $apex = new Apex(
            $client,
            [
                'instance_url' => 'URL',
                'access_token' => 'ACCESS-TOKEN'
            ],
            '/PATH'
        );

        $apex->patch(['param' => 'PARAM']);
    }

    public function testShoulNotCallDeletehMethod(): void
    {
        $this->expectException(RequestException::class);

        $mock = new MockHandler([
            new RequestException(
                'DELETE failed',
                new Request('DELETE', 'delete')
            )
        ]);

        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);

        $apex = new Apex(
            $client,
            [
                'instance_url' => 'URL',
                'access_token' => 'ACCESS-TOKEN'
            ],
            '/PATH'
        );

        $apex->delete();
    }
}
