<?php

declare(strict_types = 1);

namespace App\Domain\Model;

use Assert\Assertion;

final class Image
{
    private const SUPPORTED_EXT = [
        'image/jpeg',
        'image/png',
    ];

    public function __construct(
        private readonly string $filename,
        private readonly string $extension,
        private readonly string $filePath,
        private readonly int $width,
        private readonly int $height
    )
    {
    }

    public function getFilename(): string
    {
        return $this->filename;
    }

    public function getExtension(): string
    {
        return $this->extension;
    }

    public function getFilePath(): string
    {
        return $this->filePath;
    }

    public function getWidth(): int
    {
        return $this->width;
    }

    public function getHeight(): int
    {
        return $this->height;
    }

    public static function create(string $filePath): self
    {
        Assertion::file($filePath);

        $baseName = basename($filePath);
        $imageSize = getimagesize($filePath);

        Assertion::inArray($imageSize['mime'], self::SUPPORTED_EXT);

        return new self(
            $baseName,
            $imageSize['mime'],
            $filePath,
            $imageSize[0],
            $imageSize[1]
        );
    }
}
