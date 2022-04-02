<?php

/**
 * This file is part of json5 package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Serafim\Json5\Ast;

use Serafim\Contracts\Attribute\Ensure;
use Serafim\Contracts\Attribute\Verify;
use Serafim\Json5\Internal\Context;
use Serafim\Json5\DecodeFlag;

/**
 * @internal An internal class for Json5 abstract syntax tree node representation
 * @psalm-internal Serafim\Json5
 */
final class ExponentialNumberNode extends NumberNode
{
    /**
     * @var int
     */
    private readonly int $exponent;

    /**
     * @param positive-int|0 $offset
     * @param FloatNumberNode|IntNumberNode $value
     * @param string $exponent
     */
    public function __construct(int $offset, private readonly FloatNumberNode|IntNumberNode $value, string $exponent)
    {
        $this->exponent = (int)\substr($exponent, 1);

        parent::__construct($offset);
    }

    /**
     * {@inheritDoc}
     */
    public function reduce(Context $context): float|int|string
    {
        $result = $this->value->reduce($context);

        if ($this->exponent > 0) {
            return $this->positive((string)$result, $context);
        }

        return $this->negative((float)$result);
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
     * @param numeric-string $result
     * @param Context $context
     * @return int|float|numeric-string
     *
     * @psalm-suppress ArgumentTypeCoercion
     * @psalm-suppress MoreSpecificReturnType
     * @psalm-suppress LessSpecificReturnStatement
     */
    #[Verify('is_numeric($value)')]
    #[Ensure('!is_string($result) || is_numeric($result)')]
    private function positive(string $value, Context $context): int|float|string
    {
        $value .= \str_repeat('0', $this->exponent);

        // -- int32 on PHP x64/x86
        if ($this->isInt32($value)) {
            return (int)$value;
        }

        $shouldCastToString = ($context->options & DecodeFlag::JSON5_BIGINT_AS_STRING)
            === DecodeFlag::JSON5_BIGINT_AS_STRING;

        if ($shouldCastToString) {
            return $value;
        }

        // -- int64 on PHP x64
        if (\PHP_INT_SIZE === 8 && $this->isInt64($value)) {
            return (int)$value;
        }

        return (float)$value;
    }
}
