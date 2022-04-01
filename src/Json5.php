<?php

/**
 * This file is part of json5 package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Serafim\Json5;

use JetBrains\PhpStorm\Language;
use Phplrt\Contracts\Exception\RuntimeExceptionInterface;
use Phplrt\Exception\RuntimeException;
use Phplrt\Position\Position;
use Serafim\Json5\Ast\IntNumberNode;
use Serafim\Json5\Ast\Node;
use Serafim\Json5\Exception\Json5Exception;
use Serafim\Json5\Internal\Context;
use Serafim\Json5\Internal\Json5Parser;

final class Json5 implements Json5EncoderInterface, Json5DecoderInterface
{
    /**
     * @var Json5Parser|null
     */
    private static ?Json5Parser $parser = null;

    /**
     * {@inheritDoc}
     */
    public static function decode(
        #[Language('JSON5')]
        string $json,
        int $options = 0,
        int $depth = self::DEFAULT_PARSER_DEPTH
    ): mixed {
        assert($depth > 0, 'Depth must be greater than 0');

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
     * @throws RuntimeExceptionInterface
     * @throws \Throwable
     */
    private static function eval(string $json, Context $context): mixed
    {
        if (self::$parser === null) {
            self::$parser = new Json5Parser();
        }

        try {
            /** @psalm-var array<array-key, Node> $result */
            $result = self::$parser->parse($json);

            if (($ast = \reset($result)) instanceof Node) {
                return $ast->reduce($context);
            }

            return null;
        } catch (RuntimeException $e) {
            $token = $e->getToken();
            $position = Position::fromOffset($json, $token->getOffset());

            throw Json5Exception::create($e->getMessage(), $position->getLine(), $position->getColumn());
        }
    }

    /**
     * {@inheritDoc}
     */
    public static function encode($value, int $options = 0, int $depth = self::DEFAULT_PARSER_DEPTH): string
    {
        assert($depth > 0, 'Depth must be greater than 0');

        try {
            return \json_encode($value, $options | \JSON_THROW_ON_ERROR, $depth);
        } catch (\Throwable $e) {
            throw new Json5Exception($e->getMessage());
        }
    }
}
