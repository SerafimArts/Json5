<?php

/**
 * This file is part of json5 package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Serafim\Json5\Internal;

use Phplrt\Contracts\Grammar\RuleInterface;
use Phplrt\Contracts\Lexer\LexerInterface;
use Phplrt\Contracts\Parser\ParserInterface;
use Phplrt\Lexer\Lexer;
use Phplrt\Parser\BuilderInterface;
use Phplrt\Parser\ContextInterface;
use Phplrt\Parser\Parser;
use Phplrt\Parser\ParserConfigsInterface;
use Phplrt\Parser\Context;

/**
 * @psalm-type Json5GrammarReducers = array<array-key, callable(Context,mixed):mixed>
 * @psalm-type Json5Grammar = array {
 *  initial: non-empty-string,
 *  tokens: array<non-empty-string, array<non-empty-string, non-empty-string>>,
 *  skip: array<non-empty-string>,
 *  transitions: array<non-empty-string, non-empty-string>,
 *  grammar: array<array-key, RuleInterface>,
 *  reducers: Json5GrammarReducers
 * }
 *
 * @see RuleInterface
 * @see Context
 * @internal This is an internal library class, please do not use it in your code.
 * @psalm-internal Serafim\Json5
 */
final class Json5Parser implements
    ParserInterface,
    LexerInterface,
    BuilderInterface
{
    /**
     * @psalm-taint-sink file
     * @var non-empty-string
     */
    private const GRAMMAR_FILE = __DIR__ . '/../../resources/grammar.php';

    /**
     * @var ParserInterface
     */
    private ParserInterface $parser;

    /**
     * @var LexerInterface
     */
    private LexerInterface $lexer;

    /**
     * @var Json5GrammarReducers
     */
    private array $reducers;

    public function __construct()
    {
        $grammar = $this->load();

        $this->reducers = $grammar['reducers'];
        $this->lexer = new Lexer($grammar['tokens']['default'], $grammar['skip']);
        $this->parser = new Parser($this->lexer, $grammar['grammar'], [
            ParserConfigsInterface::CONFIG_INITIAL_RULE => $grammar['initial'],
            ParserConfigsInterface::CONFIG_AST_BUILDER  => $this,
        ]);
    }

    /**
     * @return Json5Grammar
     */
    private function load(): array
    {
        return require self::GRAMMAR_FILE;
    }

    /**
     * @param ContextInterface $context
     * @param mixed $result
     * @return mixed|null
     */
    public function build(ContextInterface $context, $result)
    {
        $state = $context->getState();

        if (isset($this->reducers[$state])) {
            return $this->reducers[$state]($context, $result);
        }

        return null;
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
