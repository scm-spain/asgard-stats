<?php

namespace SCMSpain\Filter;

use SCMSpain\Filter\Matchers\Matcher;
use SCMSpain\Tasks\Task;

class Filter
{
    /**
     * @var Matcher[]
     */
    private $matchers;

    /**
     * Filter constructor.
     * @param Matcher[] $matchers
     */
    public function __construct($matchers)
    {
        $this->matchers = $matchers;
    }

    /**
     * @param Task[] $tasks
     * @return Task[]
     */
    public function filter($tasks)
    {
        return array_filter($tasks, function($task) {
            $match = true;
            foreach($this->matchers as $matcher) {
                $match &= $matcher->matches($task);
            }
            return $match;
        });
    }
}