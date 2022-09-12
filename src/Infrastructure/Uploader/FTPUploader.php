<?php

declare(strict_types = 1);

namespace App\Infrastructure\Uploader;

use App\Domain\Model\Image;
use App\Domain\Uploader\UploaderInterface;
use App\Infrastructure\Enum\UploadServer;
use App\Infrastructure\Exception\FTP\InvalidDestinationPathException;
use App\Infrastructure\Model\FTP\Config;
use FtpClient\FtpClient;

final class FTPUploader implements UploaderInterface
{
    public function __construct
    (
        private FtpClient $ftp,
        private Config $config
    )
    {
        $this->ftp->connect($this->config->host, false, $this->config->port)
            ->login($this->config->login, $this->config->password);
    }

    public function upload(Image $image): void
    {
        $directory = $this->config->path;
        if (false === $this->ftp->mkdir($directory, true)) {
            throw new InvalidDestinationPathException('Cannot store file in path: ' . $directory);
        }

        $this->ftp->pasv(true);
        $this->ftp->put($directory . $image->getFilename(), $image->getFilePath(), FTP_ASCII);
    }

    public function type(): string
    {
        return UploadServer::FTP->value;
    }
}
