<?php

/**
 * This file is part of json5 package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Serafim\Json5\Ast;

/**
 * @internal An internal class for Json5 abstract syntax tree node representation
 * @psalm-internal Serafim\Json5
 */
final class ObjectMemberNode extends Node
{
    /**
     * @param positive-int|0 $offset
     * @param StringNode|IdentifierNode $key
     * @param Expression $value
     */
    public function __construct(int $offset, public StringNode|IdentifierNode $key, public Expression $value)
    {
        parent::__construct($offset);
    }
}
