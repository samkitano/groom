<?php

namespace App\Kitano\LogViewer;

use App\Kitano\Zipper\Zipper;
use App\Kitano\Helpers\RegexPatterns;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Filesystem\Filesystem as IlluminateFilesystem;

class LogViewer
{
    const LOG_ARCHIVE_NAME = 'logs-archive.zip';

    /** @var array */
    protected $logs = [];

    /** @var array */
    protected $archived = [];

    /** @var IlluminateFilesystem */
    protected $fileSystem;

    /** @var string */
    protected $logsPath;

    /** @var Zipper */
    protected $compressor;

    /** @var string */
    protected $logsArchivePath;

    /**
     * LogViewer constructor.
     * @param IlluminateFilesystem $fileSystem
     * @param Zipper $zipper
     */
    public function __construct(IlluminateFilesystem $fileSystem, Zipper $zipper)
    {
        $this->fileSystem = $fileSystem;
        $this->compressor = $zipper;
        $this->logsPath = storage_path('logs');
        $this->logsArchivePath = storage_path('logs').DS.self::LOG_ARCHIVE_NAME;
        $this->logs = $this->logs();
        $this->archived = $this->logs(true);
    }

    /**
     * Compose and retrieve a formatted log
     *
     * @param string $log
     * @return array
     * @throws FileNotFoundException
     */
    public function get(string $log): array
    {
        return $this->make($this->getLogFile($log), $log);
    }

    /**
     * Delete a log file
     *
     * @param string $log
     * @return bool
     * @throws FileNotFoundException
     */
    public function delete(string $log): bool
    {
        $file = $this->getLogFile($log);

        $this->unlinkLog($file);

        return true;
    }

    /**
     * Downloads a Log File
     *
     * @param string $log
     * @return BinaryFileResponse
     * @throws FileNotFoundException
     */
    public function download(string $log): BinaryFileResponse
    {
        $file = $this->getLogFile($log);
        $headers = ['Content-Type: application/txt',"Content-Disposition: attachment; filename={$log}.log"];

        return response()->download(
            $file,
            LOG_PREFIX.$log.LOG_EXTENSION,
            $headers
        );
    }

    /**
     * Download an archived log
     *
     * @param string $archive
     * @return BinaryFileResponse
     * @throws FileNotFoundException
     */
    public function downloadArchive(string $archive): BinaryFileResponse
    {
        $file = $this->logsPath.DS.LOG_PREFIX.$archive.LOG_EXTENSION.ZIP_EXTENSION;

        if (! file_exists($file)) {
            throw new FileNotFoundException("File {$file} not found");
        }

        $headers = ['Content-Type: application/zip',"Content-Disposition: attachment; filename=logs-archive.zip"];

        return response()->download(
            $file,
            LOG_PREFIX.$archive.LOG_EXTENSION.ZIP_EXTENSION,
            $headers
        );
    }

    /**
     * Download the master archive
     *
     * @return BinaryFileResponse
     * @throws FileNotFoundException
     * @throws \App\Kitano\Zipper\Exceptions\ZipperException
     */
    public function downloadMaster(): BinaryFileResponse
    {
        if(! $this->hasMaster()) {
            $this->archive();
        }

        $headers = ['Content-Type: application/zip',"Content-Disposition: attachment; filename=logs-archive.zip"];

        return response()->download(
            $this->logsArchivePath,
            config('app.name_').self::LOG_ARCHIVE_NAME,
            $headers
        );
    }

    /**
     * Create a Zip archive with existing logs
     *
     * @param string $name
     * @return bool
     * @throws FileNotFoundException
     * @throws \App\Kitano\Zipper\Exceptions\ZipperException
     */
    public function archive(string $name = ''): bool
    {
        if (! count($this->logs())) {
            return false;
        }

        if ($name !== '') {
            return $this->compressor->compress($this->getLogFile($name));
        }

        return $this->compressor->compressDir(
            $this->logsPath,
            RegexPatterns::LOGS_PATTERN,
            self::LOG_ARCHIVE_NAME
        );
    }

    /**
     * Delete the archive
     *
     * @return bool
     */
    public function deleteMasterArchive(): bool
    {
        if (file_exists($this->logsArchivePath)) {
            unlink($this->logsArchivePath);
        }

        return ! file_exists($this->logsArchivePath);
    }

    /**
     * Delete an archived log
     *
     * @param $name
     * @return bool
     * @throws FileNotFoundException
     */
    public function deleteArchive($name): bool
    {
        $file = $this->logsPath.DS.LOG_PREFIX.$name.LOG_EXTENSION.ZIP_EXTENSION;

        if (file_exists($file)) {
            unlink($file);
            return true;
        }

        throw new FileNotFoundException("File {$file} not found");
    }

