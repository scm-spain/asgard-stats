<?php


namespace SCMSpain\Tasks;


class AsgardTask implements Task
{
    const STATUS_COMPLETED = "completed";

    /** @var  string */
    private $app;
    /** @var  \DateTimeImmutable */
    private $startTime;
    /** @var  string */
    private $name;
    /** @var  string */
    private $status;

    public function __construct($app, $taskName, $status, $startTime)
    {
        $this->app = $app;
        $this->name = $taskName;
        $this->status = $status;
        $this->startTime = $startTime;
    }


    public static function fromData($task)
    {
        $app = array_key_exists("objectId", $task) ? $task["objectId"] : "n-a";
        $status = array_key_exists("status", $task) ? $task["status"] : "n-a";
        $startTime = null;
        if (array_key_exists("startTime", $task)) {
            $startTime = \DateTimeImmutable::createFromFormat("Y-m-d\TH:i:s\Z", $task["startTime"]);
        }
        $taskName = array_key_exists("name", $task) ? $task["name"] : '';


        return new AsgardTask($app, $taskName, $status, $startTime);
    }

    public function getApp()
    {
        return $this->app;
    }

    public function getWeekOfYear()
    {
        return $this->startTime->format("W");
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getYear()
    {
        return $this->startTime->format("Y");
    }
}