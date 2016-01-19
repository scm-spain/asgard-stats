<?php


namespace SCMSpain\Stats;


class WeeklyStats
{
    /** @var  string */
    private $app;
    /** @var  string */
    private $year;
    /** @var  string */
    private $weekOfYear;
    /** @var  int */
    private $totalDeploys;

    public function __construct($app, $year, $weekOfYear, $totalDeploys)
    {
        $this->app = $app;
        $this->year = $year;
        $this->weekOfYear = $weekOfYear;
        $this->totalDeploys = $totalDeploys;
    }


    public function getApp()
    {
        return $this->app;
    }

    public function getYear()
    {
        return $this->year;
    }

    public function getWeekOfYear()
    {
        return $this->weekOfYear;
    }

    public function getTotalDeploys()
    {
        return $this->totalDeploys;
    }
}