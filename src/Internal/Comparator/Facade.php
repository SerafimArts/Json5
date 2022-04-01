<?php

/**
 * This file is part of json5 package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Serafim\Json5\Internal\Comparator;

final class Facade implements ComparatorInterface
{
    /**
     * @var ComparatorInterface
     */
    private ComparatorInterface $driver;

    public function __construct()
    {
        $this->driver = match (true) {
            \extension_loaded('bcmath') => new BCMathComparator(),
            \extension_loaded('gmp') => new GMPComparator(),
            default => new NativeComparator(),
        };
    }

    /**
     * {@inheritDoc}
     */
    public function isInt32(string $value): bool
    {
        return $this->driver->isInt32($value);
    }

    /**
     * {@inheritDoc}
     */
    public function isInt64(string $value): bool
    {
        return $this->driver->isInt64($value);
    }
}
