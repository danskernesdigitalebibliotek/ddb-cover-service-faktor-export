<?php

/**
 * @file
 * Contains a command to load fixtures into Elasticsearch.
 */

namespace App\Command;

use App\Fixtures\FixturesService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\HttpKernel\KernelInterface;

/**
 * Class LoadFixturesCommand.
 */
class LoadFixturesCommand extends Command
{
    private $fixturesService;
    private $environment;

    protected static $defaultName = 'app:fixtures:load';

    /**
     * ExtractStatisticsCommand constructor.
     *
     * @param KernelInterface $kernel
     *   The kernel
     * @param FixturesService $fixturesService
     *   The fixture service
     * @param string|null $name
     *   The name of the command; passing null means it must be set in configure()
     */
    public function __construct(KernelInterface $kernel, FixturesService $fixturesService, string $name = null)
    {
        $this->fixturesService = $fixturesService;
        $this->environment = $kernel->getEnvironment();

        parent::__construct($name);
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setDescription('Load fixtures into elasticsearch');
        $this->addArgument('date', InputArgument::OPTIONAL, 'Day to add entries to');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        if ('prod' === $this->environment) {
            $io->error('This command cannot be run in prod environment.');

            return 1;
        }

        $dateString = $input->getArgument('date');
        if (null === $dateString) {
            $io->warning('This will load fixtures into elasticsearch. If you want to continue, enter a date below.');

            $dateString = $io->ask('Select a date (for example "7 december 2019" or "-2 days"). Defaults to now.', 'now');
        }

        $date = new \DateTime($dateString);
        $this->fixturesService->runFixture($date);

        $io->success('Fixtures loaded into elasticsearch successfully.');

        return 0;
    }
}
