<?php


namespace SCMSpain\Cli\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Yaml\Parser;

class AbstractCommand extends Command
{
    protected function loadEnvironments()
    {
        $settings = $this->loadSettings();
        if (!array_key_exists('environments', $settings)) {
            throw new \InvalidArgumentException('Missing environments definition on settings file');
        }

        return $settings['environments'];

    }

    private function loadSettings($configFile = 'config.yml')
    {
        if (!file_exists($configFile)) {
            throw new \InvalidArgumentException('Config file not found.');
        }
        $yaml = new Parser();

        return $yaml->parse(file_get_contents($configFile));
    }
}