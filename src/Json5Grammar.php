<?php

/**
 * This is an automatically GENERATED file, which should not be manually edited.
 *
 * @created 2019-12-06T21:15:54+03:00
 * @since 2.3
 * @see https://github.com/phplrt/phplrt
 * @see https://github.com/phplrt/phplrt/blob/master/LICENSE.md
 */

declare(strict_types=1);

namespace Serafim\Json5;

/**
 * Note: This class was automatically imported from Phplrt\Grammar\Rule
 * @created 2019-12-06T21:15:54+03:00
 * @internal this class for internal usage only
 * @package Phplrt\Grammar\Rule
 * @generator \Phplrt\Compiler\Generator\ZendGenerator
 */
abstract class __Rule3c8d1b93 implements \Phplrt\Contracts\Grammar\RuleInterface
{
}

/**
 * Note: This class was automatically imported from Phplrt\Grammar\Production
 * @created 2019-12-06T21:15:54+03:00
 * @internal this class for internal usage only
 * @package Phplrt\Grammar\Production
 * @generator \Phplrt\Compiler\Generator\ZendGenerator
 */
abstract class __Productione7c9e45a extends __Rule3c8d1b93 implements \Phplrt\Contracts\Grammar\ProductionInterface
{
    protected function mergeWith(array $children, $result) : array
    {
        if (\is_array($result)) {
            return \array_merge($children, $result);
        }
        $children[] = $result;
        return $children;
    }
}

/**
 * Note: This class was automatically imported from Phplrt\Grammar\Terminal
 * @created 2019-12-06T21:15:54+03:00
 * @internal this class for internal usage only
 * @package Phplrt\Grammar\Terminal
 * @generator \Phplrt\Compiler\Generator\ZendGenerator
 */
abstract class __Terminalaed1f05a extends __Rule3c8d1b93 implements \Phplrt\Contracts\Grammar\TerminalInterface
{
    protected $keep = true;
    public function __construct(bool $keep)
    {
        $this->keep = $keep;
    }
    public function isKeep() : bool
    {
        return $this->keep;
    }
}

/**
 * Note: This class was automatically imported from Phplrt\Grammar\Alternation
 * @created 2019-12-06T21:15:54+03:00
 * @internal this class for internal usage only
 * @package Phplrt\Grammar\Alternation
 * @generator \Phplrt\Compiler\Generator\ZendGenerator
 */
final class __Alternation6353ccf4 extends __Productione7c9e45a
{
    public $sequence;
    public function __construct(array $sequence)
    {
        $this->sequence = $sequence;
    }
    public function getConstructorArguments() : array
    {
        return [$this->sequence];
    }
    public function reduce(\Phplrt\Contracts\Lexer\BufferInterface $buffer, \Closure $reduce)
    {
        $rollback = $buffer->key();
        foreach ($this->sequence as $rule) {
            if (($result = $reduce($rule)) !== null) {
                return $result;
            }
            $buffer->seek($rollback);
        }
        return null;
    }
}

/**
 * Note: This class was automatically imported from Phplrt\Grammar\Concatenation
 * @created 2019-12-06T21:15:54+03:00
 * @internal this class for internal usage only
 * @package Phplrt\Grammar\Concatenation
 * @generator \Phplrt\Compiler\Generator\ZendGenerator
 */
final class __Concatenation961e42e5 extends __Productione7c9e45a
{
    public $sequence;
    public function __construct(array $sequence)
    {
        $this->sequence = $sequence;
    }
    public function getConstructorArguments() : array
    {
        return [$this->sequence];
    }
    public function reduce(\Phplrt\Contracts\Lexer\BufferInterface $buffer, \Closure $reduce) : ?iterable
    {
        [$revert, $children] = [$buffer->key(), []];
        foreach ($this->sequence as $rule) {
            if (($result = $reduce($rule)) === null) {
                $buffer->seek($revert);
                return null;
            }
            $children = $this->mergeWith($children, $result);
        }
        return $children;
    }
}

/**
 * Note: This class was automatically imported from Phplrt\Grammar\Lexeme
 * @created 2019-12-06T21:15:54+03:00
 * @internal this class for internal usage only
 * @package Phplrt\Grammar\Lexeme
 * @generator \Phplrt\Compiler\Generator\ZendGenerator
 */
