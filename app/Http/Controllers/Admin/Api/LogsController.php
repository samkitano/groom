<?php

namespace App\Http\Controllers\Admin\Api;

use Illuminate\Http\JsonResponse;
use App\Kitano\LogViewer\LogViewer;
use App\Http\Controllers\ApiController;

class LogsController extends ApiController
{
    /** @var LogViewer */
    protected $logViewer;

    /**
     * LogsController constructor.
     * @param LogViewer $logViewer
     */
    public function __construct(LogViewer $logViewer)
    {
        $this->logViewer = $logViewer;
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $logs = $this->logViewer->logsList();

        return $this->respondOk(compact('logs'));
    }

    /**
     * Display the specified resource.
     *
     * @param  string $log
     * @return JsonResponse
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function show(string $log): JsonResponse
    {
        return $this->respondOk($this->logViewer->get($log));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param string $id
     * @return JsonResponse
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function destroy(string $id): JsonResponse
    {
        return $this->respondOk($this->logViewer->delete($id));
    }

    /**
     * Destroy all raw logs
     *
     * @return JsonResponse
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function destroyAll(): JsonResponse
    {
        return $this->respondOk($this->logViewer->deleteAllRaw());
    }
}
