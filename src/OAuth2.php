<?php
declare(strict_types=1);
namespace PHPRForce;

use GuzzleHttp\Client;

final class OAuth2
{
    private $client;
    private $config;

    public function __construct(Client $client, array $config = [])
    {
        $this->client = $client;
        $this->config = $config;
    }

    public function redirect(): string
    {
        return getenv('LOGIN_URL').'/services/oauth2/authorize'
            .'?response_type=code'
            .'&client_id='.getenv('CLIENT_ID')
            .'&redirect_uri='.urlencode(getenv('REDIRECT_URI'));
    }

    public function authorize(string $code): array
    {
        $url = getenv('LOGIN_URL').'/services/oauth2/token';
        $form_params = [
            'code'          => $code,
            'grant_type'    => 'authorization_code',
            'client_id'     => getenv('CLIENT_ID'),
            'client_secret' => getenv('CLIENT_SECRET'),
            'redirect_uri'  => getenv('REDIRECT_URI')
        ];

        $response = $this->client->post($url, ['form_params' => $form_params]);

        return json_decode((string) $response->getBody(), true);
    }

    public function login(
        string $username,
        string $password,
        string $securityToken
    ): array {
        $url = getenv('LOGIN_URL').'/services/oauth2/token';
        $form_params = [
            'grant_type'    => 'password',
            'client_id'     => getenv('CLIENT_ID'),
            'client_secret' => getenv('CLIENT_SECRET'),
            'username'      => $username,
            'password'      => "$password$securityToken"
        ];

        $response = $this->client->post($url, ['form_params' => $form_params]);

        return json_decode((string) $response->getBody(), true);
    }

    public function refresh(): array
    {
        $url = getenv('LOGIN_URL').'/services/oauth2/token';
        $form_params = [
            'grant_type'    => 'refresh_token',
            'client_id'     => getenv('CLIENT_ID'),
            'client_secret' => getenv('CLIENT_SECRET'),
            'refresh_token' => $this->config['refresh_token']
        ];

        $response = $this->client->post($url, ['form_params' => $form_params]);

        return json_decode((string) $response->getBody(), true);
    }

    public function revoke(): void
    {
        $url = getenv('LOGIN_URL').'/services/oauth2/revoke';
        $form_params = ['token' => $this->config['access_token']];

        $this->client->post($url, ['form_params' => $form_params]);
    }

    public function identity(): array
    {
        $url = $this->config['id'];
        $headers = [
            'Authorization' => "Bearer {$this->config['access_token']}"
        ];

        $response = $this->client->get($url, ['headers' => $headers]);

        return json_decode((string) $response->getBody(), true);
    }
}
