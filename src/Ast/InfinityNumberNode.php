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
final class InfinityNumberNode extends Node
{
    /**
     * @var bool
     */
    public bool $isPositive;

    /**
     * NotANumberNode constructor.
     *
     * @param int $offset
     * @param bool $positive
     */
    public function __construct(int $offset, bool $positive)
    {
        $this->isPositive = $positive;

        parent::__construct($offset);
    }

    /**
     * {@inheritDoc}
     */
    public function reduce(int $options, int $depth, int $maxDepth): float
    {
        return $this->signed($this->isPositive, \INF);
    }
}
