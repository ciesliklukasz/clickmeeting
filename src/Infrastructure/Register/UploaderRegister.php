<?php

declare(strict_types = 1);

namespace App\Infrastructure\Register;

use App\Domain\Uploader\UploaderInterface;
use App\Infrastructure\Enum\UploadServer;
use App\Infrastructure\Exception\UploadServerNotSupportedException;

class UploaderRegister
{
    /** @var UploaderInterface[] */
    private array $uploaders;

    public function register(UploaderInterface $uploader): void
    {
        if (false === isset($this->uploaders[$uploader->type()])) {
            $this->uploaders[$uploader->type()] = $uploader;
        }
    }

    /**
     * @param UploadServer $uploadServer
     * @return UploaderInterface
     * @throws UploadServerNotSupportedException
     */
    public function get(string $serverType): UploaderInterface
    {
        if (isset($this->uploaders[$serverType])) {
            return $this->uploaders[$serverType];
        }

        throw new UploadServerNotSupportedException($serverType . ' server not supported!');
    }
}
