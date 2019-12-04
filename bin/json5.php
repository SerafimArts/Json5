<?php

/**
 * This file is part of json5 package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

use Composer\Autoload\ClassLoader;
use Serafim\Json5\Console\CompileCommand;
use Symfony\Component\Console\Application;

/*
|--------------------------------------------------------------------------
| Register The Auto Loader
|--------------------------------------------------------------------------
|
| Composer provides a convenient, automatically generated class loader
| for our application. We just need to utilize it! We'll require it
| into the script here so that we do not have to worry about the
| loading of any our classes "manually". Feels great to relax.
|
*/

$paths = [
    __DIR__ . '/../vendor/autoload.php',
    __DIR__ . '/../../autoload.php',
    __DIR__ . '/../../../autoload.php',
];


foreach ($paths as $path) {
    if (is_file($path) && is_readable($path)) {
        /**
         * @noinspection PhpIncludeInspection
         * @var ClassLoader $classLoader
         */
        $classLoader = require $path;
        break;
    }
}


if (! isset($classLoader) || ! $classLoader) {
    throw new LogicException(
        <<<'ERROR_MESSAGE'
Could not find autoload.php file.
You need to set up the project dependencies using Composer:

    composer install

You can learn all about Composer on https://getcomposer.org/
ERROR_MESSAGE
    );
}

//
// phpstorm bugfix
//
if (isset($argv[1]) && $argv[1] === '-V') {
    exit('Symfony version 3.0.0');
}

/*
|--------------------------------------------------------------------------
| Create The Application
|--------------------------------------------------------------------------
|
| The first thing we will do is create a new Railt Application instance
| which serves as the "glue" for all the components of Railt, and is
| the dependency injection container for the system binding all of the
| various parts.
|
*/


$app = new Application();
$app->add(new CompileCommand());

/*
|--------------------------------------------------------------------------
| Run The Console Application
|--------------------------------------------------------------------------
|
| When we run the console application, the current CLI command will be
| executed in this console and the response sent back to a terminal
| or another output device for the developers. Here goes nothing!
|
*/

exit($app->run());


