<?php

/**
 * This file is part of Immutable package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

use Serafim\Json5\Exception\Json5Exception;
use Serafim\Json5\Json5;

if (! function_exists('json5_decode')) {
    /**
     * Decodes a JSON5 string.
     *
     * @see \Serafim\Json5\Json5DecoderInterface::decode()
     *
     * @param string $json
     * @param bool $assoc
     * @param int $depth
     * @param int $options
     * @return mixed
     * @throws Json5Exception
     * @throws Throwable
     */
    function json5_decode(string $json, bool $assoc = false, int $depth = 512, int $options = 0)
    {
        if ($assoc) {
            $options |= \JSON_OBJECT_AS_ARRAY;
        }

        return Json5::getInstance()
            ->withDepth($depth)
            ->decode($json, $options);
    }
}

if (! function_exists('json5_encode')) {
    /**
     * Returns the JSON5 representation of a value.
     *
     * @see \Serafim\Json5\Json5EncoderInterface::encode()
     *
     * @param mixed $value
     * @param int $options
     * @param int $depth
     * @return string
     * @throws Json5Exception
     */
    function json5_encode($value, int $options = 0, int $depth = 512): string
    {
        return Json5::getInstance()
            ->withDepth($depth)
            ->encode($value, $options);
    }
}
