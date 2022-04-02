<?php

/**
 * This file is part of json5 package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Serafim\Json5\Internal;

use Serafim\Contracts\Attribute\Invariant;
use Serafim\Contracts\Attribute\Verify;
use Serafim\Json5\DecodeFlag;
use Serafim\Json5\EncodeFlag;
use Serafim\Json5\Json5;

/**
 * @internal This is an internal library class, please do not use it in your code.
 * @psalm-internal Serafim\Json5
 */
final class Context
{
    /**
     * @var positive-int|0
     */
    #[Invariant('$this->depth >= 0', 'Json current depth cannot be less than 0')]
    public int $depth = 0;

    /**
     * @param int-mask-of<DecodeFlag::JSON5_*>|int-mask-of<EncodeFlag::JSON5_*> $options
     * @param positive-int|0 $maxDepth
     */
    #[Verify('$options >= 0', 'Json flags (options) must be greater than 0')]
    #[Verify('$maxDepth > 0', 'Json depth must be greater than 0')]
    public function __construct(
        public readonly int $options = 0,
        public readonly int $maxDepth = Json5::DEFAULT_JSON5_DEPTH,
    ) {
    }
}
