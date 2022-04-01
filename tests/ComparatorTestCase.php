<?php

/**
 * This file is part of json5 package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Serafim\Json5\Tests;

use Serafim\Json5\Internal\Comparator\BCMathComparator;
use Serafim\Json5\Internal\Comparator\ComparatorInterface;
use Serafim\Json5\Internal\Comparator\GMPComparator;
use Serafim\Json5\Internal\Comparator\NativeComparator;

class ComparatorTestCase extends TestCase
{
    protected function comparatorDataProvider(): array
    {
        $result = ['native' => [new NativeComparator()]];

        if (\extension_loaded('bcmath')) {
            $result['bcmath'] = [new BCMathComparator()];
        }

        if (\extension_loaded('gmp')) {
            $result['gmp'] = [new GMPComparator()];
        }

        return $result;
    }

    /**
     * @dataProvider comparatorDataProvider
     */
    public function testInt32Zero(ComparatorInterface $comparator): void
    {
        $this->assertTrue($comparator->isInt32('0'));
    }

    /**
     * @dataProvider comparatorDataProvider
     */
    public function testInt32NegativeZero(ComparatorInterface $comparator): void
    {
        $this->assertTrue($comparator->isInt32('-0'));
    }

    /**
     * @dataProvider comparatorDataProvider
     */
    public function testInt32MaxBound(ComparatorInterface $comparator): void
    {
        $this->assertTrue($comparator->isInt32('2147483647'));
    }

    /**
     * @dataProvider comparatorDataProvider
     */
    public function testInt32MinBound(ComparatorInterface $comparator): void
    {
        $this->assertTrue($comparator->isInt32('-2147483648'));
    }

    /**
     * @dataProvider comparatorDataProvider
     */
    public function testInt32MaxBoundOverflow(ComparatorInterface $comparator): void
    {
        $this->assertFalse($comparator->isInt32('2147483648'));
    }

    /**
     * @dataProvider comparatorDataProvider
     */
    public function testInt32MaxBoundX2Overflow(ComparatorInterface $comparator): void
    {
        $this->assertFalse($comparator->isInt32('21474836482147483648'));
    }

    /**
     * @dataProvider comparatorDataProvider
     */
    public function testInt32MinBoundOverflow(ComparatorInterface $comparator): void
    {
        $this->assertFalse($comparator->isInt32('-2147483649'));
    }

    /**
     * @dataProvider comparatorDataProvider
     */
    public function testInt32MinBoundX2Overflow(ComparatorInterface $comparator): void
    {
        $this->assertFalse($comparator->isInt32('-21474836492147483649'));
    }

    /**
     * @dataProvider comparatorDataProvider
     */
    public function testInt64Zero(ComparatorInterface $comparator): void
    {
        $this->assertTrue($comparator->isInt64('0'));
    }

    /**
     * @dataProvider comparatorDataProvider
     */
    public function testInt64NegativeZero(ComparatorInterface $comparator): void
    {
        $this->assertTrue($comparator->isInt64('-0'));
    }

    /**
     * @dataProvider comparatorDataProvider
     */
    public function testInt64MaxBound(ComparatorInterface $comparator): void
    {
        $this->assertTrue($comparator->isInt64('9223372036854775807'));
    }

    /**
     * @dataProvider comparatorDataProvider
     */
    public function testInt64MinBound(ComparatorInterface $comparator): void
    {
        $this->assertTrue($comparator->isInt64('-9223372036854775808'));
    }

    /**
     * @dataProvider comparatorDataProvider
     */
    public function testInt64MaxBoundOverflow(ComparatorInterface $comparator): void
    {
        $this->assertFalse($comparator->isInt64('9223372036854775808'));
    }

    /**
     * @dataProvider comparatorDataProvider
     */
    public function testInt64MaxBoundX2Overflow(ComparatorInterface $comparator): void
    {
        $this->assertFalse($comparator->isInt64('92233720368547758089223372036854775808'));
    }

    /**
     * @dataProvider comparatorDataProvider
     */
    public function testInt64MinBoundOverflow(ComparatorInterface $comparator): void
    {
        $this->assertFalse($comparator->isInt64('-9223372036854775809'));
    }

    /**
     * @dataProvider comparatorDataProvider
     */
    public function testInt64MinBoundX2Overflow(ComparatorInterface $comparator): void
    {
        $this->assertFalse($comparator->isInt64('-92233720368547758099223372036854775809'));
    }
}
