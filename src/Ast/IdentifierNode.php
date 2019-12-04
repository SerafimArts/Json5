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
final class IdentifierNode extends Node
{
    /**
     * @var string
     */
    public string $value;

    /**
     * IdentifierNode constructor.
     *
     * @param int $offset
     * @param string $value
     */
    public function __construct(int $offset, string $value)
    {
        $this->value = $value;

        parent::__construct($offset);
    }

    /**
     * {@inheritDoc}
     */
    public function reduce(int $options, int $depth, int $maxDepth): string
    {
        return $this->value;
    }
}
