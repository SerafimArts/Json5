<?php

/**
 * This file is part of json5 package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Serafim\Json5\Tests\Decoder;

use Serafim\Json5\DecodeFlag;
use Serafim\Json5\Exception\Json5Exception;

class LiteralsTestCase extends DecoderTestCase
{
    public function testEmptyString(): void
    {
        $this->assertNull($this->decode(''));
    }

    public function testWhitespacesString(): void
    {
        $this->assertNull($this->decode('    '));
    }

    public function testBooleanTrue(): void
    {
        $this->assertTrue($this->decode('true'));
    }

    public function testBooleanTrueWithInvalidCase(): void
    {
        $this->expectException(Json5Exception::class);
        $this->decode('True');
    }

    public function testBooleanFalse(): void
    {
        $this->assertFalse($this->decode('false'));
    }

    public function testBooleanFalseWithInvalidCase(): void
    {
        $this->expectException(Json5Exception::class);
        $this->decode('False');
    }

    public function testNull(): void
    {
        $this->assertNull($this->decode('null'));
    }

    public function testNullWithInvalidCase(): void
    {
        $this->expectException(Json5Exception::class);
        $this->decode('NULL');
    }

    public function testNaN(): void
    {
        $this->assertNan($this->decode('NaN'));
    }

    public function testNaNWithInvalidCase(): void
    {
        $this->expectException(Json5Exception::class);
        $this->decode('NAN');
    }

    public function testInfinity(): void
    {
        $this->assertInfinite($this->decode('Infinity'));
    }

    public function testInfinityWithInvalidCase(): void
    {
        $this->expectException(Json5Exception::class);
        $this->decode('infinity');
    }

    public function testString(): void
    {
        $this->assertSame('example', $this->decode('"example"'));
    }

    public function testHexNumber(): void
    {
        $this->assertSame(0xDEAD_BEEF, $this->decode('0xDEADBEEF'));
    }

    public function testNegativeHexNumber(): void
    {
        $this->assertSame(-0xDEAD_BEEF, $this->decode('-0xDEADBEEF'));
    }

    public function testFloatNumber(): void
    {
        $this->assertSame(.42, $this->decode('0.42'));
    }

    public function testNegativeFloatNumber(): void
    {
        $this->assertSame(-.42, $this->decode('-0.42'));
    }

    public function testFloatLDNumber(): void
    {
        $this->assertSame(.42, $this->decode('.42'));
    }

    public function testNegativeLDFloatNumber(): void
    {
        $this->assertSame(-.42, $this->decode('-.42'));
    }

    public function testFloatTGNumber(): void
    {
        $this->assertSame(42., $this->decode('42.'));
    }

    public function testNegativeTGFloatNumber(): void
    {
        $this->assertSame(-42., $this->decode('-42.'));
    }

    public function testTrailingFloatNumber(): void
    {
        $this->expectException(Json5Exception::class);
        $this->decode('.');
    }

    public function testTrailingNegativeFloatNumber(): void
    {
        $this->expectException(Json5Exception::class);
        $this->decode('-.');
    }

    public function testIntNumber(): void
    {
        $this->assertSame(42, $this->decode('42'));
    }

    public function testNegativeIntNumber(): void
    {
        $this->assertSame(-42, $this->decode('-42'));
    }

    public function testInt32MaxNumber(): void
    {
        $this->assertSame(2147483647, $this->decode('2147483647'));
    }

    public function testInt32MaxOverflowNumber(): void
    {
        if (\PHP_INT_SIZE !== 8) {
            $this->markTestSkipped('PHP x64 required');
        }

        $this->assertSame(2147483648, $this->decode('2147483648'));
    }

    public function testInt32MaxOverflowToStringNumber(): void
    {
        $this->assertSame('2147483648', $this->decode(
            '2147483648',
            DecodeFlag::JSON5_BIGINT_AS_STRING
        ));
    }

    public function testInt32MinNumber(): void
    {
        $this->assertSame(-2147483648, $this->decode('-2147483648'));
    }

    public function testInt32MinOverflowNumber(): void
    {
        if (\PHP_INT_SIZE !== 8) {
            $this->markTestSkipped('PHP x64 required');
        }

        $this->assertSame(-2147483649, $this->decode('-2147483649'));
    }

    public function testInt32MinOverflowToStringNumber(): void
    {
        $this->assertSame('-2147483649', $this->decode(
            '-2147483649',
            DecodeFlag::JSON5_BIGINT_AS_STRING
        ));
    }
}
