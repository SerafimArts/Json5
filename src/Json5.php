<?php

/**
 * This file is part of Json5 package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Serafim\Json5;

use JetBrains\PhpStorm\Language;
use Phplrt\Contracts\Parser\ParserInterface;
use Phplrt\Contracts\Position\PositionInterface;
use Phplrt\Exception\RuntimeException;
use Phplrt\Position\Position;
use Serafim\Json5\Ast\JsonNodeInterface;
use Serafim\Json5\Exception\Json5Exception;

/**
 * Class Json5
 */
class Json5 implements Json5EncoderInterface, Json5DecoderInterface
{
    /**
     * @var int
     */
    public const DEFAULT_JSON_RECURSION_DEPTH = 512;

    /**
     * @var self|null
     */
    private static ?self $instance = null;

    /**
     * @var ParserInterface
     */
    private ParserInterface $parser;

    /**
     * @var int
     */
    private int $depth = self::DEFAULT_JSON_RECURSION_DEPTH;

    /**
     * Json5 constructor.
     */
    private function __construct()
    {
        $this->parser = new Json5Parser();
    }

    /**
     * @return static
     */
    public static function getInstance(): self
    {
        return self::$instance ?? self::$instance = new static();
    }

    /**
     * @param int $depth
     * @return $this
     * @throws Json5Exception
     */
    public function withDepth(int $depth): self
    {
        if ($depth <= 0) {
            throw new Json5Exception('Depth must be greater than zero');
        }

        if ($this->depth === $depth) {
            return $this;
        }

        $self = clone $this;
        $self->depth = $depth;

        return $self;
    }

    /**
     * {@inheritDoc}
     * @throws \Throwable
     */
    public function decode(
        #[Language('JSON5')]
        string $json,
        int $options = 0
    ) {
        try {
            /** @psalm-var array<array-key, JsonNodeInterface> $result */
            $result = $this->parser->parse($json);

            if (($ast = \reset($result)) instanceof JsonNodeInterface) {
                return $ast->reduce($options, 0, $this->depth);
            }

            throw new \RuntimeException('There is an internal error occurred');
        } catch (RuntimeException $e) {
            $token = $e->getToken();
            $position = Position::fromOffset($json, $token->getOffset());

            throw $this->json5Error($e, $position);
        }
    }

    /**
     * @param \Throwable $e
     * @param PositionInterface $position
     * @return Json5Exception
     */
    private function json5Error(\Throwable $e, PositionInterface $position): Json5Exception
    {
        $message = \vsprintf(
            '%s on line %d at column %d',
            [
                $e->getMessage(),
                $position->getLine(),
                $position->getColumn(),
            ]
        );

        return new Json5Exception($message);
    }

    /**
     * {@inheritDoc}
     */
    public function encode($value, int $options = 0): string
    {
        try {
            // TODO
            return \json_encode($value, $options | \JSON_THROW_ON_ERROR, $this->depth);
        } catch (\Throwable $e) {
            throw new Json5Exception($e->getMessage());
        }
    }
}
