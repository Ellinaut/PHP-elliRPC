<?php

namespace Ellinaut\ElliRPC\FileHandler;

use Ellinaut\ElliRPC\DataTransfer\Workflow\File;
use Ellinaut\ElliRPC\DataTransfer\Workflow\FileReference;
use Ellinaut\ElliRPC\Exception\DuplicatedFileException;
use Ellinaut\ElliRPC\Exception\FileHandlerException;
use Ellinaut\ElliRPC\Exception\FileNotFoundException;
use RuntimeException;
use Throwable;

/**
 * @author Philipp Marien
 */
class PhpFileHandler implements FileHandlerInterface
{
    /**
     * @var string
     */
    private string $storageDirectory;

    /**
     * @var string
     */
    private string $contentLocationPathPrefix;

    /**
     * @var int
     */
    private int $fileMode;

    /**
     * @param string $storageDirectory
     * @param string $contentLocationPathPrefix
     * @param int $fileMode
     */
    public function __construct(
        string $storageDirectory,
        string $contentLocationPathPrefix = 'elliRPC',
        int $fileMode = 755
    ) {
        $this->storageDirectory = $storageDirectory;
        $this->contentLocationPathPrefix = $contentLocationPathPrefix;
        $this->fileMode = $fileMode;
    }

    /**
     * @param string $publicLocation
     * @param string $content
     * @return FileReference
     * @throws Throwable
     */
    public function createFile(string $publicLocation, string $content): FileReference
    {
        $location = $this->getServerLocation($publicLocation);
        if (file_exists($location)) {
            throw new DuplicatedFileException($publicLocation);
        }

        $this->createStorageSubDirectories($location);

        file_put_contents($location, $content);
        if (!file_exists($location)) {
            throw new FileHandlerException('Failed to create file "' . $publicLocation . '".');
        }

        if (!chmod($location, $this->fileMode)) {
            unlink($location);
            throw new FileHandlerException('Failed to set file permissions for "' . $publicLocation . '".');
        }

        return new FileReference($this->getContentLocationValue($location));
    }

    /**
     * @param string $publicLocation
     * @param string $content
     * @return FileReference
     * @throws Throwable
     */
    public function replaceFile(string $publicLocation, string $content): FileReference
    {
        $location = $this->getServerLocation($publicLocation);
        if (!file_exists($location)) {
            return $this->createFile($publicLocation, $content);
        }

        if (!is_writable($location)) {
            throw new FileHandlerException('File "' . $publicLocation . '" is not writeable.');
        }

        $result = file_put_contents($location, $content);
        if (!$result) {
            throw new FileHandlerException('Failed to replace file "' . $publicLocation . '".');
        }

        return new FileReference($this->getContentLocationValue($location));
    }

    /**
     * @param string $publicLocation
     * @return File
     * @throws FileNotFoundException
     */
    public function readFile(string $publicLocation): File
    {
        $file = $this->getServerLocation($publicLocation);
        if (!file_exists($file) || !is_readable($file)) {
            throw new FileNotFoundException($publicLocation);
        }

        if (!function_exists('mime_content_type')) {
            throw new RuntimeException('PHP extension "ext-fileinfo" will be needed here, but is not installed.');
        }

        return new File(
            $this->getContentLocationValue($file),
            mime_content_type($file),
            file_get_contents($file)
        );
    }

    /**
     * @param string $publicLocation
     */
    public function deleteFile(string $publicLocation): void
    {
        // TODO: Implement deleteFile() method.
    }

    /**
     * @return string
     */
    protected function getStorageDirectory(): string
    {
        return rtrim($this->storageDirectory, '/');
    }

    /**
     * @param string $serverLocation
     * @throws Throwable
     */
    protected function createStorageSubDirectories(string $serverLocation): void
    {
        $storageDirectoryParts = explode(
            '/',
            trim(substr($serverLocation, (strlen($this->getStorageDirectory()) - 1)), '/')
        );
        array_pop($storageDirectoryParts); // remove file name

        $storageDirectoryPath = $this->getStorageDirectory();
        foreach ($storageDirectoryParts as $part) {
            if (!is_dir($storageDirectoryPath) || !is_writable($storageDirectoryPath)) {
                throw new FileHandlerException('Failed to create a directory.');
            }

            $storageDirectoryPath .= '/' . $part;
            if (is_dir($storageDirectoryPath)) {
                continue;
            }

            if (!mkdir($storageDirectoryPath) && !is_dir($storageDirectoryPath)) {
                throw new FileHandlerException('Failed to create a directory.');
            }

            if (!chmod($storageDirectoryPath, $this->fileMode)) {
                throw new FileHandlerException('Failed to set directory permissions.');
            }
        }
    }

    /**
     * @param string $publicLocation
     * @return string
     */
    protected function getServerLocation(string $publicLocation): string
    {
        return $this->getStorageDirectory() . '/' . trim($publicLocation, '/');
    }

    /**
     * @param string $serverLocation
     * @return string
     */
    protected function getContentLocationValue(string $serverLocation): string
    {
        return '/' .
            trim($this->contentLocationPathPrefix, '/') .
            substr($serverLocation, (strlen($this->getStorageDirectory()) - 1));
    }
}
