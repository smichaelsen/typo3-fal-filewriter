# FAL Filewriter [![Build Status](https://travis-ci.org/smichaelsen/typo3-fal-filewriter.svg?branch=master)](https://travis-ci.org/smichaelsen/typo3-fal-filewriter)

Little helper package for when you want to create files and save them to TYPO3's File Abstraction Layer

## Usage

### FileGenerator

You need to create a class that provides the content that will be saved in a file. It has to implement the
`\Smichaelsen\FalFilewriter\FileGeneratorInterface`, which is fairly easy.

### Storage

By default your TYPO3 installation will have a storage record with uid `1` pointing to the fileadmin, but of course you
can configure your own storage records pointing to other folders or even to external services like AWS.

Load the storage object like this:

    $storage = $this->objectManager->get(\TYPO3\CMS\Core\Resource\StorageRepository::class)->findByUid($fileStorageUid);
    
### FileWriterService

The `\Smichaelsen\FalFilewriter\FileWriterService` has one public method `saveFile()` which takes the following parameters:

* **$fileGenerator**: Your file generator object implementing the `FileGeneratorInterface`.
* **$fileIdentifier**: The file name which may include a relative path inside the `$storage` folder. The file extension
may be omitted. Then it is read from the `$fileGenerator` (`->getFileExtension()`). If the file name starts with a path
that doesn't exist it will be tried to create that path. 
* **$storage**: The `ResourceStorage` object to save the file in. See above ("Storage") for more information.

As return value you will receive a `\TYPO3\CMS\Core\Resource\FileInterface` object for the saved file.

Example:

    /** @var \Smichaelsen\FalFilewriter\FileWriterService $fileWriterService */
    /** @var \Smichaelsen\FalFilewriter\FileGeneratorInterface $fileGenerator */
    /** @var \TYPO3\CMS\Core\Resource\ResourceStorage $storage */
    $fileObject = $fileWriterService->saveFile($fileGenerator, 'folder/my-filename', $storage);
