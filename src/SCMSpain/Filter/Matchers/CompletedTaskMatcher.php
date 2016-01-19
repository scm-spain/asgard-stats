<?php

namespace SCMSpain\Filter\Matchers;

use SCMSpain\Tasks\AsgardTask;

class CompletedTaskMatcher implements Matcher
{
    /**
     * @param AsgardTask $task
     * @return boolean
     */
    public function matches($task)
    {
        return $task->getStatus() === AsgardTask::STATUS_COMPLETED;
    }
}