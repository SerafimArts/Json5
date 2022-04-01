<?php

/**
 * This file is part of json5 package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Serafim\Json5\Internal\Comparator;

final class BCMathComparator implements ComparatorInterface
{
    public function __construct()
    {
        assert(\extension_loaded('bcmath'), 'ext-bcmath required');
    }

    /**
     * {@inheritDoc}
     */
    public function isInt32(string $value): bool
    {
        if (\PHP_INT_SIZE === 8) {
            $number = (int)$value;

            return $number >= -2147483648 && $number <= 2147483647;
        }

        return \bccomp('2147483647', $value) >= 0
            && \bccomp('-2147483648', $value) <= 0;
    }

    /**
     * {@inheritDoc}
     */
    public function isInt64(string $value): bool
    {
        return \bccomp('9223372036854775807', $value) >= 0
            && \bccomp('-9223372036854775808', $value) <= 0;
    }
}
