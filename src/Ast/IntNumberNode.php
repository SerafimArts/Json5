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
class IntNumberNode extends NumberNode
{
    /**
     * @param positive-int|0 $offset
     * @param bool $isPositive
     * @param string $value
     */
    public function __construct(int $offset, private bool $isPositive, private string $value)
    {
        parent::__construct($offset);
    }

    /**
     * {@inheritDoc}
     */
    public function reduce(Context $context): float|int|string
    {
        $expectCastToString = $this->isBigInt((int)$this->value)
            && $context->hasOption(Json5DecoderInterface::JSON5_BIGINT_AS_STRING);

        if ($expectCastToString) {
            return $this->isPositive ? $this->value : '-' . $this->value;
        }

        return $this->signed($this->isPositive, (int)$this->value);
    }
}
