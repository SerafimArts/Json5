<?php
return [
    'initial' => 'Json',
    'tokens' => [
        'default' => [
            'T_COMMENT' => '//[^\\n]*\\n',
            'T_DOC_COMMENT' => '/\\*.*?\\*/',
            'T_BRACKET_OPEN' => '\\[',
            'T_BRACKET_CLOSE' => '\\]',
            'T_BRACE_OPEN' => '{',
            'T_BRACE_CLOSE' => '}',
            'T_COLON' => ':',
            'T_COMMA' => ',',
            'T_PLUS' => '\\+',
            'T_MINUS' => '\\-',
            'T_BOOL_TRUE' => '(?<=\\b)true\\b',
            'T_BOOL_FALSE' => '(?<=\\b)false\\b',
            'T_NULL' => '(?<=\\b)null\\b',
            'T_INF' => '(?<=\\b)Infinity\\b',
            'T_NAN' => '(?<=\\b)NaN\\b',
            'T_HEX_NUMBER' => '0x([0-9a-fA-F]+)',
            'T_FLOAT_LD_NUMBER' => '[0-9]*\\.[0-9]+',
            'T_FLOAT_TG_NUMBER' => '[0-9]+\\.[0-9]*',
            'T_INT_NUMBER' => '[0-9]+',
            'T_EXPONENT_PART' => '[eE]((?:\\-|\\+)?[0-9]+)',
            'T_IDENTIFIER' => '[\\$_A-Za-z][\\$_0-9A-Za-z]*',
            'T_DOUBLE_QUOTED_STRING' => '"([^"\\\\]*(?:\\\\.[^"\\\\]*)*)"',
            'T_SINGLE_QUOTED_STRING' => '\'([^\'\\\\]*(?:\\\\.[^\'\\\\]*)*)\'',
            'T_HORIZONTAL_TAB' => '\\x09',
            'T_LINE_FEED' => '\\x0A',
            'T_VERTICAL_TAB' => '\\x0B',
            'T_FORM_FEED' => '\\x0C',
            'T_CARRIAGE_RETURN' => '\\x0D',
            'T_WHITESPACE' => '\\x20',
            'T_NON_BREAKING_SPACE' => '\\xA0',
            'T_LINE_SEPARATOR' => '\\x2028',
            'T_PARAGRAPH_SEPARATOR' => '\\x2029',
            'T_UTF32BE_BOM' => '^\\x00\\x00\\xFE\\xFF',
            'T_UTF32LE_BOM' => '^\\xFE\\xFF\\x00\\x00',
            'T_UTF16BE_BOM' => '^\\xFE\\xFF',
            'T_UTF16LE_BOM' => '^\\xFF\\xFE',
            'T_UTF8_BOM' => '^\\xEF\\xBB\\xBF',
            'T_UTF7_BOM' => '^\\x2B\\x2F\\x76\\x38\\x2B\\x2F\\x76\\x39\\x2B\\x2F\\x76\\x2B\\x2B\\x2F\\x76\\x2F',
        ],
    ],
    'skip' => [
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
    ],
    'transitions' => [
        
    ],
    'grammar' => [
        0 => new \Phplrt\Grammar\Alternation([1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11]),
        'Json' => new \Phplrt\Grammar\Concatenation([0]),
        1 => new \Phplrt\Grammar\Concatenation([19, 20, 21]),
        2 => new \Phplrt\Grammar\Concatenation([31, 32, 33]),
        3 => new \Phplrt\Grammar\Alternation([36, 37]),
        4 => new \Phplrt\Grammar\Lexeme('T_NULL', true),
        5 => new \Phplrt\Grammar\Lexeme('T_NAN', true),
        6 => new \Phplrt\Grammar\Concatenation([41, 42]),
        7 => new \Phplrt\Grammar\Alternation([34, 35]),
        9 => new \Phplrt\Grammar\Concatenation([47, 48]),
        10 => new \Phplrt\Grammar\Concatenation([41, 45]),
        11 => new \Phplrt\Grammar\Concatenation([41, 46]),
        12 => new \Phplrt\Grammar\Concatenation([23, 24, 0]),
        13 => new \Phplrt\Grammar\Lexeme('T_COMMA', false),
        14 => new \Phplrt\Grammar\Concatenation([13, 12]),
        15 => new \Phplrt\Grammar\Lexeme('T_COMMA', false),
        16 => new \Phplrt\Grammar\Repetition(14, 0, INF),
        17 => new \Phplrt\Grammar\Optional(15),
        18 => new \Phplrt\Grammar\Concatenation([12, 16, 17]),
        19 => new \Phplrt\Grammar\Lexeme('T_BRACE_OPEN', false),
        20 => new \Phplrt\Grammar\Optional(18),
        21 => new \Phplrt\Grammar\Lexeme('T_BRACE_CLOSE', false),
        22 => new \Phplrt\Grammar\Lexeme('T_IDENTIFIER', true),
        23 => new \Phplrt\Grammar\Alternation([7, 22]),
        24 => new \Phplrt\Grammar\Lexeme('T_COLON', false),
        25 => new \Phplrt\Grammar\Lexeme('T_COMMA', false),
        26 => new \Phplrt\Grammar\Concatenation([25, 0]),
        27 => new \Phplrt\Grammar\Lexeme('T_COMMA', false),
        28 => new \Phplrt\Grammar\Repetition(26, 0, INF),
        29 => new \Phplrt\Grammar\Optional(27),
        30 => new \Phplrt\Grammar\Concatenation([0, 28, 29]),
        31 => new \Phplrt\Grammar\Lexeme('T_BRACKET_OPEN', false),
        32 => new \Phplrt\Grammar\Optional(30),
        33 => new \Phplrt\Grammar\Lexeme('T_BRACKET_CLOSE', false),
        34 => new \Phplrt\Grammar\Lexeme('T_DOUBLE_QUOTED_STRING', true),
        35 => new \Phplrt\Grammar\Lexeme('T_SINGLE_QUOTED_STRING', true),
        36 => new \Phplrt\Grammar\Lexeme('T_BOOL_TRUE', true),
        37 => new \Phplrt\Grammar\Lexeme('T_BOOL_FALSE', true),
        38 => new \Phplrt\Grammar\Lexeme('T_PLUS', true),
        39 => new \Phplrt\Grammar\Lexeme('T_MINUS', true),
        40 => new \Phplrt\Grammar\Alternation([38, 39]),
        41 => new \Phplrt\Grammar\Optional(40),
        42 => new \Phplrt\Grammar\Lexeme('T_INF', false),
        43 => new \Phplrt\Grammar\Lexeme('T_FLOAT_LD_NUMBER', true),
        44 => new \Phplrt\Grammar\Lexeme('T_FLOAT_TG_NUMBER', true),
        45 => new \Phplrt\Grammar\Alternation([43, 44]),
        46 => new \Phplrt\Grammar\Lexeme('T_INT_NUMBER', true),
        47 => new \Phplrt\Grammar\Alternation([10, 11]),
        48 => new \Phplrt\Grammar\Lexeme('T_EXPONENT_PART', true),
        49 => new \Phplrt\Grammar\Lexeme('T_HEX_NUMBER', true),
        8 => new \Phplrt\Grammar\Concatenation([41, 49])
    ],
    'reducers' => [
        1 => function (\Phplrt\Parser\Context $ctx, $children) {
            $token = $ctx->getToken();
            return new \Serafim\Json5\Ast\ObjectNode($token->getOffset(), $children);
        },
        12 => function (\Phplrt\Parser\Context $ctx, $children) {
            $token = $ctx->getToken();
            return new \Serafim\Json5\Ast\ObjectMemberNode($token->getOffset(), ...$children);
        },
        2 => function (\Phplrt\Parser\Context $ctx, $children) {
            $token = $ctx->getToken();
            return new \Serafim\Json5\Ast\ArrayNode($token->getOffset(), $children);
        },
        7 => function (\Phplrt\Parser\Context $ctx, $children) {
            $token = $ctx->getToken();
            return new \Serafim\Json5\Ast\StringNode($token->getOffset(), \substr($children->getValue(), 1, -1));
        },
        3 => function (\Phplrt\Parser\Context $ctx, $children) {
            $token = $ctx->getToken();
            return new \Serafim\Json5\Ast\BooleanNode($token->getOffset(),
            $children->getName() === 'T_BOOL_TRUE'
        );
        },
        4 => function (\Phplrt\Parser\Context $ctx, $children) {
            $token = $ctx->getToken();
            return new \Serafim\Json5\Ast\NullNode($token->getOffset());
        },
        22 => function (\Phplrt\Parser\Context $ctx, $children) {
            $token = $ctx->getToken();
            return new \Serafim\Json5\Ast\IdentifierNode($token->getOffset(), $children->getValue());
        },
        41 => function (\Phplrt\Parser\Context $ctx, $children) {
            return \is_array($children) || $children->getName() === 'T_PLUS';
        },
        6 => function (\Phplrt\Parser\Context $ctx, $children) {
            $token = $ctx->getToken();
            return new \Serafim\Json5\Ast\InfinityNumberNode($token->getOffset(), \reset($children));
        },
        5 => function (\Phplrt\Parser\Context $ctx, $children) {
            $token = $ctx->getToken();
            return new \Serafim\Json5\Ast\NotANumberNode($token->getOffset());
        },
        10 => function (\Phplrt\Parser\Context $ctx, $children) {
            $token = $ctx->getToken();
            return new \Serafim\Json5\Ast\FloatNumberNode($token->getOffset(), \reset($children), \end($children)->getValue());
        },
        11 => function (\Phplrt\Parser\Context $ctx, $children) {
            $token = $ctx->getToken();
            return new \Serafim\Json5\Ast\IntNumberNode($token->getOffset(), \reset($children), \end($children)->getValue());
        },
        9 => function (\Phplrt\Parser\Context $ctx, $children) {
            $token = $ctx->getToken();
            return new \Serafim\Json5\Ast\ExponentialNumberNode($token->getOffset(), \reset($children), \end($children)->getValue());
        },
        8 => function (\Phplrt\Parser\Context $ctx, $children) {
            $token = $ctx->getToken();
            return new \Serafim\Json5\Ast\HexadecimalNumberNode($token->getOffset(), \reset($children), \end($children)->getValue());
        }
    ]
];