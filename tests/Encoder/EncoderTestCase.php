<?php

/**
 * This file is part of json5 package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Serafim\Json5\Tests\Encoder;

use Serafim\Json5\Json5;
use Serafim\Json5\Json5DecoderInterface;
use Serafim\Json5\Tests\TestCase;

abstract class EncoderTestCase extends TestCase
{
    protected function decode(string $json, int $options = 0, int $depth = 512): mixed
    {
        return Json5::decode($json, $options, $depth);
    }
}
