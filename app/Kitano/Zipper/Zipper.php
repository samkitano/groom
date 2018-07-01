<?php

namespace App\Kitano\Zipper;

use ZipArchive;
use App\Kitano\Zipper\Exceptions\ZipperException;

class Zipper
{
    /** @var ZipArchive */
    protected $zipper;

    /** @var int */
    protected $operation = ZipArchive::CREATE;

    /**
     * Zipper constructor.
     *
     * @param ZipArchive $zip
     * @throws ZipperException
     */
    public function __construct(ZipArchive $zip)
    {
        if (! extension_loaded('zip')) {
            throw new ZipperException('PHP Zip extension is not installed.');
        }

        if (! defined('ZIP_EXTENSION')) {
            define('ZIP_EXTENSION', '.zip');
        }

        $this->zipper = $zip;
    }

    /**
     * Compress a file into a Zip Archive
     *
     * @param string $file        Full path to the file to compress
     * @param string $destination Full path to destination folder
     * @return bool
     * @throws ZipperException
     */
    public function compress(string $file, string $destination = ''): bool
    {
        if (! file_exists($file)) {
            throw new ZipperException("Source file '{$file}' not found.");
        }

        if (empty($destination)) {
            $destination = dirname($file);
        } else {
            $this->checkDir($destination);
        }

        $full_path = $destination.DS.$this->normalizeZipName(basename($file));

        $this->open($full_path)
             ->add($file)
             ->close();

        return file_exists($full_path);
    }

    /**
     * Compress directory to a Zip file
     *
     * @param string $source        Source Dir Full Path
     * @param string $glob_pattern  Glob Pattern
     * @param string $name          Final archive name
     * @param string $destination   Destination Dir Full Path
     * @return bool
     * @throws ZipperException
     */
    public function compressDir(
        string $source,
        string $glob_pattern = '*',
        string $name = '',
        string $destination = ''
    ): bool
    {
        $this->checkDir($source, true);

        if (empty($destination)) {
            $destination = $source;
        } else {
            $this->checkDir($destination);
        }

        if (empty($name)) {
            $name = basename($source);
        }

        $name = $this->normalizeZipName($name);

        $this->open($destination.DS.$name)
             ->add(null, $source.DS.$glob_pattern)
             ->close();

        return file_exists($destination.DS.$name);
    }

    /**
     * Normalize compressed file name
     *
     * @param string $name
     * @return string
     */
    protected function normalizeZipName(string $name): string
    {
        $ext = pathinfo($name)['extension'] ?? false;

        if (! $ext || $ext !== 'zip') {
            return $name.ZIP_EXTENSION;
        }

        return $name;
    }

    /**
     * Check directory existence
     *
     * @param $dir
     * @param bool $source
     * @throws ZipperException
     */
    protected function checkDir($dir, $source = false)
    {
        if (! is_dir($dir)) {
            throw new ZipperException(
                $source
                    ? 'Source'
                    : 'Destination'
                ." directory '{$dir}' does not exist."
            );
        }
    }

    /**
     * Open the archive
     *
     * @param $zip
     * @return $this
     */
    protected function open($zip)
    {
        $this->zipper->open($zip, $this->operation);

        return $this;
    }

    /**
     * Close the archive
     */
    protected function close()
    {
        $this->zipper->close();
    }

    /**
     * Add file(s) to archive
     *
     * @param string $file The file to add
     * @param string $glob The Glob parretn
     * @return $this
     */
    protected function add($file, string $glob = ""): self
    {
        if (null === $file) {
            $file = $glob;
        } else {
            if (file_exists($file)) {
                $this->operation = ZipArchive::CREATE | ZipArchive::OVERWRITE;
            }
        }

        empty($glob)
            ? $this->zipper->addFile($file, basename($file))
            : $this->zipper->addGlob($glob, GLOB_BRACE, ['remove_all_path' => TRUE]);

        return $this;
    }
}
