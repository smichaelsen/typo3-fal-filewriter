# FAL Filewriter

Little helper package for when you want to create files and save them to TYPO3's File Abstraction Layer

## Usage

The class that creates your file has to implement the `\Smichaelsen\FalFilewriter\FileGeneratorInterface`.

    /** @var \Smichaelsen\FalFilewriter\FileWriterService $fileWriterService */
    /** @var \Smichaelsen\FalFilewriter\FileGeneratorInterface $fileGenerator */
    /** @var \TYPO3\CMS\Core\Resource\ResourceStorage $storage */
    $fileObject = $fileWriterService->saveFile($fileGenerator, 'my-filename', $storage);