final class __Lexeme37222a0f extends __Terminalaed1f05a
{
    public $token;
    public function __construct($token, bool $keep = true)
    {
        parent::__construct($keep);
        $this->token = $token;
    }
    public function getConstructorArguments() : array
    {
        return [$this->token, $this->keep];
    }
    public function reduce(\Phplrt\Contracts\Lexer\BufferInterface $buffer) : ?\Phplrt\Contracts\Lexer\TokenInterface
    {
        $haystack = $buffer->current();
        if ($haystack->getName() === $this->token) {
            return $haystack;
        }
        return null;
    }
}

/**
 * Note: This class was automatically imported from Phplrt\Grammar\Repetition
 * @created 2019-12-06T21:15:54+03:00
 * @internal this class for internal usage only
 * @package Phplrt\Grammar\Repetition
 * @generator \Phplrt\Compiler\Generator\ZendGenerator
 */
final class __Repetition5e3fbce8 extends __Productione7c9e45a
{
    public $gte;
    public $lte;
    public $rule;
    public function __construct($rule, int $gte = 0, float $lte = \INF)
    {
        \assert($lte >= $gte, 'Min repetitions count must be greater or equal than max repetitions');
        $this->rule = $rule;
        $this->gte = $gte;
        $this->lte = \is_infinite($lte) ? INF : (int) $lte;
    }
    public function getConstructorArguments() : array
    {
        return [$this->rule, $this->gte, $this->lte];
    }
    public function reduce(\Phplrt\Contracts\Lexer\BufferInterface $buffer, \Closure $reduce) : ?iterable
    {
        [$children, $iterations] = [[], 0];
        $global = $buffer->key();
        do {
            $inRange = $iterations >= $this->gte && $iterations <= $this->lte;
            $rollback = $buffer->key();
            if (($result = $reduce($this->rule)) === null) {
                if (!$inRange) {
                    $buffer->seek($global);
                    return null;
                }
                $buffer->seek($rollback);
                return $children;
            }
            $children = $this->mergeWith($children, $result);
        } while ($result !== null && ++$iterations);
        return $children;
    }
}

/**
 * Note: This class was automatically imported from Phplrt\Grammar\Optional
 * @created 2019-12-06T21:15:54+03:00
 * @internal this class for internal usage only
 * @package Phplrt\Grammar\Optional
 * @generator \Phplrt\Compiler\Generator\ZendGenerator
 */
final class __Optional642414e5 extends __Productione7c9e45a
{
    public $rule;
    public function __construct($rule)
    {
        $this->rule = $rule;
    }
    public function getConstructorArguments() : array
    {
        return [$this->rule];
    }
    public function reduce(\Phplrt\Contracts\Lexer\BufferInterface $buffer, \Closure $reduce)
    {
        $rollback = $buffer->key();
        if (($result = $reduce($this->rule)) !== null) {
            return $result;
        }
        $buffer->seek($rollback);
        return [];
    }
}


/**
 * The main generated grammar class.
 *
 * @package Phplrt\Grammar\Optional
 * @generator \Phplrt\Compiler\Generator\ZendGenerator
 */
final class Json5Grammar
{
    /**
     * A lexical token name
     * @see Json5Grammar::$lexemes
     * @var string
     */
    public const T_COMMENT = 'T_COMMENT';

    /**
     * A lexical token name
     * @see Json5Grammar::$lexemes
     * @var string
     */
    public const T_DOC_COMMENT = 'T_DOC_COMMENT';

    /**
     * A lexical token name
     * @see Json5Grammar::$lexemes
     * @var string
     */
    public const T_BRACKET_OPEN = 'T_BRACKET_OPEN';

    /**
     * A lexical token name
     * @see Json5Grammar::$lexemes
     * @var string
     */
    public const T_BRACKET_CLOSE = 'T_BRACKET_CLOSE';

    /**
     * A lexical token name
     * @see Json5Grammar::$lexemes
     * @var string
     */
    public const T_BRACE_OPEN = 'T_BRACE_OPEN';

    /**
     * A lexical token name
     * @see Json5Grammar::$lexemes
     * @var string
     */
    public const T_BRACE_CLOSE = 'T_BRACE_CLOSE';

    /**
     * A lexical token name
     * @see Json5Grammar::$lexemes
     * @var string
     */
    public const T_COLON = 'T_COLON';

    /**
     * A lexical token name
     * @see Json5Grammar::$lexemes
     * @var string
     */
    public const T_COMMA = 'T_COMMA';

    /**
     * A lexical token name
     * @see Json5Grammar::$lexemes
     * @var string
     */
    public const T_PLUS = 'T_PLUS';

    /**
     * A lexical token name
     * @see Json5Grammar::$lexemes
     * @var string
     */
    public const T_MINUS = 'T_MINUS';

