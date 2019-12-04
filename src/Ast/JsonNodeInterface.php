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
 * Interface JsonNodeInterface
 */
interface JsonNodeInterface extends NodeInterface
{
    /**
     * @param int $options
     * @param int $depth
     * @param int $maxDepth
     * @return mixed
     */
    public function reduce(int $options, int $depth, int $maxDepth);
}
