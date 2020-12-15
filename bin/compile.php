<?php

/**
 * This file is part of Json5 package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

use Phplrt\Compiler\Compiler;
use Phplrt\Source\File;

require __DIR__ . '/../vendor/autoload.php';

$assembly = (new Compiler())
    ->load(File::fromPathname(__DIR__ . '/../resources/grammar.pp2'))
    ->build()
    ->generate()
;

\file_put_contents(__DIR__ . '/../resources/grammar.php', $assembly);
