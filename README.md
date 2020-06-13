# phprforce

Interact with Salesforce from PHP

## Requirement

This library requires at least **PHP 7.1** because it uses some new features of
the language such as scalar type declarations or return type declarations. In
addition, HTTP requests are performed with [Guzzle][1].

## Installation

Add following lines to your `composer.json` file to use phprforce in your
project:

```json
{
    "repositories": [
        {
            "type": "vcs",
            "url": "https://github.com/Lajule/phprforce"
        }
    ],
    "require": {
        "lajule/phprforce": "dev-master"
    }
}
```

## Environment

This library uses the following environment variables:

Name | Value
---- | -----
CLIENT_ID | The client identifier of Salesforce connected app
CLIENT_SECRET | The client secret identifier of Salesforce connected app
LOGIN_URL | https://login.salesforce.com or https://test.salesforce.com
REDIRECT_URI | The callback URL to your server (if you use OAuth2::redirect())

## How to use

### Authentication

You have to obtain an OAuth 2.0 access token and interact with Salesforce REST
API.

#### oauth2.php

```php
<?php

$conn = new PHPRForce\Connexion();
$conn->auth()->redirect();
```

#### callback.php

```php
<?php

session_start();

$conn = new PHPRForce\Connexion();
$_SESSION['config'] = $conn->auth()->authorize($_GET['code']);
```

### Query

Fetches Salesforce records with SOQL queries.

#### accounts.php

```php
<?php

session_start();

$conn = new PHPRForce\Connexion($_SESSION['config']);
$accounts = $conn->query()->execute('SELECT Id, Name FROM Account');
```

### SObject

"CRUD" operations for records in Salesforce.

#### account.php

```php
<?php

session_start();

$conn = new PHPRForce\Connexion($_SESSION['config']);
$account = $conn->sobject('Account')->get($_GET['Id']);
```

### Apex

Calls Apex REST classes in Salesforce.

#### action.php

```php
<?php

session_start();

$conn = new PHPRForce\Connexion($_SESSION['config']);
$result = $conn->apex('/Action')->get();
```

### Search

Executes SOSL searches.

#### search.php

```php
<?php

session_start();

$conn = new PHPRForce\Connexion($_SESSION['config']);
$result = $conn->search()->get('FIND {Test}');
```

### Batch

Executes up to 25 requests.

#### batch.php

```php
<?php

session_start();

$conn = new PHPRForce\Connexion($_SESSION['config']);
$result = $conn->batch()->execute([
    'batchRequests' => [
        [
            'method' => 'GET',
            'url'    => "v29.0/sobjects/Account/{$_GET['Id']}"
        ]
    ]
]);
```

### Chatter

Access to Chatter API resources.

#### chatter.php

```php
<?php

session_start();

$conn = new PHPRForce\Connexion($_SESSION['config']);
$resource = $conn->chatter('/users/me')->retrieve();
```

[1]: https://github.com/guzzle/guzzle (Guzzle, an extensible PHP HTTP client)
