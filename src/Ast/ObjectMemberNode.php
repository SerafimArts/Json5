<?php

/**
 * This file is part of Json5 package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Serafim\Json5\Ast;

use Phplrt\Contracts\Ast\NodeInterface;

/**
 * @internal An internal class for Json5 abstract syntax tree node representation
 */
final class ObjectMemberNode implements NodeInterface
{
    /**
     * @var Node
     */
    public Node $key;

    /**
     * @var Node
     */
    public Node $value;

    /**
     * @var int
     */
    private int $offset;

    /**
     * ObjectKeyValueNode constructor.
     *
     * @param int $offset
     * @param Node $key
     * @param Node $value
     */
    public function __construct(int $offset, Node $key, Node $value)
    {
        $this->key = $key;
        $this->value = $value;
        $this->offset = $offset;
    }

    /**
     * @return \Traversable|Node[]
     */
    public function getIterator(): \Traversable
    {
        yield 'key' => $this->key;
        yield 'value' => $this->value;
    }

    /**
     * @return int
     */
    public function getOffset(): int
    {
        return $this->offset;
    }
}
