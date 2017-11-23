<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;

use PHPRForce\Apex;
use PHPRForce\Batch;
use PHPRForce\Chatter;
use PHPRForce\Connexion;
use PHPRForce\OAuth2;
use PHPRForce\Query;
use PHPRForce\Search;
use PHPRForce\SObject;

final class ConnexionTest extends TestCase
{
    public function testShouldReturnClasses(): void
    {
        $conn = new Connexion();

        $this->assertInstanceOf(OAuth2::class, $conn->auth());
        $this->assertInstanceOf(Query::class, $conn->query());
        $this->assertInstanceOf(SObject::class, $conn->sobject('OBJECT'));
        $this->assertInstanceOf(Search::class, $conn->search());
        $this->assertInstanceOf(Apex::class, $conn->apex('/PATH'));
        $this->assertInstanceOf(Batch::class, $conn->batch());
        $this->assertInstanceOf(Chatter::class, $conn->chatter('/RESOURCE'));
    }
}
