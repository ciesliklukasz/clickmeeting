<?php

declare(strict_types = 1);

namespace App\Infrastructure\Model\FTP;

final class Config
{
    public function __construct
    (
        public readonly string $host,
        public readonly string $login,
        public readonly string $password,
        public readonly string $path,
        public readonly int $port = 21
    )
    {}
}
