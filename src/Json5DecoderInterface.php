<?php

/**
 * This file is part of json5 package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Serafim\Json5;

use JetBrains\PhpStorm\Language;
use Serafim\Json5\Exception\Json5Exception;

/**
 * @psalm-type JsonDecodeFlag = Json5DecoderInterface::JSON5_*
 * @psalm-type JsonDecodeFlags = int-mask-of<JsonDecodeFlag>
 */
interface Json5DecoderInterface extends ParserInterface
{
    /**
     * Decodes large integers as their original string value.
     *
     * @var int
     */
    public const JSON5_BIGINT_AS_STRING = \JSON_BIGINT_AS_STRING;

    /**
     * Ignores invalid UTF-8 characters.
     *
     * @var int
     */
    public const JSON5_INVALID_UTF8_IGNORE = \JSON_INVALID_UTF8_IGNORE;

    /**
     * Decodes a JSON5 string.
     *
     * @param string $json              The json string being decoded.
     * @param JsonDecodeFlags $options  Bitmask of JSON decode options.
     * @param positive-int $depth       Maximum nesting depth of the structure
     *                                  being decoded.
     *
     * @return mixed The value encoded in json in appropriate PHP type. JSON
     *               values true, false and null (case-insensitive) are returned
     *               as PHP {@see true}, {@see false} and {@see null}
     *               respectively.
     *
     * @throws Json5Exception Throws when error occurred.
     */
    public static function decode(
        #[Language('JSON5')]
        string $json,
        int $options = 0,
        int $depth = self::DEFAULT_PARSER_DEPTH
    ): mixed;
}
