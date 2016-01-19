<?php


namespace SCMSpain\Cli\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ShowEnvironmentsCommand extends AbstractCommand
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
            ->setName('environments')
            ->setDescription('List of available environments')
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $environments = $this->loadEnvironments();
        $output->writeln("Available environments:");
        foreach ($environments as $environment => $asgardUrl) {
            $output->writeln($environment . ' => ' . $asgardUrl);
        }

        return 0;
    }
}