    /**
     * A lexical token name
     * @see Json5Grammar::$lexemes
     * @var string
     */
    public const T_BOOL_TRUE = 'T_BOOL_TRUE';

    /**
     * A lexical token name
     * @see Json5Grammar::$lexemes
     * @var string
     */
    public const T_BOOL_FALSE = 'T_BOOL_FALSE';

    /**
     * A lexical token name
     * @see Json5Grammar::$lexemes
     * @var string
     */
    public const T_NULL = 'T_NULL';

    /**
     * A lexical token name
     * @see Json5Grammar::$lexemes
     * @var string
     */
    public const T_INF = 'T_INF';

    /**
     * A lexical token name
     * @see Json5Grammar::$lexemes
     * @var string
     */
    public const T_NAN = 'T_NAN';

    /**
     * A lexical token name
     * @see Json5Grammar::$lexemes
     * @var string
     */
    public const T_HEX_NUMBER = 'T_HEX_NUMBER';

    /**
     * A lexical token name
     * @see Json5Grammar::$lexemes
     * @var string
     */
    public const T_FLOAT_LD_NUMBER = 'T_FLOAT_LD_NUMBER';

    /**
     * A lexical token name
     * @see Json5Grammar::$lexemes
     * @var string
     */
    public const T_FLOAT_TG_NUMBER = 'T_FLOAT_TG_NUMBER';

    /**
     * A lexical token name
     * @see Json5Grammar::$lexemes
     * @var string
     */
    public const T_INT_NUMBER = 'T_INT_NUMBER';

    /**
     * A lexical token name
     * @see Json5Grammar::$lexemes
     * @var string
     */
    public const T_EXPONENT_PART = 'T_EXPONENT_PART';

    /**
     * A lexical token name
     * @see Json5Grammar::$lexemes
     * @var string
     */
    public const T_IDENTIFIER = 'T_IDENTIFIER';

    /**
     * A lexical token name
     * @see Json5Grammar::$lexemes
     * @var string
     */
    public const T_DOUBLE_QUOTED_STRING = 'T_DOUBLE_QUOTED_STRING';

    /**
     * A lexical token name
     * @see Json5Grammar::$lexemes
     * @var string
     */
    public const T_SINGLE_QUOTED_STRING = 'T_SINGLE_QUOTED_STRING';

    /**
     * A lexical token name
     * @see Json5Grammar::$lexemes
     * @var string
     */
    public const T_HORIZONTAL_TAB = 'T_HORIZONTAL_TAB';

    /**
     * A lexical token name
     * @see Json5Grammar::$lexemes
     * @var string
     */
    public const T_LINE_FEED = 'T_LINE_FEED';

    /**
     * A lexical token name
     * @see Json5Grammar::$lexemes
     * @var string
     */
    public const T_VERTICAL_TAB = 'T_VERTICAL_TAB';

    /**
     * A lexical token name
     * @see Json5Grammar::$lexemes
     * @var string
     */
    public const T_FORM_FEED = 'T_FORM_FEED';

    /**
     * A lexical token name
     * @see Json5Grammar::$lexemes
     * @var string
     */
    public const T_CARRIAGE_RETURN = 'T_CARRIAGE_RETURN';

    /**
     * A lexical token name
     * @see Json5Grammar::$lexemes
     * @var string
     */
    public const T_WHITESPACE = 'T_WHITESPACE';

    /**
     * A lexical token name
     * @see Json5Grammar::$lexemes
     * @var string
     */
    public const T_NON_BREAKING_SPACE = 'T_NON_BREAKING_SPACE';

    /**
     * A lexical token name
     * @see Json5Grammar::$lexemes
     * @var string
     */
    public const T_LINE_SEPARATOR = 'T_LINE_SEPARATOR';

    /**
     * A lexical token name
     * @see Json5Grammar::$lexemes
     * @var string
     */
    public const T_PARAGRAPH_SEPARATOR = 'T_PARAGRAPH_SEPARATOR';

    /**
     * A lexical token name
     * @see Json5Grammar::$lexemes
     * @var string
     */
    public const T_UTF32BE_BOM = 'T_UTF32BE_BOM';

    /**
     * A lexical token name
     * @see Json5Grammar::$lexemes
     * @var string
     */
    public const T_UTF32LE_BOM = 'T_UTF32LE_BOM';

    /**
     * A lexical token name
     * @see Json5Grammar::$lexemes
     * @var string
     */
    public const T_UTF16BE_BOM = 'T_UTF16BE_BOM';

    /**
     * A lexical token name
     * @see Json5Grammar::$lexemes
     * @var string
     */
    public const T_UTF16LE_BOM = 'T_UTF16LE_BOM';

