<?php

/**
 * This file is part of Json5 package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Serafim\Json5;

use Serafim\Json5\Exception\Json5Exception;

/**
 * Interface Json5EncoderInterface
 */
interface Json5EncoderInterface
{
    /**
     * Returns the JSON5 representation of a value.
     *
     * Note: All string data must be UTF-8 encoded.
     *
     * @param mixed $value  The value being encoded. Can be any type except
     *                      a resource.
     * @param int $options  Bitmask of JSON encode options:
     *
     *  - {@see JSON_HEX_QUOT}                      All " are converted to \u0022.
     *  - {@see JSON_HEX_TAG}                       All < and > are converted to \u003C and \u003E.
     *  - {@see JSON_HEX_AMP}                       All & are converted to \u0026.
     *  - {@see JSON_HEX_APOS}                      All ' are converted to \u0027.
     *  - {@see JSON_NUMERIC_CHECK}                 Encodes numeric strings as numbers.
     *  - {@see JSON_PRETTY_PRINT}                  Use whitespace in returned data to format it.
     *  - {@see JSON_UNESCAPED_SLASHES}             Don't escape / character.
     *  - {@see JSON_FORCE_OBJECT}                  Outputs an object rather than an array when a non-associative array
     *                                              is used. Especially useful when the recipient of the output is
     *                                              expecting an object and the array is empty.
     *  - {@see JSON_UNESCAPED_UNICODE}             Encode multibyte Unicode characters literally
     *                                              (default is to escape as \uXXXX).
     *  - {@see JSON_PRESERVE_ZERO_FRACTION}        Ensures that float values are always encoded as a float value.
     *  - {@see JSON_UNESCAPED_LINE_TERMINATORS}    The line terminators are kept unescaped when JSON_UNESCAPED_UNICODE
     *                                              is supplied.
     *  - {@see JSON_INVALID_UTF8_IGNORE}           Ignores invalid UTF-8 characters.
     *  - {@see JSON_INVALID_UTF8_SUBSTITUTE}       Converts invalid UTF-8 characters to \0xfffd.
     *
     * @return string       A JSON5 encoded string.
     *
     * @throws Json5Exception Throws when error occurred.
     */
    public function encode($value, int $options = 0): string;
}
