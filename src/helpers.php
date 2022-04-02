<?php

/**
 * This file is part of json5 package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

use JetBrains\PhpStorm\ExpectedValues;
use JetBrains\PhpStorm\Language;
use Serafim\Json5\Exception\Json5Exception;
use Serafim\Json5\Json5;
use Serafim\Json5\DecodeFlag;
use Serafim\Json5\EncodeFlag;

// Enable DbC handling
if (\class_exists(\Serafim\Contracts\Runtime::class)) {
    \Serafim\Contracts\Runtime::listen('Serafim\\Json5\\');
}

if (! function_exists('json5_decode')) {
    /**
     * Decodes a JSON5 string.
     *
     * This is a helper function of the original {@see DecodeFlag::decode()}
     * implementation based on a signature compatible with the {@see json_decode()}
     * PHP function.
     *
     * @param string $json
     * @param bool $assoc
     * @param positive-int $depth
     * @param int-mask-of<DecodeFlag::JSON5_*> $options
     * @return mixed
     * @throws Json5Exception
     * @throws Throwable
     */
    function json5_decode(
        #[Language('JSON5')] string $json,
        bool $assoc = false,
        int $depth = Json5::DEFAULT_JSON5_DEPTH,
        #[ExpectedValues(flagsFromClass: DecodeFlag::class)] int $options = 0
    ): mixed {
        if ($assoc) {
            $options |= \JSON_OBJECT_AS_ARRAY;
        }

        return Json5::decode($json, $options, $depth);
    }
}

if (! function_exists('json5_encode')) {
    /**
     * Returns the JSON5 representation of a value.
     *
     * This is a helper function of the original {@see EncodeFlag::encode()}
     * implementation based on a signature compatible with the {@see json_encode()}
     * PHP function.
     *
     * @param mixed $value
     * @param int-mask-of<EncodeFlag::JSON5_*> $options
     * @param positive-int $depth
     * @return string
     * @throws Json5Exception
     */
    function json5_encode(
        mixed $value,
        #[ExpectedValues(flagsFromClass: EncodeFlag::class)] int $options = 0,
        int $depth = Json5::DEFAULT_JSON5_DEPTH,
    ): string {
        return Json5::encode($value, $options, $depth);
    }
}
