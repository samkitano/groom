<?php

namespace App\Http\Controllers\Admin\Api;

use Illuminate\Http\JsonResponse;
use App\Kitano\LogViewer\LogViewer;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\ApiController;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use App\Kitano\Zipper\Zipper;

class UtilController extends ApiController
{
    /** @var LogViewer */
    protected $logViewer;

    protected $compressor;

    /**
     * UtilController constructor.
     * @param LogViewer $logViewer
     */
    public function __construct(LogViewer $logViewer, Zipper $zipper)
    {
        $this->logViewer = $logViewer;
        $this->compressor = $zipper;
    }

    /**
     * @TODO: DELETE ME
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function test()
    {
        // unlink(storage_path('logs').DS.'laravel-2018-05-23.zip');
        //dump($this->compressor->zipDir(storage_path('logs'), storage_path('logs'), '*.log', 'logs-archive'));
        //dd($this->logViewer->deleteArchive());
        //dd($this->logViewer->list());
        //dd($this->logViewer->get('2018-05-18'));
    }

    /**
     * Executes artisan comands
     * NOTICE: only one bool option allowed per command
     *
     * @return JsonResponse
     */
    public function exec(): JsonResponse
    {
        $c = request()->command;

        $option = explode(' ', $c);
        $command = array_shift($option);

        count($option)
            ? Artisan::call($command, [$option[0] => true])
            : Artisan::call($command);

        return $this->respondOk(['output' => Artisan::output()]);
    }

}
