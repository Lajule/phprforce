<?php
declare(strict_types=1);

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;

use PHPUnit\Framework\TestCase;

use PHPRForce\OAuth2;

final class OAuth2Test extends TestCase
{
    public function testShouldReturnAccessTokenFromCode(): void
    {
        $expected = ['access_token' => 'ACCESS-TOKEN'];

        $mock = new MockHandler([
            new Response(200, [], json_encode($expected))
        ]);

        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);

        $auth = new OAuth2($client);

        $this->assertEquals($auth->authorize('CODE'), $expected);
    }

    public function testShouldReturnAccessTokenFromPassword(): void
    {
        $expected = ['access_token' => 'ACCESS-TOKEN'];

        $mock = new MockHandler([
            new Response(200, [], json_encode($expected))
        ]);

        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);

        $auth = new OAuth2($client);

        $this->assertEquals(
            $auth->authorize('USERNAME', 'PASSWORD', 'SECURITY-TOKEN'),
            $expected
        );
    }

    public function testShouldRefreshAccessToken(): void
    {
        $expected = ['access_token' => 'ACCESS-TOKEN'];

        $mock = new MockHandler([
            new Response(200, [], json_encode($expected))
        ]);

        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);

        $auth = new OAuth2($client, ['refresh_token' => 'REFRESH-TOKEN']);

        $this->assertEquals($auth->refresh(), $expected);
    }

    public function testShouldRevokehAccessToken(): void
    {
        $mock = new MockHandler([new Response(200, [], '')]);

        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);

        $auth = new OAuth2($client, ['access_token' => 'ACCESS-TOKEN']);

        $auth->revoke();
        $this->assertTRUE(true);
    }

    public function testShouldReturnIdentity(): void
    {
        $expected = ['user_id' => 'ID'];

        $mock = new MockHandler([
            new Response(200, [], json_encode($expected))
        ]);

        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);

        $auth = new OAuth2(
            $client,
            [
                'access_token' => 'ACCESS-TOKEN',
                'id'           => 'URL'
            ]
        );

        $this->assertEquals($auth->identity(), $expected);
    }
}
