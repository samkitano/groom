<?php

namespace App\Http\Controllers\Admin\Api;

use App\Module;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\ApiController;

class ModulesController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $modules = Module::with(['page'])->get();

        return $this->respondOk(['modules' => $modules]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        // TODO: Validation
        $data = $request->input('module');
        $lastOrder = Module::wherePageId($data['page_id'])->count();
        $data['order'] = $lastOrder + 1;

        Module::create($data);

        return $this->respondOk();
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return JsonResponse
     */
    public function show($id): JsonResponse
    {
        $module = Module::findOrFail($id);

        return $this->respondOk(['module' => $module]);
    }

    /**
     * Update the specified resource in storage.
     * @TODO: validation
     * @param  \Illuminate\Http\Request $request
     * @param  int                      $id
     * @return JsonResponse
     */
    public function update(Request $request, $id): JsonResponse
    {
        $data = $request->input('module');
        $module = Module::findOrFail($id);

        $module->update($data);

        return $this->respondOk(['module' => $module]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return JsonResponse
     * @throws \Exception
     */
    public function destroy($id): JsonResponse
    {
        $module = Module::findOrFail($id);
        $module->delete();

        return $this->respondOk($module);

    }

    /**
     * Delete orphan modules
     *
     * @return JsonResponse
     */
    public function destroyOrphans(): JsonResponse
    {
        Module::destroy(request()->ids);

        return $this->respondOk();
    }

    /**
     * Sort Modules
     *
     * @return JsonResponse
     */
    public function reorder(): JsonResponse
    {
        foreach (request()->input('modules') as $orderable) {
            $model = Module::findOrFail($orderable['id']);
            $model->order = $orderable['order'];
            $model->save();
        }

        return $this->respondOk();
    }

    /**
     * Check if module name exists
     *
     * @return JsonResponse
     */
    public function check (): JsonResponse
    {
        $name = request()->input('name');
        $id = request()->has('id') ? request()->id : false;

        $query = $id
            ? Module::where([['name', '=', $name], ['id', '<>', $id]])
            : Module::whereName($name);

        $found = $query->count() > 0;

        if ($found) {
            return $this->respondUnprocessable("A module named '{$name}' already exists");
        }

        return $this->respondOk();
    }
}
