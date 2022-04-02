<?php

/**
 * This file is part of json5 package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Serafim\Json5;

use JetBrains\PhpStorm\ExpectedValues;
use JetBrains\PhpStorm\Language;
use Phplrt\Contracts\Exception\RuntimeExceptionInterface;
use Phplrt\Exception\RuntimeException;
use Phplrt\Position\Position;
use Serafim\Contracts\Attribute\Verify;
use Serafim\Json5\Ast\Expression;
use Serafim\Json5\Ast\IntNumberNode;
use Serafim\Json5\Ast\Node;
use Serafim\Json5\Exception\Json5Exception;
use Serafim\Json5\Internal\Context;
use Serafim\Json5\Internal\Json5Parser;

/**
 * @psalm-import-type JsonDecodeFlag from DecodeFlag
 * @psalm-import-type JsonEncodeFlag from EncodeFlag
 */
final class Json5
{
    /**
     * Maximum json5 depth. Must be greater than zero.
     *
     * @var positive-int
     */
    public const DEFAULT_JSON5_DEPTH = 512;

    /**
     * @var Json5Parser|null
     */
    private static ?Json5Parser $parser = null;

    /**
     * Decodes a JSON5 string.
     *
     * @param string $json The json string being decoded.
     * @param int-mask-of<JsonDecodeFlag> $options Bitmask of JSON decode options.
     * @param positive-int $depth Maximum nesting depth of the structure being
     *                            decoded.
     * @return mixed The value encoded in json in appropriate PHP type. JSON
     *               values true, false and null (case-insensitive) are returned
     *               as PHP {@see true}, {@see false} and {@see null}
     *               respectively.
     * @throws Json5Exception Throws when error occurred.
     */
    #[Verify('$depth > 0', 'Json depth must be greater than 0')]
    public static function decode(
        #[Language('JSON5')]
        string $json,
        #[ExpectedValues(flagsFromClass: DecodeFlag::class)]
        int $options = 0,
        int $depth = self::DEFAULT_JSON5_DEPTH
    ): mixed {
        $json = \trim($json);

        $context = new Context(
            options: $options,
            maxDepth: $depth,
        );

        return match($json) {
            // Empty String
            '' => null,
            // True Literal
            'true' => true,
            // False Literal
            'false' => false,
            // NaN Literal
            'NaN' => \NAN,
            // Infinity Literal
            'Infinity' => \INF,
            // Composite Analysis
            default => match (true) {
                // Integer Sequence
                \ctype_digit($json) => IntNumberNode::eval($json, $context),
                // Negative Integer Sequence
                $json[0] === '-' && \ctype_digit(\substr($json, 1)) => IntNumberNode::eval(\substr($json, 1), $context, false),
                // Nested Analysis
                default => self::eval($json, $context)
            }
        };
    }

    /**
     * @param string $json
     * @param Context $context
     * @return mixed
     * @throws Json5Exception
     */
    private static function eval(string $json, Context $context): mixed
    {
        if (self::$parser === null) {
            self::$parser = new Json5Parser();
        }

        try {
            /** @psalm-var array<array-key, Node> $result */
            $result = self::$parser->parse($json);

            $expression = \reset($result);

            if ($expression instanceof Expression) {
                return $expression->reduce($context);
            }

            return null;
        } catch (RuntimeException $e) {
            $token = $e->getToken();
            $position = Position::fromOffset($json, $token->getOffset());

            throw Json5Exception::create($e->getMessage(), $position->getLine(), $position->getColumn());
        } catch (\Throwable $e) {
            throw new Json5Exception($e->getMessage(), (int)$e->getCode(), $e);
        }
    }

    /**
     * Returns the JSON5 representation of a value.
     *
     * @param mixed $value The value being encoded. Can be any type except
     *                     a PHP resource type.
     * @param int-mask-of<JsonEncodeFlag> $options Bitmask of JSON encode options.
     * @param positive-int $depth Set the maximum depth. Must be greater than zero.
     * @return string A JSON5 encoded string.
     * @throws Json5Exception Throws when error occurred.
     */
    #[Verify('$depth > 0', 'Json depth must be greater than 0')]
    public static function encode(
        mixed $value,
        #[ExpectedValues(flagsFromClass: EncodeFlag::class)]
        int $options = 0,
        int $depth = self::DEFAULT_JSON5_DEPTH
    ): string {
        try {
            return \json_encode($value, $options | \JSON_THROW_ON_ERROR, $depth);
        } catch (\Throwable $e) {
            throw new Json5Exception($e->getMessage());
        }
    }
}
