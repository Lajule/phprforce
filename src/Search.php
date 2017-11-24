<?php
declare(strict_types=1);
namespace PHPRForce;

use GuzzleHttp\Client;

final class Search
{
    const API_VERSION = 'v37.0';

    private $client;
    private $config;

    public function __construct(Client $client, array $config)
    {
        $this->client = $client;
        $this->config = $config;
    }

    public function execute(string $q): array
    {
        $url = $this->config['instance_url']
            .'/services/data/'.self::API_VERSION.'/search';
        $headers = [
            'Authorization' => "Bearer {$this->config['access_token']}"
        ];

        $response = $this->client->get(
            $url,
            [
                'headers' => $headers,
                'query'   => ['q' => $q]
            ]
        );

        return json_decode((string) $response->getBody(), true);
    }
}
