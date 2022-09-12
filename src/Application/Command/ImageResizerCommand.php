<?php

declare(strict_types = 1);

namespace App\Application\Command;

use App\Domain\Model\Config;
use App\Domain\Model\Image;
use App\Domain\Service\ImageResizerService;
use App\Infrastructure\Register\UploaderRegister;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Throwable;

#[AsCommand(
    name: 'image:resize',
    description: 'Resize provided image. ',
    aliases: ['app:image-resize'],
    hidden: false
)]
class ImageResizerCommand extends Command
{
    public function __construct(
       private ImageResizerService $resizer,
       private UploaderRegister $register
    )
    {
        parent::__construct();
    }

    public function configure(): void
    {
        $this->setDefinition([
            new InputArgument('image-path', InputArgument::REQUIRED, 'Path to image to resize'),
            new InputArgument('width', InputArgument::REQUIRED, 'New image width'),
            new InputArgument('height', InputArgument::REQUIRED, 'New image height'),
            new InputArgument('server', InputArgument::REQUIRED, "Server type to store resized image"),
            new InputOption('save-local', null, InputOption::VALUE_NONE, 'Save new image also on local machine')
        ]);
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $filePath = $input->getArgument('image-path');

        try {
            $config = Config::fromCommandInput($input);
            $img = Image::create($filePath);

            $resizedImg = $this->resizer->resize($img, $config);

            $this->register->get($config->server->value)->upload($resizedImg);

            $message = sprintf(
                '%s resized file saved on %s server ',
                $resizedImg->getFilename(),
                $config->server->value
            );

            $output->writeln($message . PHP_EOL);
        } catch (Throwable $e) {
            $output->write($e->getMessage() . PHP_EOL);
        }

        return 0;
    }
}
