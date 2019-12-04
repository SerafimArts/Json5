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
final class FloatNumberNode extends Node
{
    /**
     * @var string
     */
    public string $value;

    /**
     * @var bool
     */
    public bool $isPositive;

    /**
     * IntNode constructor.
     *
     * @param int $offset
     * @param bool $positive
     * @param string $value
     */
    public function __construct(int $offset, bool $positive, string $value)
    {
        $this->value = $value;
        $this->isPositive = $positive;

        parent::__construct($offset);
    }

    /**
     * {@inheritDoc}
     */
    public function reduce(int $options, int $depth, int $maxDepth): float
    {
        return (float)$this->signed($this->isPositive, (float)$this->value);
    }
}
