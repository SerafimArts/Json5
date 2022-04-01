<?php

/**
 * This file is part of json5 package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Serafim\Json5;

/**
 * @psalm-type JsonCommonFlag = ParserInterface::JSON5_*
 */
interface ParserInterface
{
    /**
     * Converts invalid UTF-8 characters to \u{FFFD}.
     *
     * @var int
     */
    public const JSON5_INVALID_UTF8_SUBSTITUTE = \JSON_INVALID_UTF8_SUBSTITUTE;

    /**
     * Ignores invalid UTF-8 characters.
     *
     * @var int
     */
    public const JSON5_INVALID_UTF8_IGNORE = \JSON_INVALID_UTF8_IGNORE;

    /**
     * Maximum json5 depth. Must be greater than zero.
     *
     * @var positive-int
     */
    public const DEFAULT_PARSER_DEPTH = 512;
}