    /**
     * A lexical token name
     * @see Json5Grammar::$lexemes
     * @var string
     */
    public const T_UTF8_BOM = 'T_UTF8_BOM';

    /**
     * A lexical token name
     * @see Json5Grammar::$lexemes
     * @var string
     */
    public const T_UTF7_BOM = 'T_UTF7_BOM';

    /**
     * A parser's rule name
     * @see Json5Grammar::$rules
     * @see Json5Grammar::__construct
     * @var string
     */
    public const JSON = 'Json';

    /**
     * @var string|int
     */
    public $initial = self::JSON;

    /**
     * @var array|string[]
     */
    public $lexemes = [
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
     * @var array|string[]
     * @psalm-var array<string>
     */
    public $skips = [
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
     * @var array|\Phplrt\Contracts\Grammar\RuleInterface[]
     * @psalm-var array<\Phplrt\Contracts\Grammar\RuleInterface>
     */
    public $grammar = [];

    /**
     * Json5Grammar constructor.
     */
    final public function __construct()
    {
        $this->grammar = [
            0 => new __Alternation6353ccf4([1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11]),
            1 => new __Concatenation961e42e5([19, 20, 21]),
            2 => new __Concatenation961e42e5([31, 32, 33]),
            3 => new __Alternation6353ccf4([36, 37]),
            4 => new __Lexeme37222a0f('T_NULL', true),
            5 => new __Lexeme37222a0f('T_NAN', true),
            6 => new __Concatenation961e42e5([41, 42]),
            7 => new __Alternation6353ccf4([34, 35]),
            8 => new __Concatenation961e42e5([41, 49]),
            9 => new __Concatenation961e42e5([47, 48]),
            10 => new __Concatenation961e42e5([41, 45]),
            11 => new __Concatenation961e42e5([41, 46]),
            12 => new __Concatenation961e42e5([23, 24, 0]),
            13 => new __Lexeme37222a0f('T_COMMA', false),
            14 => new __Concatenation961e42e5([13, 12]),
            15 => new __Lexeme37222a0f('T_COMMA', false),
            16 => new __Repetition5e3fbce8(14, 0, INF),
            17 => new __Optional642414e5(15),
            18 => new __Concatenation961e42e5([12, 16, 17]),
            19 => new __Lexeme37222a0f('T_BRACE_OPEN', false),
            20 => new __Optional642414e5(18),
            21 => new __Lexeme37222a0f('T_BRACE_CLOSE', false),
            22 => new __Lexeme37222a0f('T_IDENTIFIER', true),
            23 => new __Alternation6353ccf4([7, 22]),
            24 => new __Lexeme37222a0f('T_COLON', false),
            25 => new __Lexeme37222a0f('T_COMMA', false),
            26 => new __Concatenation961e42e5([25, 0]),
            27 => new __Lexeme37222a0f('T_COMMA', false),
            28 => new __Repetition5e3fbce8(26, 0, INF),
            29 => new __Optional642414e5(27),
            30 => new __Concatenation961e42e5([0, 28, 29]),
            31 => new __Lexeme37222a0f('T_BRACKET_OPEN', false),
            32 => new __Optional642414e5(30),
            33 => new __Lexeme37222a0f('T_BRACKET_CLOSE', false),
            34 => new __Lexeme37222a0f('T_DOUBLE_QUOTED_STRING', true),
            35 => new __Lexeme37222a0f('T_SINGLE_QUOTED_STRING', true),
            36 => new __Lexeme37222a0f('T_BOOL_TRUE', true),
            37 => new __Lexeme37222a0f('T_BOOL_FALSE', true),
            38 => new __Lexeme37222a0f('T_PLUS', true),
            39 => new __Lexeme37222a0f('T_MINUS', true),
            40 => new __Alternation6353ccf4([38, 39]),
            41 => new __Optional642414e5(40),
            42 => new __Lexeme37222a0f('T_INF', false),
            43 => new __Lexeme37222a0f('T_FLOAT_LD_NUMBER', true),
            44 => new __Lexeme37222a0f('T_FLOAT_TG_NUMBER', true),
            45 => new __Alternation6353ccf4([43, 44]),
            46 => new __Lexeme37222a0f('T_INT_NUMBER', true),
            47 => new __Alternation6353ccf4([10, 11]),
            48 => new __Lexeme37222a0f('T_EXPONENT_PART', true),
            49 => new __Lexeme37222a0f('T_HEX_NUMBER', true),
            self::JSON => new __Concatenation961e42e5([0]),
        ];
    }
}

