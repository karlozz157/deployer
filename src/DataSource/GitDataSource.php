<?php

namespace Deployer\DataSource;

use Deployer\Utils\Config;

class GitDataSource implements DataSourceInterface
{
    /**
     * @param string $sprint
     */
    public function __construct()
    {
        $this->sprint = Config::getParam('sprint');
    }

    /**
     * @return array
     */
    public function getFiles()
    {
        return $this->getFilesFromCommits();
    }

    /**
     * @return array
     */
    protected function getCommits()
    {
        $result = shell_exec(sprintf('git --git-dir %s/.git log --all --grep="%s" --name-only', Config::getParam('workplace')['local'], $this->sprint));

        return explode('commit', $result);
    }

    /**
     * @return array
     */
    protected function getFilesFromCommits()
    {
        $commits = $this->getCommits();
        $modifiedFiles = [];

        foreach ($commits as $commit) {
            $files = array_slice(explode(PHP_EOL, trim($commit)), 6);
    
            foreach ($files as $file) {
                $modifiedFiles[] = $file;
            }
        }

        return array_unique($modifiedFiles);
    }
}
