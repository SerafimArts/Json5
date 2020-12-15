<?php

/**
 * This file is part of Json5 package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Serafim\Json5\Ast;

/**
 * @internal An internal class for Json5 abstract syntax tree node representation
 */
abstract class Node implements JsonNodeInterface
{
    /**
     * @var int
     */
    public const MIN_INT32_VALUE = -2 ** 31;

    /**
     * @var int
     */
    public const MAX_INT32_VALUE = 2 ** 31;

    /**
     * @var int
     */
    private int $offset;

    /**
     * Node constructor.
     *
     * @param int $offset
     */
    public function __construct(int $offset)
    {
        $this->offset = $offset;
    }

    /**
     * @return int
     */
    public function getOffset(): int
    {
        return $this->offset;
    }

    /**
     * @psalm-suppress LessSpecificImplementedReturnType
     *
     * {@inheritDoc}
     */
    public function getIterator(): \Traversable
    {
        return new \EmptyIterator();
    }

    /**
     * @param int $options
     * @param int $needle
     * @return bool
     */
    protected function hasOption(int $options, int $needle): bool
    {
        return ($options & $needle) === $needle;
    }

    /**
     * @param mixed $value
     * @return bool
     */
    protected function isBigInt($value): bool
    {
        return $value >= self::MAX_INT32_VALUE || $value < self::MIN_INT32_VALUE;
    }

    /**
     * @param bool $isPositive
     * @param int|float $value
     * @return float|int
     */
    protected function signed(bool $isPositive, $value)
    {
        return $isPositive ? $value : -$value;
    }

    /**
     * @return mixed
     */
    public function __debugInfo(): array
    {
        $result = \get_object_vars($this);
        $result['offset'] = $this->offset;

        return $result;
    }
}
