<?php

declare(strict_types = 1);

namespace Tests\Unit\Infrastructure\Register;

use App\Domain\Uploader\UploaderInterface;
use App\Infrastructure\Exception\UploadServerNotSupportedException;
use App\Infrastructure\Register\UploaderRegister;
use PHPUnit\Framework\TestCase;

class UploaderRegisterTest extends TestCase
{
    private UploaderRegister $register;

    protected function setUp(): void
    {
        $this->register = new UploaderRegister();
    }

    public function testRegister(): void
    {
        $uploaderOne = $this->createMock(UploaderInterface::class);
        $uploaderOne->method('type')->willReturn('test1');

        $uploaderTwo = $this->createMock(UploaderInterface::class);
        $uploaderTwo->method('type')->willReturn('test2');

        $this->register->register($uploaderOne);
        $this->register->register($uploaderTwo);

        self::assertEquals($uploaderOne, $this->register->get('test1'));
        self::assertEquals($uploaderTwo, $this->register->get('test2'));
    }

    public function testGetNotRegiseredUploader(): void
    {
        $this->expectException(UploadServerNotSupportedException::class);

        $this->register->get('test');
    }
}
