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

use Phplrt\Contracts\Lexer\TokenInterface;
use Phplrt\Contracts\Grammar\RuleInterface;
use Phplrt\Contracts\Source\ReadableInterface;

/**
 * The main AST Builder class.
 *
 * @package Serafim\Json5\Json5Builder
 * @generator \Phplrt\Compiler\Generator\ZendGenerator
 */
final class Json5Builder implements \Phplrt\Parser\Builder\BuilderInterface
{
    /**
     * @var \Closure|null
     */
    private $onError;

    /**
     * @var \Closure|null
     */
    private $after;

    /**
     * JsonBuilder constructor.
     *
     * @param \Closure|null $onError
     * @param \Closure|null $after
     */
    public function __construct(\Closure $onError = null, \Closure $after = null)
    {
        $this->after = $after ?? static function ($node) {
            return $node;
        };

        $this->onError = $onError ?? static function (\Throwable $error): \Throwable {
            return $error;
        };
    }

    /**
     * {@inheritDoc}
     */
    public function build(ReadableInterface $file, RuleInterface $rule, TokenInterface $token, $state, $children)
    {
        try {
            $result = $this->reduce($file, $rule, $token, $state, $children);

            return (($this->after)($result, $file, $rule, $token, $state, $children)) ?? $result;
        } catch (\Throwable $error) {
            throw (($this->onError)($error, $file, $rule, $token, $state, $children)) ?? $error;
        }
    }

    /**
     * @see Json5Builder::build()
     */
    private function reduce(ReadableInterface $file, RuleInterface $rule, TokenInterface $token, $state, $children)
    {
        if (\is_int($state)) {
            switch (true) {
                case $state === 1:
                return new \Serafim\Json5\Ast\ObjectNode($token->getOffset(), $children);
                    break;
                case $state === 12:
                return new \Serafim\Json5\Ast\ObjectMemberNode($token->getOffset(), ...$children);
                    break;
                case $state === 2:
                return new \Serafim\Json5\Ast\ArrayNode($token->getOffset(), $children);
                    break;
                case $state === 7:
                return new \Serafim\Json5\Ast\StringNode($token->getOffset(), \substr($children->getValue(), 1, -1));
                    break;
                case $state === 3:
                return new \Serafim\Json5\Ast\BooleanNode($token->getOffset(),
                        $children->getName() === 'T_BOOL_TRUE'
                    );
                    break;
                case $state === 4:
                return new \Serafim\Json5\Ast\NullNode($token->getOffset());
                    break;
                case $state === 22:
                return new \Serafim\Json5\Ast\IdentifierNode($token->getOffset(), $children->getValue());
                    break;
                case $state === 41:
                return \is_array($children) || $children->getName() === 'T_PLUS';
                    break;
                case $state === 6:
                return new \Serafim\Json5\Ast\InfinityNumberNode($token->getOffset(), \reset($children));
                    break;
                case $state === 5:
                return new \Serafim\Json5\Ast\NotANumberNode($token->getOffset());
                    break;
                case $state === 10:
                return new \Serafim\Json5\Ast\FloatNumberNode($token->getOffset(), \reset($children), \end($children)->getValue());
                    break;
                case $state === 11:
                    return new \Serafim\Json5\Ast\IntNumberNode($token->getOffset(), \reset($children), \end($children)->getValue());
                    break;
                case $state === 9:
                return new \Serafim\Json5\Ast\ExponentialNumberNode($token->getOffset(), \reset($children), \end($children)->getValue());
                    break;
                case $state === 8:
                return new \Serafim\Json5\Ast\HexadecimalNumberNode($token->getOffset(), \reset($children), \end($children)->getValue());
                    break;
            }
        }
        switch ($state) {
        }

        return null;
    }
}
