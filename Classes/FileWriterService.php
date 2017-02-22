<?php
namespace Smichaelsen\FalFilewriter;

use TYPO3\CMS\Core\Resource\FileInterface;
use TYPO3\CMS\Core\Resource\ResourceStorage;

class FileWriterService
{

    /**
     * @param FileGeneratorInterface $fileGenerator
     * @param string $fileIdentifier folder path and file name (without extension!) within the storage
     * @param ResourceStorage $storage
     * @return FileInterface
     */
    public function saveFile(FileGeneratorInterface $fileGenerator, $fileIdentifier, ResourceStorage $storage)
    {
        $pathAndFilenameSeparator = strrpos($fileIdentifier, '/');
        if ($pathAndFilenameSeparator === false) {
            $fileName = $fileIdentifier;
            $folder = $storage->getRootLevelFolder();
        } else {
            $fileName = substr($fileIdentifier, $pathAndFilenameSeparator + 1);
            $folderName = substr($fileIdentifier, 0, $pathAndFilenameSeparator);
            if ($storage->hasFolder($folderName)) {
                $folder = $storage->getFolder($folderName);
            } else {
                $folder = $storage->createFolder($folderName);
            }
        }
        if (!$storage->isPublic()) {
            $fileName .= '_' . $this->generateFilenameToken();
        }
        if (strpos('.', $fileName) === false) {
            $fileExtension = $fileGenerator->getFileExtension();
            if (!empty($fileExtension)) {
                $fileName .= '.' . $fileExtension;
            }
        }
        $fileObject = $storage->createFile($fileName, $folder);
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
