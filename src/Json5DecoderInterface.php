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
 * Interface Json5DecoderInterface
 */
interface Json5DecoderInterface
{
    /**
     * Decodes a JSON5 string
     *
     * Note: This function only works with UTF-8 encoded strings.
     *
     * @param string $json  The json string being decoded.
     * @param int $options  Bitmask of JSON decode options:
     *
     *  - {@see JSON_BIGINT_AS_STRING}          Decodes large integers as their original string value.
     *  - {@see JSON_INVALID_UTF8_IGNORE}       Ignores invalid UTF-8 characters.
     *  - {@see JSON_INVALID_UTF8_SUBSTITUTE}   Converts invalid UTF-8 characters to \0xfffd.
     *  - {@see JSON_OBJECT_AS_ARRAY}           Decodes JSON objects as array.
     *
     * @return mixed    The value encoded in json in appropriate PHP type.
     *                  Values true, false and null (case-insensitive) are
     *                  returned as "true", "false" and "null" respectively.
     *
     * @throws Json5Exception   Throws when error occurred.
     */
    public function decode(string $json, int $options = 0);
}
