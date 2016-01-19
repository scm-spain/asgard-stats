<?php

namespace SCMSpain\Filter\Matchers;

use SCMSpain\Tasks\AsgardTask;

class AppNotBlankTaskMatcher implements Matcher
{
    /**
     * @param AsgardTask $task
     * @return boolean
     */
    public function matches($task)
    {
        return trim($task->getApp()) !== '';
    }
}