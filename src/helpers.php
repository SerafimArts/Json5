<?php

/**
 * This file is part of json5 package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

use JetBrains\PhpStorm\Language;
use Serafim\Json5\Exception\Json5Exception;
use Serafim\Json5\Json5;
use Serafim\Json5\ParserInterface;

if (! function_exists('json5_decode')) {
    /**
     * Decodes a JSON5 string.
     *
     * @psalm-import-type JsonDecodeFlags from \Serafim\Json5\Json5DecoderInterface
     *
     * @param string $json
     * @param bool $assoc
     * @param positive-int $depth
     * @param JsonDecodeFlags $options
     * @return mixed
     * @throws Json5Exception
     * @throws Throwable
     * @see Serafim\Json5\Json5DecoderInterface::decode()
     */
    function json5_decode(
        #[Language('JSON5')]
        string $json,
        bool $assoc = false,
        int $depth = ParserInterface::DEFAULT_PARSER_DEPTH,
        int $options = 0
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
     * @psalm-import-type JsonEncodeFlags from \Serafim\Json5\Json5EncoderInterface
     *
     * @param mixed $value
     * @param JsonEncodeFlags $options
     * @param positive-int $depth
     * @return string
     * @throws Json5Exception
     * @see \Serafim\Json5\Json5EncoderInterface::encode()
     */
    function json5_encode(
        mixed $value,
        int $options = 0,
        int $depth = ParserInterface::DEFAULT_PARSER_DEPTH
    ): string {
        return Json5::encode($value, $options, $depth);
    }
}
