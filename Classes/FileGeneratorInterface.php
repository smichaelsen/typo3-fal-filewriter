<?php
namespace Smichaelsen\FalFilewriter;

interface FileGeneratorInterface
{

    /**
     * Returns the full file body for saving it or passing it to the browser
     *
     * @return string
     */
    public function getFileContent();

    /**
     * The mime type for outputting the generated file via the browser
     *
     * @return string
     */
    public function getMimeType();

    /**
     * The file extension for when the file is saved on the disk
     *
     * @return mixed
     */
    public function getFileExtension();

}
