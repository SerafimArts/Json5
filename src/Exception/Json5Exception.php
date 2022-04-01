<?php

/**
 * This file is part of json5 package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Serafim\Json5\Exception;

/**
 * @psalm-consistent-constructor
 */
class Json5Exception extends \JsonException
{
    /**
     * @param string $message
     * @param positive-int $line
     * @param positive-int $column
     * @return static
     */
    public static function create(string $message, int $line, int $column): self
    {
        assert($line > 0, 'Line must be greater than 0');
        assert($column > 0, 'Column must be greater than 0');

        return new static(
            \sprintf('%s on line %d at column %d', $message, $line, $column)
        );
    }
}
