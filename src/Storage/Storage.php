<?php

namespace Deployer\Storage;

use Deployer\Entity\File;

class Storage implements StorageInterface
{
    /**
     * @var StorageInterface $storage
     */
    protected $storage;

    /**
     * @param StorageInterface $storage
     */
    public function __construct(StorageInterface $storage)
    {
        $this->storage = $storage;
    }

    /**
     * @param File $file
     */
    public function upload(File $file)
    {
        $this->storage->upload($file);
    }
}
