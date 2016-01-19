<?php


namespace SCMSpain\Reader;

use GuzzleHttp\Client;
use SCMSpain\Tasks\AsgardTask;

class AsgardTaskListReader
{
    /** @var Client */
    private $client;

    public function __construct()
    {
        $this->client = new Client();
    }


    /**
     * @param string $asgardUrl
     * @return AsgardTask[]
     */
    public function read($asgardUrl)
    {
        $response = $this->client->request('GET', $asgardUrl);
        if ($response->getStatusCode() != 200) {
            throw new \InvalidArgumentException(sprintf("Url does not work: %s", $asgardUrl));
        }
        $content = $response->getBody();
        $allTasks = json_decode($content, true);
        $completedTasks = $allTasks["completedTaskList"];

        $result = [];
        foreach($completedTasks as $task) {
            $result[] = AsgardTask::fromData($task);
        }

        return $result;
    }
}