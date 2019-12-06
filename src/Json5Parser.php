<?php

/**
 * This is an automatically GENERATED file, which should not be manually edited.
 *
 * @created 2019-12-06T20:45:54+03:00
 * @see https://github.com/phplrt/phplrt
 * @see https://github.com/phplrt/phplrt/blob/master/LICENSE.md
 * @since 2.3
 */

declare(strict_types=1);

namespace Serafim\Json5;

use Phplrt\Lexer\Lexer;
use Phplrt\Parser\Parser;
use Phplrt\Position\Position;
use Phplrt\Contracts\Lexer\LexerInterface;
use Serafim\Json5\Exception\Json5Exception;
use Phplrt\Contracts\Parser\ParserInterface;
use Phplrt\Contracts\Source\ReadableInterface;
use Phplrt\Contracts\Lexer\Exception\LexerExceptionInterface;
use Phplrt\Contracts\Lexer\Exception\LexerRuntimeExceptionInterface;
use Phplrt\Contracts\Parser\Exception\ParserRuntimeExceptionInterface;

/**
 * Class Json5Parser
 */
final class Json5Parser implements ParserInterface, LexerInterface
{
    /**
     * @var Parser
     */
    private $parser;

    /**
     * @var Lexer
     */
    private $lexer;

    /**
     * Parser constructor.
     */
    public function __construct()
    {
        $grammar = new Json5Grammar();

        $this->lexer = new Lexer($grammar->lexemes, $grammar->skips);

        $this->parser = new Parser($this, $grammar->grammar, [
            Parser::CONFIG_AST_BUILDER  => new Json5Builder(function (\Throwable $e, $file, $rule, $token, $state) {
                $message = 'An internal parsing error occurs on line %d at column %d (state %s)';
                $position = Position::fromOffset($file, $token->getOffset());

                return new Json5Exception(\vsprintf($message, [
                    $position->getLine(),
                    $position->getColumn(),
                    $state
                ]), 0, $e);
            }),
            Parser::CONFIG_INITIAL_RULE => $grammar->initial,
        ]);
    }

    /**
     * {@inheritDoc}
     * @throws LexerExceptionInterface
     */
    public function lex($source, int $offset = 0): iterable
    {
        return $this->lexer->lex($source, $offset);
    }

    /**
     * {@inheritDoc}
     * @throws \Throwable
     */
    public function parse($source): iterable
    {
        return $this->parser->parse($source);
    }
}
