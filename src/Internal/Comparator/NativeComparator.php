<?php

/**
 * This file is part of json5 package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Serafim\Json5\Internal\Comparator;

final class NativeComparator implements ComparatorInterface
{
    private const INT32_MIN_VALUE = '2147483648';
    private const INT32_MAX_VALUE = '2147483647';
    private const INT64_MIN_VALUE = '9223372036854775808';
    private const INT64_MAX_VALUE = '9223372036854775807';

    /**
     * @param numeric-string $value
     * @param numeric-string $max
     * @return bool
     */
    private function isBoundOverflow(string $value, string $max): bool
    {
        [$lengthValue, $lengthMax] = [\strlen($value), \strlen($max)];

        if ($lengthValue > $lengthMax) {
            return true;
        }

        if ($lengthValue < $lengthMax) {
            return false;
        }

        foreach (\str_split($value) as $i => $digit) {
            if ((int)$digit > (int)$max[$i]) {
                return true;
            }
        }

        return false;
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

        /** @psalm-suppress ArgumentTypeCoercion */
        return !($value[0] === '-'
            ? $this->isBoundOverflow(\substr($value, 1), self::INT32_MIN_VALUE)
            : $this->isBoundOverflow($value, self::INT32_MAX_VALUE)
        );
    }

    /**
     * {@inheritDoc}
     */
    public function isInt64(string $value): bool
    {
        /** @psalm-suppress RedundantCondition */
        if (\PHP_INT_SIZE === 8 && \is_float((int)$value)) {
            return false;
        }

        /** @psalm-suppress ArgumentTypeCoercion */
        return !($value[0] === '-'
            ? $this->isBoundOverflow(\substr($value, 1), self::INT64_MIN_VALUE)
            : $this->isBoundOverflow($value, self::INT64_MAX_VALUE)
        );
    }
}
