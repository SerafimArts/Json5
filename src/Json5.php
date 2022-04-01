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
use Phplrt\Contracts\Parser\ParserInterface;
use Phplrt\Contracts\Position\PositionInterface;
use Phplrt\Exception\RuntimeException;
use Phplrt\Position\Position;
use Serafim\Json5\Ast\JsonNodeInterface;
use Serafim\Json5\Ast\Node;
use Serafim\Json5\Exception\Json5Exception;
use Serafim\Json5\Internal\Context;
use Serafim\Json5\Internal\Json5Parser;

final class Json5 implements Json5EncoderInterface, Json5DecoderInterface
{
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

        return match ($json) {
            '' => null,
            'true' => true,
            'false' => false,
            default => self::eval($json, new Context(
                maxDepth: $depth,
                options: $options,
            ))
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
        $parser = new Json5Parser();

        try {
            /** @psalm-var array<array-key, Node> $result */
            $result = $parser->parse($json);

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
