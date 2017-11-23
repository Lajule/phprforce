<?php
declare(strict_types=1);

namespace PHPRForce;

use GuzzleHttp\Client;

final class Connexion
{
    private $client;
    private $config;

    public function __construct(array $config = [])
    {
        $this->client = new Client();
        $this->config = $config;
    }

    public function auth(): OAuth2
    {
        return new OAuth2($this->client, $this->config);
    }

    public function sobject(string $type): SObject
    {
        return new SObject($this->client, $this->config, $type);
    }

    public function apex(string $path): Apex
    {
        return new Apex($this->client, $this->config, $path);
    }

    public function query(): Query
    {
        return new Query($this->client, $this->config);
    }

    public function search(): Search
    {
        return new Search($this->client, $this->config);
    }

    public function batch(): Batch
    {
        return new Batch($this->client, $this->config);
    }

    public function chatter(string $resource): Chatter
    {
        return new Chatter($this->client, $this->config, $resource);
    }
}
