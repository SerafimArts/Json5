<?php

/**
 * This is an automatically generated file, which should not be manually edited.
 *
 * @created 2019-12-04T01:01:43+00:00
 *
 * @see https://github.com/phplrt/phplrt
 * @see https://github.com/phplrt/phplrt/blob/master/LICENSE.md
 */

declare(strict_types=1);

namespace Serafim\Json5;

use Phplrt\Contracts\Lexer\LexerInterface;
use Phplrt\Contracts\Lexer\TokenInterface;
use Phplrt\Contracts\Source\ReadableInterface;
use Phplrt\Lexer\Lexer;
use Phplrt\Parser\Exception\ParserRuntimeException;
use Phplrt\Parser\Builder\BuilderInterface;
use Phplrt\Parser\Rule\RuleInterface;

/**
 * The main class of the generated parser.
 *
 * @package \Serafim\Json5\Parser
 * @generator \Phplrt\Compiler\Generator\ZendGenerator
 */
class Parser extends \Phplrt\Parser\Parser implements
    BuilderInterface
{

    /** @var string */
    public const T_COMMENT = 'T_COMMENT';

    /** @var string */
    public const T_DOC_COMMENT = 'T_DOC_COMMENT';

    /** @var string */
    public const T_BRACKET_OPEN = 'T_BRACKET_OPEN';

    /** @var string */
    public const T_BRACKET_CLOSE = 'T_BRACKET_CLOSE';

    /** @var string */
    public const T_BRACE_OPEN = 'T_BRACE_OPEN';

    /** @var string */
    public const T_BRACE_CLOSE = 'T_BRACE_CLOSE';

    /** @var string */
    public const T_COLON = 'T_COLON';

    /** @var string */
    public const T_COMMA = 'T_COMMA';

    /** @var string */
    public const T_PLUS = 'T_PLUS';

    /** @var string */
    public const T_MINUS = 'T_MINUS';

    /** @var string */
    public const T_BOOL_TRUE = 'T_BOOL_TRUE';

    /** @var string */
    public const T_BOOL_FALSE = 'T_BOOL_FALSE';

    /** @var string */
    public const T_NULL = 'T_NULL';

    /** @var string */
    public const T_INF = 'T_INF';

    /** @var string */
    public const T_NAN = 'T_NAN';

    /** @var string */
    public const T_HEX_NUMBER = 'T_HEX_NUMBER';

    /** @var string */
    public const T_FLOAT_LD_NUMBER = 'T_FLOAT_LD_NUMBER';

    /** @var string */
    public const T_FLOAT_TG_NUMBER = 'T_FLOAT_TG_NUMBER';

    /** @var string */
    public const T_INT_NUMBER = 'T_INT_NUMBER';

    /** @var string */
    public const T_EXPONENT_PART = 'T_EXPONENT_PART';

    /** @var string */
    public const T_IDENTIFIER = 'T_IDENTIFIER';

    /** @var string */
    public const T_DOUBLE_QUOTED_STRING = 'T_DOUBLE_QUOTED_STRING';

    /** @var string */
    public const T_SINGLE_QUOTED_STRING = 'T_SINGLE_QUOTED_STRING';

    /** @var string */
    public const T_HORIZONTAL_TAB = 'T_HORIZONTAL_TAB';

    /** @var string */
    public const T_LINE_FEED = 'T_LINE_FEED';

    /** @var string */
    public const T_VERTICAL_TAB = 'T_VERTICAL_TAB';

    /** @var string */
    public const T_FORM_FEED = 'T_FORM_FEED';

    /** @var string */
    public const T_CARRIAGE_RETURN = 'T_CARRIAGE_RETURN';

    /** @var string */
    public const T_WHITESPACE = 'T_WHITESPACE';

    /** @var string */
    public const T_NON_BREAKING_SPACE = 'T_NON_BREAKING_SPACE';

    /** @var string */
    public const T_LINE_SEPARATOR = 'T_LINE_SEPARATOR';

    /** @var string */
    public const T_PARAGRAPH_SEPARATOR = 'T_PARAGRAPH_SEPARATOR';

    /** @var string */
    public const T_UTF32BE_BOM = 'T_UTF32BE_BOM';

    /** @var string */
    public const T_UTF32LE_BOM = 'T_UTF32LE_BOM';

    /** @var string */
    public const T_UTF16BE_BOM = 'T_UTF16BE_BOM';

    /** @var string */
    public const T_UTF16LE_BOM = 'T_UTF16LE_BOM';

    /** @var string */
    public const T_UTF8_BOM = 'T_UTF8_BOM';

    /** @var string */
    public const T_UTF7_BOM = 'T_UTF7_BOM';

    /**
     * @var string[]
     */
    private const LEXER_TOKENS = [
        self::T_COMMENT => '//[^\\n]*\\n',
        self::T_DOC_COMMENT => '/\\*.*?\\*/',
        self::T_BRACKET_OPEN => '\\[',
        self::T_BRACKET_CLOSE => '\\]',
        self::T_BRACE_OPEN => '{',
        self::T_BRACE_CLOSE => '}',
        self::T_COLON => ':',
        self::T_COMMA => ',',
        self::T_PLUS => '\\+',
        self::T_MINUS => '\\-',
        self::T_BOOL_TRUE => '(?<=\\b)true\\b',
        self::T_BOOL_FALSE => '(?<=\\b)false\\b',
        self::T_NULL => '(?<=\\b)null\\b',
        self::T_INF => '(?<=\\b)Infinity\\b',
        self::T_NAN => '(?<=\\b)NaN\\b',
        self::T_HEX_NUMBER => '0x([0-9a-fA-F]+)',
        self::T_FLOAT_LD_NUMBER => '[0-9]*\\.[0-9]+',
        self::T_FLOAT_TG_NUMBER => '[0-9]+\\.[0-9]*',
        self::T_INT_NUMBER => '[0-9]+',
        self::T_EXPONENT_PART => '[eE]((?:\\-|\\+)?[0-9]+)',
        self::T_IDENTIFIER => '[\\$_A-Za-z][\\$_0-9A-Za-z]*',
        self::T_DOUBLE_QUOTED_STRING => '"([^"\\\\]*(?:\\\\.[^"\\\\]*)*)"',
        self::T_SINGLE_QUOTED_STRING => '\'([^\'\\\\]*(?:\\\\.[^\'\\\\]*)*)\'',
        self::T_HORIZONTAL_TAB => '\\x09',
        self::T_LINE_FEED => '\\x0A',
        self::T_VERTICAL_TAB => '\\x0B',
        self::T_FORM_FEED => '\\x0C',
        self::T_CARRIAGE_RETURN => '\\x0D',
        self::T_WHITESPACE => '\\x20',
        self::T_NON_BREAKING_SPACE => '\\xA0',
        self::T_LINE_SEPARATOR => '\\x2028',
        self::T_PARAGRAPH_SEPARATOR => '\\x2029',
        self::T_UTF32BE_BOM => '^\\x00\\x00\\xFE\\xFF',
        self::T_UTF32LE_BOM => '^\\xFE\\xFF\\x00\\x00',
        self::T_UTF16BE_BOM => '^\\xFE\\xFF',
        self::T_UTF16LE_BOM => '^\\xFF\\xFE',
        self::T_UTF8_BOM => '^\\xEF\\xBB\\xBF',
        self::T_UTF7_BOM => '^\\x2B\\x2F\\x76\\x38\\x2B\\x2F\\x76\\x39\\x2B\\x2F\\x76\\x2B\\x2B\\x2F\\x76\\x2F',
    ];

    /**
     * @var string[]
     */
    private const LEXER_SKIPS = [
        'T_COMMENT',
        'T_DOC_COMMENT',
        'T_HORIZONTAL_TAB',
        'T_LINE_FEED',
        'T_VERTICAL_TAB',
        'T_FORM_FEED',
        'T_CARRIAGE_RETURN',
        'T_WHITESPACE',
        'T_NON_BREAKING_SPACE',
        'T_LINE_SEPARATOR',
        'T_PARAGRAPH_SEPARATOR',
        'T_UTF32BE_BOM',
        'T_UTF32LE_BOM',
        'T_UTF16BE_BOM',
        'T_UTF16LE_BOM',
        'T_UTF8_BOM',
        'T_UTF7_BOM',
    ];


    /**
     * Parser class constructor.
     */
    public function __construct()
    {
        $lexer = new Lexer(self::LEXER_TOKENS, self::LEXER_SKIPS);

        parent::__construct($lexer, $this->grammar(), [
            self::CONFIG_INITIAL_RULE   => 'Json',
            self::CONFIG_AST_BUILDER    => $this,
        ]);
    }

    /**
     * @return array|RuleInterface[]
     */
    private function grammar(): array
    {
        return [
            0 => new \Phplrt\Parser\Rule\Alternation([1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11]),
            1 => new \Phplrt\Parser\Rule\Concatenation([19, 20, 21]),
            2 => new \Phplrt\Parser\Rule\Concatenation([31, 32, 33]),
            3 => new \Phplrt\Parser\Rule\Alternation([36, 37]),
            4 => new \Phplrt\Parser\Rule\Lexeme('T_NULL', true),
            5 => new \Phplrt\Parser\Rule\Lexeme('T_NAN', true),
            6 => new \Phplrt\Parser\Rule\Concatenation([41, 42]),
            7 => new \Phplrt\Parser\Rule\Alternation([34, 35]),
            8 => new \Phplrt\Parser\Rule\Concatenation([41, 49]),
            9 => new \Phplrt\Parser\Rule\Concatenation([47, 48]),
            10 => new \Phplrt\Parser\Rule\Concatenation([41, 45]),
            11 => new \Phplrt\Parser\Rule\Concatenation([41, 46]),
            12 => new \Phplrt\Parser\Rule\Concatenation([23, 24, 0]),
            13 => new \Phplrt\Parser\Rule\Lexeme('T_COMMA', false),
            14 => new \Phplrt\Parser\Rule\Concatenation([13, 12]),
            15 => new \Phplrt\Parser\Rule\Lexeme('T_COMMA', false),
            16 => new \Phplrt\Parser\Rule\Repetition(14, 0, INF),
            17 => new \Phplrt\Parser\Rule\Optional(15),
            18 => new \Phplrt\Parser\Rule\Concatenation([12, 16, 17]),
            19 => new \Phplrt\Parser\Rule\Lexeme('T_BRACE_OPEN', false),
            20 => new \Phplrt\Parser\Rule\Optional(18),
            21 => new \Phplrt\Parser\Rule\Lexeme('T_BRACE_CLOSE', false),
            22 => new \Phplrt\Parser\Rule\Lexeme('T_IDENTIFIER', true),
            23 => new \Phplrt\Parser\Rule\Alternation([7, 22]),
            24 => new \Phplrt\Parser\Rule\Lexeme('T_COLON', false),
            25 => new \Phplrt\Parser\Rule\Lexeme('T_COMMA', false),
            26 => new \Phplrt\Parser\Rule\Concatenation([25, 0]),
            27 => new \Phplrt\Parser\Rule\Lexeme('T_COMMA', false),
            28 => new \Phplrt\Parser\Rule\Repetition(26, 0, INF),
            29 => new \Phplrt\Parser\Rule\Optional(27),
            30 => new \Phplrt\Parser\Rule\Concatenation([0, 28, 29]),
            31 => new \Phplrt\Parser\Rule\Lexeme('T_BRACKET_OPEN', false),
            32 => new \Phplrt\Parser\Rule\Optional(30),
            33 => new \Phplrt\Parser\Rule\Lexeme('T_BRACKET_CLOSE', false),
            34 => new \Phplrt\Parser\Rule\Lexeme('T_DOUBLE_QUOTED_STRING', true),
            35 => new \Phplrt\Parser\Rule\Lexeme('T_SINGLE_QUOTED_STRING', true),
            36 => new \Phplrt\Parser\Rule\Lexeme('T_BOOL_TRUE', true),
            37 => new \Phplrt\Parser\Rule\Lexeme('T_BOOL_FALSE', true),
            38 => new \Phplrt\Parser\Rule\Lexeme('T_PLUS', true),
            39 => new \Phplrt\Parser\Rule\Lexeme('T_MINUS', true),
            40 => new \Phplrt\Parser\Rule\Alternation([38, 39]),
            41 => new \Phplrt\Parser\Rule\Optional(40),
            42 => new \Phplrt\Parser\Rule\Lexeme('T_INF', false),
            43 => new \Phplrt\Parser\Rule\Lexeme('T_FLOAT_LD_NUMBER', true),
            44 => new \Phplrt\Parser\Rule\Lexeme('T_FLOAT_TG_NUMBER', true),
            45 => new \Phplrt\Parser\Rule\Alternation([43, 44]),
            46 => new \Phplrt\Parser\Rule\Lexeme('T_INT_NUMBER', true),
            47 => new \Phplrt\Parser\Rule\Alternation([10, 11]),
            48 => new \Phplrt\Parser\Rule\Lexeme('T_EXPONENT_PART', true),
            49 => new \Phplrt\Parser\Rule\Lexeme('T_HEX_NUMBER', true),
            'Json' => new \Phplrt\Parser\Rule\Concatenation([0]),
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function build(ReadableInterface $file, RuleInterface $rule, TokenInterface $token, $state, $children)
    {
        $offset = $token->getOffset();
        switch (true) {
            case $state === 1:
                return new \Serafim\Json5\Ast\ObjectNode($offset, $children);
            break;
            case $state === 12:
                return new \Serafim\Json5\Ast\ObjectMemberNode($offset, ...$children);
            break;
            case $state === 2:
                return new \Serafim\Json5\Ast\ArrayNode($offset, $children);
            break;
            case $state === 7:
                return new \Serafim\Json5\Ast\StringNode($offset, \substr($children->getValue(), 1, -1));
            break;
            case $state === 3:
                return new \Serafim\Json5\Ast\BooleanNode(
                    $offset,
                    $children->getName() === 'T_BOOL_TRUE'
                );
            break;
            case $state === 4:
                return new \Serafim\Json5\Ast\NullNode($offset);
            break;
            case $state === 22:
                return new \Serafim\Json5\Ast\IdentifierNode($offset, $children->getValue());
            break;
            case $state === 41:
                return \is_array($children) || $children->getName() === 'T_PLUS';
            break;
            case $state === 6:
                return new \Serafim\Json5\Ast\InfinityNumberNode($offset, \reset($children));
            break;
            case $state === 5:
                return new \Serafim\Json5\Ast\NotANumberNode($offset);
            break;
            case $state === 10:
                return new \Serafim\Json5\Ast\FloatNumberNode($offset, \reset($children), \end($children)->getValue());
            break;
            case $state === 11:
                return new \Serafim\Json5\Ast\IntNumberNode($offset, \reset($children), \end($children)->getValue());
            break;
            case $state === 9:
                return new \Serafim\Json5\Ast\ExponentialNumberNode($offset, \reset($children), \end($children)->getValue());
            break;
            case $state === 8:
                return new \Serafim\Json5\Ast\HexadecimalNumberNode($offset, \reset($children), \end($children)->getValue());
            break;
        }

        return null;
    }
}
