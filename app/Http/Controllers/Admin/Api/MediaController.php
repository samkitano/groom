<?php

namespace App\Http\Controllers\Admin\Api;

use Illuminate\Http\Request;
use App\Kitano\Traits\Media;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\ApiController;

class MediaController extends ApiController
{
    use Media;

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        // $this->forget('ALL_MEDIA');
        return $this->respondOk(['media' => $this->all()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        return $this->save($request->file('file'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return JsonResponse
     * @throws \App\Kitano\Exceptions\MediaNotFound
     */
    public function show($id): JsonResponse
    {
        $file = $this->find($id);
        $medium = $this->getImgInfo($file);

        return $this->respondOk(compact('medium'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @param  int $id
     * @return JsonResponse
     * @throws \App\Kitano\Exceptions\MediaNotFound
     */
    public function destroy(Request $request, $id): JsonResponse
    {
        if ($request->has('file')) {
            return $this->delete($request->file);
        }

        $medium = $this->find($id);
        $file = $medium['path'];

        return $this->delete($file);
    }

    /**
     * This API route
     *
     * @return JsonResponse
     */
    public function url(): JsonResponse
    {
        return $this->respondOk(['url' => route('media.store')]);
    }

    /**
     * Get only images
     *
     * @return JsonResponse
     */
    public function images(): JsonResponse
    {
        $images = $this->getByType('image');

        return $this->respondOk(compact('images'));
    }
}
