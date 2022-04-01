<?php

/**
 * This file is part of json5 package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Serafim\Json5;

use Serafim\Json5\Exception\Json5Exception;

/**
 * @psalm-type JsonEncodeFlag = Json5EncoderInterface::JSON5_*
 * @psalm-type JsonEncodeFlags = int-mask-of<JsonEncodeFlag>
 */
interface Json5EncoderInterface extends ParserInterface
{
    /**
     * All " are converted to \u{0022}.
     *
     * @var int
     */
    public const JSON5_HEX_QUOT = \JSON_HEX_QUOT;

    /**
     * All < and > are converted to \u{003C} and \u{003E}.
     *
     * @var int
     */
    public const JSON5_HEX_TAG = \JSON_HEX_TAG;

    /**
     * All & are converted to \u{0026}.
     *
     * @var int
     */
    public const JSON5_HEX_AMP = \JSON_HEX_AMP;

    /**
     * All ' are converted to \u{0027}.
     *
     * @var int
     */
    public const JSON5_HEX_APOS = \JSON_HEX_APOS;

    /**
     * Encodes numeric strings as numbers.
     *
     * @var int
     */
    public const JSON5_NUMERIC_CHECK = \JSON_NUMERIC_CHECK;

    /**
     * Use whitespace in returned data to format it.
     *
     * @var int
     */
    public const JSON5_PRETTY_PRINT = \JSON_PRETTY_PRINT;

    /**
     * Don't escape / character.
     *
     * @var int
     */
    public const JSON5_UNESCAPED_SLASHES = \JSON_UNESCAPED_SLASHES;

    /**
     * Outputs an object rather than an array when a non-associative array is
     * used. Especially useful when the recipient of the output is expecting an
     * object and the array is empty.
     *
     * @var int
     */
    public const JSON5_FORCE_OBJECT = \JSON_FORCE_OBJECT;

    /**
     * Encode multibyte Unicode characters literally
     * (default is to escape as \u{XXXX}).
     *
     * @var int
     */
    public const JSON5_UNESCAPED_UNICODE = \JSON_UNESCAPED_UNICODE;

    /**
     * Ensures that float values are always encoded as a float value.
     *
     * @var int
     */
    public const JSON5_PRESERVE_ZERO_FRACTION = \JSON_PRESERVE_ZERO_FRACTION;

    /**
     * The line terminators are kept unescaped when {@see JSON5_UNESCAPED_UNICODE}
     * is supplied.
     *
     * @var int
     */
    public const JSON5_UNESCAPED_LINE_TERMINATORS = \JSON_UNESCAPED_LINE_TERMINATORS;

    /**
     * Avoids errors when using the {@see encode()} method. Substitutes
     * default values for non-encoded ones.
     *
     * @var int
     */
    public const JSON5_PARTIAL_OUTPUT_ON_ERROR = \JSON_PARTIAL_OUTPUT_ON_ERROR;

    /**
     * Returns the JSON5 representation of a value.
     *
     * @param mixed $value             The value being encoded. Can be any type
     *                                 except a resource.
     * @param JsonEncodeFlags $options Bitmask of JSON encode options.
     * @param positive-int $depth      Set the maximum depth. Must be greater
     *                                 than zero.
     *
     * @return string A JSON5 encoded string.
     *
     * @throws Json5Exception Throws when error occurred.
     */
    public static function encode(
        mixed $value,
        int $options = 0,
        int $depth = self::DEFAULT_PARSER_DEPTH
    ): string;
}
