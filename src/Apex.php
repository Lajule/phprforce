<?php
declare(strict_types=1);
namespace PHPRForce;

use GuzzleHttp\Client;

final class Apex
{
    private $client;
    private $config;
    private $path;

    public function __construct(Client $client, array $config, string $path)
    {
        $this->client = $client;
        $this->config = $config;
        $this->path = $path;
    }

    public function get(array $query = []): array
    {
        $url = "{$this->config['instance_url']}/services/apexrest{$this->path}";
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

        return json_decode((string) $response->getBody(), true);
    }

    public function post(array $json = []): array
    {
        $url = "{$this->config['instance_url']}/services/apexrest{$this->path}";
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

        return json_decode((string) $response->getBody(), true);
    }

    public function put(array $json = []): void
    {
        $url = "{$this->config['instance_url']}/services/apexrest{$this->path}";
        $headers = [
            'Authorization' => "Bearer {$this->config['access_token']}"
        ];

        $this->client->put($url, ['headers' => $headers, 'json' => $json]);
    }

    public function patch(array $json = []): void
    {
        $url = "{$this->config['instance_url']}/services/apexrest{$this->path}";
        $headers = [
            'Authorization' => "Bearer {$this->config['access_token']}"
        ];

        $this->client->patch($url, ['headers' => $headers, 'json' => $json]);
    }

    public function delete(array $query = []): void
    {
        $url = "{$this->config['instance_url']}/services/apexrest{$this->path}";
        $headers = [
            'Authorization' => "Bearer {$this->config['access_token']}"
        ];

        $this->client->delete($url, ['headers' => $headers, 'query' => $query]);
    }
}
