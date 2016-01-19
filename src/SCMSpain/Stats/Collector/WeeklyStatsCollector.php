<?php

namespace SCMSpain\Stats\Collector;

use SCMSpain\Stats\WeeklyStats;
use SCMSpain\Tasks\AsgardTask;

class WeeklyStatsCollector
{

    /**
     * @param AsgardTask[] $tasks
     * @return WeeklyStats[]
     */
    public function collect($tasks)
    {
        $aggregation = $this->map($tasks);
        return $this->reduce($aggregation);
    }

    /**
     * @param AsgardTask[] $tasks
     * @return array
     */
    private function map($tasks)
    {
        $result = [];
        foreach ($tasks as $task) {
            $this->increment($result, $task);
        }
        return $result;
    }

    /**
     * @param array $years
     * @return WeeklyStats[]
     */
    private function reduce($years)
    {
        $result = [];
        foreach($years as $year => $weeksOfYear) {
            foreach($weeksOfYear as $weekOfYear => $week) {
                foreach($week as $app => $totalDeploys) {
                    $result[] = new WeeklyStats($app, $year, $weekOfYear, $totalDeploys);
                }
            }
        }
        return $result;
    }

    private function increment(&$aggregation, $task)
    {
        $this->initializeYearDimension($aggregation, $task);
        $this->initializeWeekOfYearDimension($aggregation, $task);
        $this->initializeAppDimension($aggregation, $task);
        $this->incrementTotalDeploys($aggregation, $task);
    }

    /**
     * @param $aggregation
     * @param AsgardTask $task
     */
    private function initializeYearDimension(&$aggregation, $task)
    {
        $year = $task->getYear();
        if (!array_key_exists($year, $aggregation)) {
            $aggregation[$year] = [];
        }
    }

    /**
     * @param $aggregation
     * @param AsgardTask $task
     */
    private function initializeWeekOfYearDimension(&$aggregation, $task)
    {
        $year = $task->getYear();
        $weekOfYear = $task->getWeekOfYear();
        if (!array_key_exists($weekOfYear, $aggregation[$year])) {
            $aggregation[$year][$weekOfYear] = [];
        }
    }

    /**
     * @param $aggregation
     * @param AsgardTask $task
     */
    private function initializeAppDimension(&$aggregation, $task)
    {
        $year = $task->getYear();
        $weekOfYear = $task->getWeekOfYear();
        $app = $task->getApp();
        if (!array_key_exists($app, $aggregation[$year][$weekOfYear])) {
            $aggregation[$year][$weekOfYear][$app] = 0;
        }
    }

    /**
     * @param $aggregation
     * @param AsgardTask $task
     */
    private function incrementTotalDeploys(&$aggregation, $task)
    {
        $year = $task->getYear();
        $weekOfYear = $task->getWeekOfYear();
        $app = $task->getApp();
        $aggregation[$year][$weekOfYear][$app]++;
    }
}