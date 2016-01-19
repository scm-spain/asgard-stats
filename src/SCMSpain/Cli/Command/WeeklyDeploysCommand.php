<?php


namespace SCMSpain\Cli\Command;

use SCMSpain\Cli\Helper\WeeklyTableHelper;
use SCMSpain\Filter\Filter;
use SCMSpain\Filter\Matchers\AppNotBlankTaskMatcher;
use SCMSpain\Filter\Matchers\CompletedTaskMatcher;
use SCMSpain\Filter\Matchers\DeployTaskMatcher;
use SCMSpain\Reader\AsgardTaskListReader;
use SCMSpain\Stats\Collector\WeeklyStatsCollector;
use SCMSpain\Tasks\AsgardTask;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class WeeklyDeploysCommand extends AbstractCommand
{
    /**
     * App version.
     * @var string
     */
    protected $appVersion;

    /**
     * Constructor.
     * @param string $appVersion App version
     */
    public function __construct($appVersion)
    {
        parent::__construct();

        $this->appVersion = $appVersion;
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('weekly')
            ->setDescription('Extracts files from a compressed archive')

            ->addArgument(
                'env',
                InputArgument::REQUIRED,
                'Environment: dev, pre, pro. By default dev.'
            )

            ->addOption(
                'config',
                null,
                InputArgument::OPTIONAL,
                'Settings file. By default config.yml'
            )
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $environments = $this->loadEnvironments();
        $env = $input->getArgument('env');
        if (!array_key_exists($env, $environments)) {
            throw new \InvalidArgumentException(sprintf("Settings for environment '%s' not found", $env));
        }
        $asgardUrl = $environments[$env];

        $output->writeln(sprintf("Generating stats for env '%s'\n", $env));
        $output->writeln(sprintf("Importing from '%s'\n", $asgardUrl));

        // retrieve/reader
        $reader = new AsgardTaskListReader();
        $tasks = $reader->read($asgardUrl);

        // filter
        $matchers = [
            new AppNotBlankTaskMatcher(),
            new CompletedTaskMatcher(),
            new DeployTaskMatcher()
        ];
        $filter = new Filter($matchers);
        /** @var AsgardTask[] $deployTasks */
        $deployTasks = $filter->filter($tasks);

        // collect
        $statsCollector = new WeeklyStatsCollector();
        $stats = $statsCollector->collect($deployTasks);

        $output->writeln("Here you are:");
        $outputHelper = new WeeklyTableHelper($output);
        $outputHelper->render($stats);

        return 0;
    }
}