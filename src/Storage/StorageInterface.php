<?php

namespace Deployer\Storage;

use Deployer\Entity\File;

interface StorageInterface
{
    /**
     * @param File $file
     */
    public function upload(File $file);
}
