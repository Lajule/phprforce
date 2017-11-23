<?php
declare(strict_types=1);

namespace PHPRForce;

use GuzzleHttp\Client;

final class Chatter
{
    const API_VERSION = 'v41.0';

    private $client;
    private $config;
    private $resource;

    public function __construct(Client $client, array $config, string $resource)
    {
        $this->client = $client;
        $this->config = $config;
        $this->resource = $resource;
    }

    public function retrieve(array $query = []): array
    {
        $url = $this->config['instance_url']
            . '/services/data/' . self::API_VERSION . '/chatter'
            . $this->resource;
        $headers = [
            'Authorization' => "Bearer {$this->config['access_token']}"
        ];

        $response = $this->client->get(
            $url,
            [
                'headers' => $headers,
                'query'   => $query
            ]
        );

        return json_decode((string) $response->getBody(), TRUE);
    }

    public function create(array $json): array
    {
        $url = $this->config['instance_url']
            . '/services/data/' . self::API_VERSION . '/chatter'
            . $this->resource;
        $headers = [
            'Authorization' => "Bearer {$this->config['access_token']}"
        ];

        $response = $this->client->post(
            $url,
            [
                'headers' => $headers,
                'json'    => $json
            ]
        );

        return json_decode((string) $response->getBody(), TRUE);
    }
}
