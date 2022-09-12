<?php

declare(strict_types = 1);

namespace Tests\Unit\Infrastructure\Factory;

use App\Infrastructure\Factory\FTPClientFactory;
use FtpClient\FtpClient;
use PHPUnit\Framework\TestCase;

class FTPClientFactoryTest extends TestCase
{
    public function testCreateClient(): void
    {
        $factory = new FTPClientFactory();

        self::assertInstanceOf(FtpClient::class, $factory->createClient());
    }
}
