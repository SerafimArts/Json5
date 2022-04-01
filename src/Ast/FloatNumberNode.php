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

/**
 * @internal An internal class for Json5 abstract syntax tree node representation
 * @psalm-internal Serafim\Json5
 */
final class FloatNumberNode extends NumberNode
{
    /**
     * @param positive-int|0 $offset
     * @param bool $isIsPositive
     * @param string $value
     */
    public function __construct(int $offset, private bool $isIsPositive, private string $value)
    {
        parent::__construct($offset);
    }

    /**
     * {@inheritDoc}
     */
    public function reduce(Context $context): float
    {
        return (float)$this->signed($this->isIsPositive, (float)$this->value);
    }
}
