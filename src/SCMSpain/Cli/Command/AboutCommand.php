<?php

namespace SCMSpain\Cli\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class AboutCommand extends AbstractCommand
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
            ->setName('about')
            ->setDescription('Collects deploy stats from Asgard')
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln(sprintf("\n <info>Asgard stats</info> <comment>%s</comment>", $this->appVersion));
        $output->writeln(" ~~~~~~~~~~~~~~~~~~~~");

        $output->writeln(" Command line tool to collect deploy stats for each environment.\n");
        $output->writeln(" How many deploys you did in dev, pre or prod.\n");

        return 0;
    }
}