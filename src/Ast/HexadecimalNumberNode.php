<?php

/**
 * This file is part of json5 package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Serafim\Json5\Ast;

use Serafim\Contracts\Attribute\Verify;
use Serafim\Json5\Internal\Context;

/**
 * @internal An internal class for Json5 abstract syntax tree node representation
 * @psalm-internal Serafim\Json5
 */
final class HexadecimalNumberNode extends NumberNode
{
    /**
     * @param positive-int|0 $offset
     * @param bool $positive
     * @param string $value
     */
    #[Verify('strlen($value) > 2', 'Hex value length must be greater than 0')]
    public function __construct(
        int $offset,
        private readonly bool $positive,
        private readonly string $value
    ) {
        parent::__construct($offset);
    }

    /**
     * {@inheritDoc}
     */
    public function reduce(Context $context): int
    {
        $hex = \substr($this->value, 2);

        return $this->positive ? (int)\hexdec($hex) : -(int)\hexdec($hex);
    }
}
