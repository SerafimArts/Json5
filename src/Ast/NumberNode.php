<?php

/**
 * This file is part of json5 package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Serafim\Json5\Ast;

use Serafim\Json5\Internal\Comparator\ComparatorInterface;
use Serafim\Json5\Internal\Comparator\Facade;
use Serafim\Json5\Internal\Context;
use Serafim\Json5\DecodeFlag;

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
     * @var ComparatorInterface|null
     */
    private static ?ComparatorInterface $comparator = null;

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
     * @param numeric-string $value
     * @return bool
     */
    protected function isInt32(string $value): bool
    {
        return (self::$comparator ??= new Facade())->isInt32($value);
    }

    /**
     * @param numeric-string $value
     * @return bool
     */
    protected function isInt64(string $value): bool
    {
        return (self::$comparator ??= new Facade())->isInt64($value);
    }
}
