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
final class ExponentialNumberNode extends Node
{
    /**
     * @var Node|FloatNumberNode|IntNumberNode
     */
    public Node $value;

    /**
     * @var int
     */
    public int $exponent;

    /**
     * IntNode constructor.
     *
     * @param int $offset
     * @param Node $value
     * @param string $exponent
     */
    public function __construct(int $offset, Node $value, string $exponent)
    {
        \assert($value instanceof FloatNumberNode || $value instanceof IntNumberNode);

        $this->value = $value;
        $this->exponent = (int)\substr($exponent, 1);

        parent::__construct($offset);
    }

    /**
     * @return \Traversable|Node[]|FloatNumberNode[]|IntNumberNode[]
     */
    public function getIterator(): \Traversable
    {
        return new \ArrayIterator(['value' => $this->value]);
    }

    /**
     * {@inheritDoc}
     */
    public function reduce(int $options, int $depth, int $maxDepth)
    {
        /** @var string|int|float $result */
        $result = $this->value->reduce($options, $depth, $maxDepth);

        return $this->exponent > 0
            ? $this->positive((string)$result, $options)
            : $this->negative((float)$result);
    }

    /**
     * @param float $result
     * @return float
     */
    private function negative(float $result): float
    {
        $value = '1' . \str_repeat('0', \abs($this->exponent));

        return $result / (float)$value;
    }

    /**
     * @param string $result
     * @param int $options
     * @return int|string
     */
    private function positive(string $result, int $options)
    {
        $result .= \str_repeat('0', $this->exponent);

        return $this->isBigInt((int)$result) && $this->hasOption($options, \JSON_BIGINT_AS_STRING)
            ? $result
            : (int)$result;
    }
}
