<?php

namespace Deployer\DataSource;

class DataSource implements DataSourceInterface
{
    /**
     * @param DataSourceInterface $dataSource
     */
    public function __construct(DataSourceInterface $dataSource)
    {
        $this->dataSource = $dataSource;
    }

    /**
     * @return array
     */
    public function getFiles()
    {
        return $this->dataSource->getFiles();
    }
}
