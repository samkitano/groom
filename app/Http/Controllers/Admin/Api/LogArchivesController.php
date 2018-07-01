<?php

namespace App\Http\Controllers\Admin\Api;

use App\Kitano\Zipper\Zipper;
use Illuminate\Http\JsonResponse;
use App\Kitano\LogViewer\LogViewer;
use App\Http\Controllers\ApiController;

class LogArchivesController extends ApiController
{
    /** @var LogViewer */
    protected $logViewer;

    /** @var Zipper */
    protected $zipper;

    /**
     * LogArchivesController constructor.
     *
     * @param LogViewer $logViewer
     * @param Zipper $zipper
     */
    public function __construct(LogViewer $logViewer, Zipper $zipper)
    {
        $this->logViewer = $logViewer;
        $this->zipper = $zipper;
    }

    /**
     * Display a listing of archived logs.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $archives = $this->logViewer->archivesList();

        return $this->respondOk(compact('archives'));
    }

    /**
     * Create the Master Logs Archive.
     *
     * @return JsonResponse
     * @throws \App\Kitano\Zipper\Exceptions\ZipperException
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function store(): JsonResponse
    {
        return $this->respondOk($this->logViewer->archive());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  string $log
     * @return JsonResponse
     * @throws \App\Kitano\Zipper\Exceptions\ZipperException
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function update(string $log): JsonResponse
    {
        return $this->respondOk($this->logViewer->archive($log));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param string $log
     * @return JsonResponse
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function destroy(string $log): JsonResponse
    {
        return $this->respondOk($this->logViewer->deleteArchive($log));
    }

    /**
     * Delete Master Archive
     *
     * @return JsonResponse
     */
    public function destroyMaster(): JsonResponse
    {
        return $this->respondOk($this->logViewer->deleteMasterArchive());
    }

    /**
     * Delete all archived logs
     *
     * @return JsonResponse
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function destroyAll(): JsonResponse
    {
        return $this->respondOk($this->logViewer->deleteAllArchived());
    }

    /**
     * Check if master archive exists
     *
     * @return JsonResponse
     */
    public function checkMaster(): JsonResponse
    {
        return $this->respondOk($this->logViewer->hasMaster());
    }
}
