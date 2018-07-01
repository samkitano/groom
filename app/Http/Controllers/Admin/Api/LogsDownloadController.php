<?php

namespace App\Http\Controllers\Admin\Api;

use App\Kitano\LogViewer\LogViewer;
use App\Http\Controllers\ApiController;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class LogsDownloadController extends ApiController
{
    /** @var LogViewer */
    protected $logViewer;

    /**
     * LogsDownloadController constructor.
     *
     * @param LogViewer $logViewer
     */
    public function __construct(LogViewer $logViewer)
    {
        $this->logViewer = $logViewer;
    }

    /**
     * Download a raw log file
     *
     * @param string $log
     * @return BinaryFileResponse
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function download(string $log): BinaryFileResponse
    {
        return $this->logViewer->download($log);
    }

    /**
     * Download Master Logs Archive
     *
     * @return BinaryFileResponse
     * @throws \App\Kitano\Zipper\Exceptions\ZipperException
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function downloadMaster(): BinaryFileResponse
    {
        return $this->logViewer->downloadMaster();
    }

    /**
     * Download an archived log
     *
     * @param string $archive
     * @return BinaryFileResponse
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function downloadArchive(string $archive): BinaryFileResponse
    {
        return $this->logViewer->downloadArchive($archive);
    }
}
