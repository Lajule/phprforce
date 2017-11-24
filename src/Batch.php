<?php
declare(strict_types=1);
namespace PHPRForce;

use GuzzleHttp\Client;

final class Batch
{
    const API_VERSION = 'v34.0';

    private $client;
    private $config;

    public function __construct(Client $client, array $config)
    {
        $this->client = $client;
        $this->config = $config;
    }

    public function execute(array $json): array
    {
        $url = $this->config['instance_url']
            . '/services/data/' . self::API_VERSION . '/composite/batch';
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
}
