<?php

/**
 * @file
 * Contains a command to extract statistics from Elasticsearch.
 */

namespace App\Command;

use App\Service\StatisticsExtractionService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * Class ExtractStatisticsCommand.
 */
class ExtractStatisticsCommand extends Command
{
    private $extractionService;

    protected static $defaultName = 'app:extract-statistics';

    /**
     * ExtractStatisticsCommand constructor.
     *
     * @param \App\Service\StatisticsExtractionService $elasticsearchFaker
     * @param string|null $name               The name of the command; passing null means it must be set in configure()
     */
    public function __construct(StatisticsExtractionService $elasticsearchFaker, string $name = null)
    {
        $this->extractionService = $elasticsearchFaker;

        parent::__construct($name);
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setDescription('Extracts statistics');
    }

    /**
     * {@inheritdoc}
     *
     * @throws \Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $result = $this->extractionService->getStatistics();

        $io->write(json_encode($result));

        $io->success('Data extracted successfully.');

        return 0;
    }
}
