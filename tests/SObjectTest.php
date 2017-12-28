<?php
declare(strict_types=1);

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Exception\RequestException;

use PHPUnit\Framework\TestCase;

use PHPRForce\SObject;

final class SObjectTest extends TestCase
{
    public function testShouldCreateObject(): void
    {
        $expected = ['Id' => 'ID'];

        $mock = new MockHandler(
            [
                new Response(200, [], json_encode($expected))
            ]
        );

        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);

        $sobject = new SObject(
            $client,
            [
                'instance_url' => 'URL',
                'access_token' => 'ACCESS-TOKEN'
            ],
            'OBJECT'
        );

        $this->assertEquals($sobject->create(['Name' => 'NAME']), $expected);
    }

    public function testShouldReturnObject(): void
    {
        $expected = ['Id' => 'ID'];

        $mock = new MockHandler(
            [
                new Response(200, [], json_encode($expected))
            ]
        );

        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);

        $sobject = new SObject(
            $client,
            [
                'instance_url' => 'URL',
                'access_token' => 'ACCESS-TOKEN'
            ],
            'OBJECT'
        );

        $this->assertEquals($sobject->get('ID'), $expected);
    }

    public function testShoulNotUpdateObject(): void
    {
        $this->expectException(RequestException::class);

        $mock = new MockHandler(
            [
                new RequestException(
                    'Update failed',
                    new Request('PATCH', 'patch')
                )
            ]
        );

        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);

        $sobject = new SObject(
            $client,
            [
                'instance_url' => 'URL',
                'access_token' => 'ACCESS-TOKEN'
            ],
            'OBJECT'
        );

        $sobject->update('ID', ['Name' => 'NAME']);
    }

    public function testShoulNotDeleteObject(): void
    {
        $this->expectException(RequestException::class);

        $mock = new MockHandler(
            [
                new RequestException(
                    'Delete failed',
                    new Request('DELETE', 'delete')
                )
            ]
        );

        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);

        $sobject = new SObject(
            $client,
            [
                'instance_url' => 'URL',
                'access_token' => 'ACCESS-TOKEN'
            ],
            'OBJECT'
        );

        $sobject->delete('ID');
    }

    public function testShouldReturnObjectDescription(): void
    {
        $expected = ['Id' => 'ID'];

        $mock = new MockHandler(
            [
                new Response(200, [], json_encode($expected))
            ]
        );

        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);

        $sobject = new SObject(
            $client,
            [
                'instance_url' => 'URL',
                'access_token' => 'ACCESS-TOKEN'
            ],
            'OBJECT'
        );

        $this->assertEquals($sobject->describe(), $expected);
    }
}
