<?php

namespace SCMSpain\Filter\Matchers;

use SCMSpain\Tasks\AsgardTask;

class DeployTaskMatcher implements Matcher
{
    const TASK_NAME_PATTERN = "Deploying new ASG to cluster '%s'";

    /**
     * @param AsgardTask $task
     * @return boolean
     */
    public function matches($task)
    {
        return sprintf(self::TASK_NAME_PATTERN, $task->getApp()) === $task->getName();
    }
}