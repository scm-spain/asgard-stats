<?php


namespace SCMSpain\Cli\Helper;

use SCMSpain\Stats\WeeklyStats;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Helper\TableSeparator;
use Symfony\Component\Console\Output\OutputInterface;

class WeeklyTableHelper
{
    /**
     * @var OutputInterface
     */
    private $output;

    public function __construct(OutputInterface $output)
    {
        $this->output = $output;
    }


    /**
     * @param WeeklyStats[] $stats
     */
    public function render($stats)
    {
        $table = new Table($this->output);
        $rows = $this->generateRows($stats);

        $table
            ->setHeaders(array('Year', 'Week of Year', 'App', '# deploys'))
            ->setRows($rows)
        ;
        $table->render();
    }

    /**
     * @param WeeklyStats[] $stats
     * @return array
     */
    private function generateRows($stats)
    {
        $rows = [];
        $previousYearAndWeek = '';
        if (count($stats)>0) {
            $previousYearAndWeek = $stats[0]->getYear().'-'.$stats[0]->getWeekOfYear();
        }
        foreach ($stats as $element) {
            $currentYearAndWeek = $element->getYear().'-'.$element->getWeekOfYear();
            if ($currentYearAndWeek !== $previousYearAndWeek) {
                $previousYearAndWeek = $currentYearAndWeek;
                $rows[] = new TableSeparator();
            }
            $rows[] = $this->generateRow($element);
        }
        return $rows;
    }

    /**
     * @param WeeklyStats $stats
     * @return array
     */
    private function generateRow($stats)
    {
        return [
            $stats->getYear(),
            $stats->getWeekOfYear(),
            $stats->getApp(),
            $stats->getTotalDeploys(),
        ];
    }
}