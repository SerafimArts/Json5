<?php

/**
 * This file is part of json5 package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Serafim\Json5\Ast;

use Phplrt\Contracts\Ast\NodeInterface;
use Serafim\Json5\Internal\Context;

/**
 * @internal An internal class for Json5 abstract syntax tree node representation
 * @psalm-internal Serafim\Json5
 */
abstract class Node implements NodeInterface
{
    /**
     * @param positive-int|0 $offset
     */
    public function __construct(private int $offset)
    {
        assert($offset >= 0, 'Offset should be greater or equals than 0');
    }

    /**
     * @return positive-int|0
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
     * @return mixed
     */
    public function __debugInfo(): array
    {
        $result = \get_object_vars($this);
        $result['offset'] = $this->offset;

        return $result;
    }
}
