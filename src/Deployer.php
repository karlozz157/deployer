<?php

namespace Deployer;

use Deployer\DataSource\DataSource;
use Deployer\DataSource\GitDataSource;
use Deployer\Entity\File;
use Deployer\Storage\Storage;
use Deployer\Storage\StorageSftp;

class Deployer
{
    /**
     * @var DataSource $dataSource
     */
    protected $dataSource;

    /**
     * @var Storage $storage
     */
    protected $storage;

    public function __construct()
    {
        $this->dataSource = new DataSource(new GitDataSource());
        $this->storage = new Storage(new StorageSftp());
    }

    public function deploy()
    {
        $files  = $this->dataSource->getFiles();
        $errors = [];

        foreach ($files as $file) {
            try {
                $this->storage->upload(new File($file));
            } catch (\Exception $ex) {
                $errors[] = ['file' => $file, 'reason' => $ex->getMessage()];
            }
        }

        echo sprintf('Archivos subidos: %d \n\n', abs(count($files) - count($errors)));

        if ($errors) {
            echo sprintf('Errores encontrados: %s', json_encode($errors));
        }
    }
}
