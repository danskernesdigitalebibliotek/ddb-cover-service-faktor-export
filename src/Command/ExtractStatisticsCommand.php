<?php
/**
 * @file
 * Contains a command to extract statistics.
 */

namespace App\Command;

use App\Service\StatisticsExtractionService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * Class ExtractStatisticsCommand.
 */
class ExtractStatisticsCommand extends Command
{
    private $extractionService;

    protected static $defaultName = 'app:extract:latest';

    /**
     * ExtractStatisticsCommand constructor.
     *
     * @param StatisticsExtractionService $extractionService
     *   The extraction service
     * @param string|null $name
     *   The name of the command; passing null means it must be set in configure()
     */
    public function __construct(StatisticsExtractionService $extractionService, string $name = null)
    {
        $this->extractionService = $extractionService;

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
     * @suppress PhanUndeclaredMethod
     *
     * @throws \Doctrine\ODM\MongoDB\MongoDBException
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $progressBarSheet = new ProgressBar($output);
        $progressBarSheet->setFormat('[%bar%] %elapsed% (%memory%) - %message%');
        $this->extractionService->setProgressBar($progressBarSheet);

        $this->extractionService->extractLatestStatistics();

        $io->success('Data extracted successfully.');

        return 0;
    }
}
