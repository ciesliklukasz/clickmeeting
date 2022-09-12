<?php

declare(strict_types = 1);

namespace App\Infrastructure\Factory;

use FtpClient\FtpClient;

class FTPClientFactory
{
    public function createClient(): FtpClient
    {
        return new FtpClient();
    }
}
