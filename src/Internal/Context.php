<?php

/**
 * This file is part of json5 package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Serafim\Json5\Internal;

use Serafim\Json5\Json5DecoderInterface;
use Serafim\Json5\Json5EncoderInterface;
use Serafim\Json5\ParserInterface;

/**
 * @psalm-import-type JsonDecodeFlags from Json5DecoderInterface
 * @psalm-import-type JsonDecodeFlag from Json5DecoderInterface
 * @psalm-import-type JsonEncodeFlags from Json5EncoderInterface
 * @psalm-import-type JsonEncodeFlag from Json5EncoderInterface
 *
 * @internal This is an internal library class, please do not use it in your code.
 * @psalm-internal Serafim\Json5
 */
final class Context
{
    /**
     * @var positive-int|0
     */
    public int $depth = 0;

    /**
     * @param int $options
     * @param positive-int|0 $maxDepth
     */
    public function __construct(
        public int $options = 0,
        public int $maxDepth = ParserInterface::DEFAULT_PARSER_DEPTH,
    ) {
    }

    /**
     * @param JsonDecodeFlag|JsonEncodeFlag $option
     * @return bool
     * @psalm-suppress InvalidOperand
     * @psalm-suppress TypeDoesNotContainType
     */
    public function hasOption(int $option): bool
    {
        return ($this->options & $option) === $option;
    }

    /**
     * @return bool
     */
    public function isDepthOverflow(): bool
    {
        return $this->depth + 1 >= $this->maxDepth;
    }
}
