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
abstract class Expression extends Node
{
    /**
     * @param Context $context
     * @return mixed
     */
    abstract public function reduce(Context $context): mixed;
}
