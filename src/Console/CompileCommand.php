<?php

/**
 * This file is part of Json5 package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Serafim\Json5\Console;

use Phplrt\Compiler\Compiler;
use Phplrt\Source\Exception\NotFoundException;
use Phplrt\Source\Exception\NotReadableException;
use Phplrt\Source\File;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class CompileCommand
 */
class CompileCommand extends Command
{
    /**
     * @var string
     */
    private const GRAMMAR_PATHNAME = __DIR__ . '/../../resources/grammar.pp2';

    /**
     * @var string
     */
    private const OUTPUT_FQN = 'Serafim\\Json5\\Parser';

    /**
     * @var string
     */
    private const OUTPUT_PATH = __DIR__ . '/../Parser.php';

    /**
     * @return string
     */
    public function getName(): string
    {
        return 'compile';
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     * @throws NotFoundException
     * @throws NotReadableException
     * @throws \Throwable
     */
    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $compiler = new Compiler();
        $compiler->load(File::fromPathname(self::GRAMMAR_PATHNAME));
        $compiler->build(self::OUTPUT_FQN)->save(self::OUTPUT_PATH);

        return 0;
    }
}
