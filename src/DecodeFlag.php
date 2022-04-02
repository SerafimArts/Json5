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
 * @psalm-type JsonDecodeFlag = DecodeFlag::JSON5_*
 */
interface DecodeFlag extends Flag
{
    /**
     * Decodes large integers as their original string value.
     *
     * @var int
     */
    public const JSON5_BIGINT_AS_STRING = \JSON_BIGINT_AS_STRING;

    /**
     * Decodes JSON objects as array.
     *
     * @var int
     */
    public const JSON5_OBJECT_AS_ARRAY = \JSON_OBJECT_AS_ARRAY;
}
