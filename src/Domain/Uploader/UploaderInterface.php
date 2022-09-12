<?php

declare(strict_types = 1);

namespace App\Domain\Uploader;

use App\Domain\Model\Image;
use App\Infrastructure\Enum\UploadServer;

interface UploaderInterface
{
    public function upload(Image $image): void;
    public function type(): string;
}
