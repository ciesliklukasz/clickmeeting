<?php

declare(strict_types = 1);

namespace App\Domain\Factory;

use Imagine\Gd\Imagine;

class ImagineFactory
{
    public function createImagine(): Imagine
    {
        return new Imagine();
    }
}