    /**
     * Lists existing logs
     *
     * @return array
     */
    public function logsList(): array
    {
        return $this->extractDates($this->logs);
    }

    /**
     * Lists existing archives
     *
     * @return array
     */
    public function archivesList(): array
    {
        return $this->extractDates($this->archived);
    }

    /**
     * Phisically deletes a log
     *
     * @param string $path
     * @return void
     * @throws FileNotFoundException
     */
    protected function unlinkLog(string $path)
    {
        if (file_exists($path)) {
            unlink($path);
        } else {
            throw new FileNotFoundException("File '{$path}' not found.");
        }
    }

    /**
     * Check if a log archive exists
     *
     * @return bool
     */
    public function hasMaster(): bool
    {
        return file_exists($this->logsArchivePath);
    }

    /**
     * Destroy all raw logs
     *
     * @return bool
     * @throws FileNotFoundException
     */
    public function deleteAllRaw(): bool
    {
        foreach ($this->logs as $log) {
            $this->unlinkLog($log);
        }

        return true;
    }

    /**
     * Delete all archived logs
     *
     * @return bool
     * @throws FileNotFoundException
     */
    public function deleteAllArchived(): bool
    {
        foreach ($this->archived as $archive) {
            $this->deleteArchive($archive);
        }

        return true;
    }

    /**
     * Check for existence of a log file and return full path
     *
     * @param string $log
     * @return string
     * @throws FileNotFoundException
     */
    protected function getLogFile(string $log): string
    {
        $file = $this->logsPath.DS.LOG_PREFIX.$log.LOG_EXTENSION;

        if (file_exists($file)) {
            return $file;
        }

        throw new FileNotFoundException("File {$file} not found");
    }

    /**
     * Start building the formatted log
     *
     * @param string $file
     * @param string $title
     * @return array
     * @throws FileNotFoundException
     */
    protected function make(string $file, string $title): array
    {
        $raw = $this->fileSystem->get($file);
        $rawEntries = $this->getLogEntries($raw);
        $entries = $this->processEntries($rawEntries);

        return [
            $title =>
                [
                    'name' => basename($file),
                    'path' => $file,
                    'length' => count($entries),
                    'entries' => $entries,
                ]
            ];
    }

    /**
     * Iterate log entries to process
     *
     * @param array $entries
     * @return array
     */
    protected function processEntries(array $entries): array
    {
        $res = [];
        $c = 0;

        foreach ($entries[0][0] as $header) {
            $res[] = $this->processEntry($header, $entries[1][$c]);
            $c++;
        }

        return $res;
    }

    /**
     * Process individual entrie
     *
     * @param string $header
     * @param string $stack
     * @return array
     */
    protected function processEntry(string $header, string $stack): array
    {
        $dt = substr($header, 1, 19);
        $envType = string_between($header, '] ', ':');
        $env = strtok($envType, '.');
        $level = strtolower(string_between($header, '.', ':'));

        $st = strpos($header, '"exception":"');
        $error = substr($header, $st + 13);
        $error = trim(str_replace('[object]', '', $error));
        $error = ltrim($error, '(');
        $error = rtrim($error, ')');

        return [
            'raw_header' => $header,
            'datetime' => $dt,
            'env' => $env,
            'level' => $level,
            'error' => $error,
            'stack' => $stack
        ];
    }

    /**
     * Extract entries and headers from raw log
     *
     * @param string $raw
     * @return array
     */
    protected function getLogEntries(string $raw): array
    {
        $pattern = '/\['.RegexPatterns::DATE_PATTERN.' '.RegexPatterns::TIME_PATTERN.'\].*/';

        preg_match_all($pattern, $raw, $headers);

        $data = preg_split($pattern, $raw);

        if ($data[0] < 1) {
            $trash = array_shift($data);
            unset($trash);
        }

        return [$headers, $data];
    }

    /**
     * Return a list of existing log files
     *
     * @param bool $archived
     * @return array
     */
    protected function logs($archived = false): array
    {
        $pattern = LOG_PREFIX.RegexPatterns::LOG_DATE_PATTERN.LOG_EXTENSION;

        if ($archived) {
            $pattern .= ZIP_EXTENSION;
        }

        $storagePath = storage_path('logs');

        $logs = $this->fileSystem->glob(
            $storagePath.DS.$pattern, 0
        );

        return array_map('realpath', $logs);
    }

    /**
     * @param array $files
     * @return array
     */
    protected function extractDates(array $files): array
    {
        return array_map(function ($file) {
            return preg_replace(
                '/.*('.RegexPatterns::DATE_PATTERN.').*/',
                '$1',
                basename($file)
            );
        }, $files);
    }

    /**
     * @param string $dt
     * @return string
     */
    protected function extractDateTime(string $dt): string
    {
        return string_between($dt,'[', ']');
    }
}
