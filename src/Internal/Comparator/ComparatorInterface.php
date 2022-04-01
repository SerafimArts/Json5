<?php

/**
 * This file is part of json5 package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Serafim\Json5\Internal\Comparator;

interface ComparatorInterface
{
    /**
     * @param numeric-string $value
     * @return bool
     */
    public function isInt32(string $value): bool;

    /**
     * @param numeric-string $value
     * @return bool
     */
    public function isInt64(string $value): bool;
}
