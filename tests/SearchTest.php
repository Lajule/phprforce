<?php
declare(strict_types=1);

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;

use PHPUnit\Framework\TestCase;

use PHPRForce\Search;

final class SearchTest extends TestCase
{
    public function testShouldReturnSearchResults(): void
    {
        $expected = ['searchRecords' => 'RECORDS'];

        $mock = new MockHandler(
            [
                new Response(200, [], json_encode($expected))
            ]
        );

        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);

        $search = new Search(
            $client,
            [
                'instance_url' => 'URL',
                'access_token' => 'ACCESS-TOKEN'
            ]
        );

        $this->assertEquals($search->execute('Q'), $expected);
    }
}
