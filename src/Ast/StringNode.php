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
use Serafim\Json5\Internal\StringParser;

/**
 * @internal An internal class for Json5 abstract syntax tree node representation
 * @psalm-internal Serafim\Json5
 */
final class StringNode extends Expression
{
    /**
     * @var StringParser|null
     */
    private static ?StringParser $parser = null;

    /**
     * @param positive-int $offset
     * @param string $value
     */
    public function __construct(
        int $offset,
        private readonly string $value
    ) {
        parent::__construct($offset);
    }

    /**
     * {@inheritDoc}
     */
    public function reduce(Context $context): string
    {
        if ($this->value === '') {
            return $this->value;
        }

        return (self::$parser ??= new StringParser())
            ->decode($this->value, $context)
        ;
    }
}
