<?php

/**
 * This file is part of json5 package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Serafim\Json5\Ast;

use Serafim\Json5\Internal\Context;
use Serafim\Json5\Json5DecoderInterface;

/**
 * @internal An internal class for Json5 abstract syntax tree node representation
 * @psalm-internal Serafim\Json5
 */
abstract class NumberNode extends Expression
{
    /**
     * @var int
     */
    private const MIN_INT32_VALUE = -2 ** 31;

    /**
     * @var positive-int
     */
    private const MAX_INT32_VALUE = 2 ** 31;

    /**
     * @param bool $isPositive
     * @param int|float $value
     * @return float|int
     */
    protected function signed(bool $isPositive, int|float $value): float|int
    {
        return $isPositive ? $value : -$value;
    }

    /**
     * @param int|float $value
     * @return bool
     */
    protected function isBigInt(int|float $value): bool
    {
        return $value >= self::MAX_INT32_VALUE || $value < self::MIN_INT32_VALUE;
    }
}
