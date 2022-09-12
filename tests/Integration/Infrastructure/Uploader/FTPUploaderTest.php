<?php

declare(strict_types = 1);

namespace Tests\Integration\Infrastructure\Uploader;

use App\Domain\Model\Image;
use App\Infrastructure\Model\FTP\Config;
use App\Infrastructure\Uploader\FTPUploader;
use FtpClient\FtpClient;
use PHPUnit\Framework\TestCase;

class FTPUploaderTest extends TestCase
{
    public function testUpload(): void
    {
        $path = getenv('FTP_PATH_TEST');
        $config = new Config(
            getenv('FTP_HOST'),
            getenv('FTP_LOGIN'),
            getenv('FTP_PASSWORD'),
            $path,
            (int) getenv('FTP_PORT')
        );
        $image = Image::create(__DIR__ . '/../../../../var/images/nosacz.jpeg');
        $client = new FtpClient();

        $uploader = new FTPUploader($client, $config);
        $uploader->upload($image);

        self::assertCount(1, $client->scanDir($path));

        $client->rmdir($path);
    }
}
