<?php

declare(strict_types = 1);

namespace App\Domain\Service;

use App\Domain\Model\Config;
use App\Domain\Model\Image;
use Imagine\Gd\Imagine;
use Imagine\Image\Box;
use Ramsey\Uuid\Uuid;

class ImageResizerService
{
    private const RESIZED_FILE_EXT = '.png';
    private const TMP_PATH = __DIR__ . '/../../../tmp/';
    private const RESIZED_PATH = __DIR__ . '/../../../var/resized/';

    public function __construct
    (
        private Imagine $imagine
    )
    {
    }

    public function resize(Image $image, Config $config): Image
    {
        $openedImg = $this->imagine->open($image->getFilePath());
        $openedImg->resize(new Box($config->width, $config->height));

        $tmpFile = $this->getTmpFile();
        $openedImg->save($tmpFile);

        if ($config->saveLocal) {
            copy($tmpFile, self::RESIZED_PATH . basename($tmpFile));
        }

        return Image::create($tmpFile);
    }

    private function getTmpFile(): string
    {
        $resizedImgName = Uuid::uuid4();
        $tmpPath = $this->getTmpPath();

        return $tmpPath . $resizedImgName . self::RESIZED_FILE_EXT;
    }

    private function getTmpPath(): string
    {
        if (false === file_exists(self::TMP_PATH)) {
            mkdir(self::TMP_PATH, 0777, true);
        }

        return self::TMP_PATH;
    }
}
