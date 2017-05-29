<?php

namespace Deployer;

use Deployer\Entity\File;
use Deployer\Utils\Git;
use Deployer\Utils\Sftp;

class Deployer
{
    /**
     * @var Git $git
     */
    protected $git;

    /**
     * @var Sftp $sftp
     */
    protected $sftp;

    public function __construct()
    {
        $this->git  = new Git();
        $this->sftp = new Sftp();
    }

    public function deploy()
    {
        $filesFromCommits = $this->git->getFilesFromCommits();
        $errors  = [];

        foreach ($filesFromCommits as $fileFromCommits) {
            try {
                $this->uploadFile($fileFromCommits);
            } catch (\Exception $ex) {
                $errors[] = ['file' => $fileFromCommits, 'reason' => $ex->getMessage()];
            }
        }

        echo sprintf('Archivos subidos: %d \n\n', abs(count($filesFromCommits) - count($errors)));

        if ($errors) {
            echo sprintf('Errores encontrados: %s', json_encode($errors));
        }
    }

    /**
     * @param string $filename
     */
    protected function uploadFile($filename)
    {
        $file = new File($filename);
        $this->sftp->upload($file);
    }
}
