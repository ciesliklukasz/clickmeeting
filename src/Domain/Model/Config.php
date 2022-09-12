<?php

declare(strict_types = 1);

namespace App\Domain\Model;

use App\Infrastructure\Enum\UploadServer;
use Assert\Assertion;
use Symfony\Component\Console\Input\InputInterface;

class Config
{
    public function __construct
    (
        public readonly int $width,
        public readonly int $height,
        public UploadServer $server,
        public readonly bool $saveLocal
    )
    {
    }

    public static function fromCommandInput(InputInterface $input): self
    {
        Assertion::greaterOrEqualThan((int) $input->getArgument('width'), 150);
        Assertion::greaterOrEqualThan((int) $input->getArgument('height'), 150);
        Assertion::notBlank($input->getArgument('server'));

        return new self(
            (int) $input->getArgument('width'),
            (int) $input->getArgument('height'),
            UploadServer::from(strtolower($input->getArgument('server'))),
            $input->getOption('save-local')
        );
    }
}
