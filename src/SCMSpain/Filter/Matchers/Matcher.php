<?php


namespace SCMSpain\Filter\Matchers;

use SCMSpain\Tasks\Task;

interface Matcher
{

    /**
     * @param Task $task
     * @return boolean
     */
    public function matches($task);
}