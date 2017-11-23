<?php
declare(strict_types=1);

namespace PHPRForce;

use GuzzleHttp\Client;

final class Query
{
    const API_VERSION = 'v29.0';

    private $client;
    private $config;

    public function __construct(Client $client, array $config)
    {
        $this->client = $client;
        $this->config = $config;
    }

    public function execute(string $q, bool $all = FALSE): array
    {
        $url = $this->config['instance_url']
            . '/services/data/' . self::API_VERSION
            . ($all ? '/queryAll' : '/query');
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

        return json_decode((string) $response->getBody(), TRUE);
    }

    public function nextRecords(string $nextRecordsUrl): array
    {
        $url = $this->config['instance_url'] . $nextRecordsUrl;
        $headers = [
            'Authorization' => "Bearer {$this->config['access_token']}"
        ];

        $response = $this->client->get($url, ['headers' => $headers]);

        return json_decode((string) $response->getBody(), TRUE);
    }
}
