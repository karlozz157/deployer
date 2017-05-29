<?php

namespace Deployer\DataSOurce;

use Deployer\Entity\File;

interface DataSourceInterface
{
    /**
     * @return array
     */
    public function getFiles();
}
