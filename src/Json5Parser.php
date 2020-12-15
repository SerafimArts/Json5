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

use Phplrt\Contracts\Lexer\LexerInterface;
use Phplrt\Contracts\Parser\ParserInterface;
use Phplrt\Lexer\Lexer;
use Phplrt\Parser\BuilderInterface;
use Phplrt\Parser\ContextInterface;
use Phplrt\Parser\Parser;

final class Json5Parser implements ParserInterface, LexerInterface
{
    /**
     * @var string
     */
    private const GRAMMAR_FILE = __DIR__ . '/../resources/grammar.php';

    /**
     * @var ParserInterface
     */
    private ParserInterface $parser;

    /**
     * @var LexerInterface
     */
    private LexerInterface $lexer;

    /**
     * Parser constructor.
     */
    public function __construct()
    {
        $grammar = require self::GRAMMAR_FILE;

        $this->lexer = new Lexer($grammar['tokens']['default'], $grammar['skip']);

        $this->parser = new Parser($this->lexer, $grammar['grammar'], [
            Parser::CONFIG_INITIAL_RULE => $grammar['initial'],
            Parser::CONFIG_AST_BUILDER  => new class($grammar['reducers']) implements BuilderInterface {
                private array $reducers;

                public function __construct(array $reducers)
                {
                    $this->reducers = $reducers;
                }

                public function build(ContextInterface $context, $result)
                {
                    $state = $context->getState();

                    if (isset($this->reducers[$state])) {
                        return $this->reducers[$state]($context, $result);
                    }

                    return null;
                }
            },
        ]);
    }

    /**
     * {@inheritDoc}
     */
    public function lex($source, int $offset = 0): iterable
    {
        return $this->lexer->lex($source, $offset);
    }

    /**
     * {@inheritDoc}
     * @throws \Throwable
     */
    public function parse($source, array $options = []): iterable
    {
        return $this->parser->parse($source);
    }
}
