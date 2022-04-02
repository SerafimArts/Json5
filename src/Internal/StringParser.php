<?php

/**
 * This file is part of json5 package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Serafim\Json5\Internal;

use Phplrt\Contracts\Exception\RuntimeExceptionInterface;
use Phplrt\Lexer\Lexer;
use Phplrt\Lexer\Token\Composite;
use Phplrt\Contracts\Lexer\LexerInterface;
use Phplrt\Contracts\Lexer\TokenInterface;
use Serafim\Json5\DecodeFlag;

final class StringParser
{
    /**
     * @var string[]
     */
    protected const LEXEMES = [
        self::T_ESCAPED_BACK_SLASH => '\\\\\\\\',
        self::T_UNICODE_4B_CHAR    => '\\\\u([0-9A-Fa-f]{4})',
        self::T_UNICODE_2B_CHAR    => '\\\\x([0-9A-Fa-f]{2})',
        self::T_NEW_LINE           => '\\\\n',
        self::T_BACKSPACE          => '\\\\b',
        self::T_FORM_FEED          => '\\\\f',
        self::T_CARRIAGE_RETURN    => '\\\\r',
        self::T_HORIZONTAL_TAB     => '\\\\t',
        self::T_VERTICAL_TAB       => '\\\\v',
        self::T_ESCAPED_QUOTE      => '\\\\"',
        self::T_BACK_SLASH         => '\\\\',
        self::T_FORWARD_SLASH      => '/',
        self::T_TEXT               => '[^\\\\]+',
    ];

    /**
     * @var string[]
     */
    protected const SPECIAL_CHARS = [
        self::T_BACKSPACE          => "\u{0008}",  /* '\b' */
        self::T_FORM_FEED          => "\u{000C}",  /* '\f' */
        self::T_NEW_LINE           => "\u{000A}",  /* '\n' */
        self::T_CARRIAGE_RETURN    => "\u{000D}",  /* '\r' */
        self::T_HORIZONTAL_TAB     => "\u{0009}",  /* '\t' */
        self::T_VERTICAL_TAB       => "\u{000B}",  /* '\v' */
        self::T_ESCAPED_QUOTE      => '"',         /* '\"' */
        self::T_ESCAPED_BACK_SLASH => '\\',        /* '\\' */
    ];

    /**
     * An escaped 4b unicode character sequence.
     *
     * @var string
     */
    private const T_UNICODE_4B_CHAR = 'T_UNICODE_4B_CHAR';

    /**
     * An escaped 2b unicode character sequence.
     *
     * @var string
     */
    private const T_UNICODE_2B_CHAR = 'T_UNICODE_2B_CHAR';

    /**
     * A "line feed" character (U+000A)
     *
     * @var string
     */
    private const T_NEW_LINE = 'T_NEW_LINE';

    /**
     * A "backspace" character (U+0008)
     *
     * @var string
     */
    private const T_BACKSPACE = 'T_BACKSPACE';

    /**
     * A "form feed" character (U+000C)
     *
     * @var string
     */
    private const T_FORM_FEED = 'T_FORM_FEED';

    /**
     * A "carriage return" character (U+000D)
     *
     * @var string
     */
    private const T_CARRIAGE_RETURN = 'T_CARRIAGE_RETURN';

    /**
     * A "horizontal tab" character (U+0009)
     *
     * @var string
     */
    private const T_HORIZONTAL_TAB = 'T_HORIZONTAL_TAB';

    /**
     * A "vertical tab" character (U+000B)
     *
     * @var string
     */
    private const T_VERTICAL_TAB = 'T_VERTICAL_TAB';

    /**
     * A "back slash" character (reverse solidus: U+005C)
     *
     * @var string
     */
    private const T_BACK_SLASH = 'T_BACK_SLASH';

    /**
     * A "forward slash" character (solidus: U+002F)
     *
     * @var string
     */
    private const T_FORWARD_SLASH = 'T_FORWARD_SLASH';

    /**
     * An escaped double quote character (U+005C U+0022)
     *
     * @var string
     */
    private const T_ESCAPED_QUOTE = 'T_ESCAPED_QUOTE';

    /**
     * An escaped back slash character (U+005C U+005C)
     *
     * @var string
     */
    private const T_ESCAPED_BACK_SLASH = 'T_ESCAPED_BACK_SLASH';

    /**
     * Basic text which should not be processed in any way.
     *
     * @var string
     */
    private const T_TEXT = 'T_TEXT';

    /**
     * @var non-empty-string
     */
    private const INVALID_UNICODE_CHAR = '�';

    /**
     * @var LexerInterface
     */
    private LexerInterface $lexer;

    public function __construct()
    {
        $this->lexer = new Lexer(self::LEXEMES);
    }

    /**
     * @param string $value
     * @param Context $context
     * @return string
     * @throws RuntimeExceptionInterface
     * @throws \Throwable
     */
    public function decode(string $value, Context $context): string
    {
        $result = '';
        $value = \str_replace(["\\\n", "\\\r\n"], '', $value);

        foreach ($this->lexer->lex($value) as $token) {
            $result .= $this->map($token, $context);
        }

        return $result;
    }

    /**
     * @param TokenInterface $token
     * @param Context $context
     * @return string
     * @throws \Throwable
     */
    protected function map(TokenInterface $token, Context $context): string
    {
        switch ($token->getName()) {
            case TokenInterface::END_OF_INPUT:
                return '';

            case self::T_UNICODE_4B_CHAR:
                assert($token instanceof Composite);
                assert($token[0] !== null);

                return $this->unicode($token[0]->getValue(), $context);

            case self::T_UNICODE_2B_CHAR:
                assert($token instanceof Composite);
                assert($token[0] !== null);

                return $this->unicode('00' . $token[0]->getValue(), $context);

            default:
                return self::SPECIAL_CHARS[$token->getName()] ?? $token->getValue();
        }
    }

    /**
     * Method for parsing and decode utf-8 character
     * sequences like "\uXXXX" type.
     *
     * @see https://spec.json5.org/#escapes
     *
     * @param string $char
     * @param Context $context
     * @return string
     * @throws \Throwable
     */
    private function unicode(string $char, Context $context): string
    {
        try {
            return \mb_convert_encoding(\pack('H*', $char), 'UTF-8', 'UCS-2BE');
        } catch (\Throwable $e) {
            return match (true) {
                ($context->options & DecodeFlag::JSON5_INVALID_UTF8_SUBSTITUTE)
                    === DecodeFlag::JSON5_INVALID_UTF8_SUBSTITUTE => self::INVALID_UNICODE_CHAR,
                ($context->options & DecodeFlag::JSON5_INVALID_UTF8_IGNORE)
                    === DecodeFlag::JSON5_INVALID_UTF8_IGNORE => '',
                default => throw $e,
            };
        }
    }
}
