<?php
declare(strict_types=1);

namespace PHPRForce;

use GuzzleHttp\Client;

final class SObject
{
    const API_VERSION = 'v20.0';

    private $client;
    private $config;
    private $type;

    public function __construct(Client $client, array $config, string $type)
    {
        $this->client = $client;
        $this->config = $config;
        $this->type = $type;
    }

    public function create(array $json): array
    {
        $url = $this->config['instance_url']
            . '/services/data/' . self::API_VERSION
            . "/sobjects/{$this->type}";
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

    public function get(string $id): array
    {
        $url = $this->config['instance_url']
            . '/services/data/' . self::API_VERSION
            . "/sobjects/{$this->type}/$id";
        $headers = [
            'Authorization' => "Bearer {$this->config['access_token']}"
        ];

        $response = $this->client->get($url, ['headers' => $headers]);

        return json_decode((string) $response->getBody(), TRUE);
    }

    public function update(string $id, array $json): void
    {
        $url = $this->config['instance_url']
            . '/services/data/' . self::API_VERSION
            . "/sobjects/{$this->type}/$id";
        $headers = [
            'Authorization' => "Bearer {$this->config['access_token']}"
        ];

        $this->client->patch($url, ['headers' => $headers, 'json' => $json]);
    }

    public function delete(string $id): void
    {
        $url = $this->config['instance_url']
            . '/services/data/' . self::API_VERSION
            . "/sobjects/{$this->type}/$id";
        $headers = [
            'Authorization' => "Bearer {$this->config['access_token']}"
        ];

        $this->client->delete($url, ['headers' => $headers]);
    }

    public function describe(): array
    {
        $url = $this->config['instance_url']
            . '/services/data/' . self::API_VERSION
            . "/sobjects/{$this->type}/describe";
        $headers = [
            'Authorization' => "Bearer {$this->config['access_token']}"
        ];
        $response = $this->client->get($url, ['headers' => $headers]);

        return json_decode((string) $response->getBody(), TRUE);
    }
}
