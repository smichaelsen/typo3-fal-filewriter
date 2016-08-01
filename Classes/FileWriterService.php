<?php
namespace Smichaelsen\FalFilewriter;

use TYPO3\CMS\Core\Resource\File;
use TYPO3\CMS\Core\Resource\ResourceStorage;

class FileWriterService
{

    /**
     * @param FileGeneratorInterface $fileGenerator
     * @param string $filename
     * @param ResourceStorage $storage
     * @return File
     */
    public function saveFile(FileGeneratorInterface $fileGenerator, $filename, ResourceStorage $storage)
    {
        if (!$storage->isPublic()) {
            $filename .= '_' . $this->generateFilenameToken();
        }
        $filename .= '.' . $fileGenerator->getFileExtension();
        $fileObject = $storage->createFile($filename, $storage->getRootLevelFolder());
        $fileObject->setContents($fileGenerator->getFileContent());
        return $fileObject;
    }

    /**
     * Generates a random key that is used as a unique token for the order record.
     * This token is used as a salt to generate the success and abort token.
     *
     * @return string
     * @throws \Exception
     */
    protected function generateFilenameToken()
    {
        $token = bin2hex(openssl_random_pseudo_bytes(8, $strong));
        if (!$strong) {
            throw new \Exception('openssl_random_pseudo_bytes was not able to generate a cryptographical strong key.', 1447670792);
        }
        return $token;
    }

}
