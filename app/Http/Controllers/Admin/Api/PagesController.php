<?php

namespace App\Http\Controllers\Admin\Api;

use App\Page;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\ApiController;

class PagesController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $pages = Page::all()->load(['modules' => function ($q) {
            $q->orderBy('order');
        }]);

        return $this->respondOk(compact('pages'));
    }

    /**
     * Store a newly created resource in storage.
     * @TODO: validation
     * @param  \Illuminate\Http\Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $data = $request->input();
        $data['name'] = strtolower($data['name']);
        //$data['slug'] = str_slug($data['name']);
        $data['route_name'] = strtolower($data['route_name']);

        foreach ($data['title'] as $lang => $title) {
            $data['slug'][$lang] = str_slug($title);
        }

        $page = Page::create($data);

        return $this->respondOk(compact('page'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return JsonResponse
     */
    public function show($id): JsonResponse
    {
        $page = Page::findOrFail($id)->load(['modules' => function ($q) {
            $q->orderBy('order');
        }]);

        return $this->respondOk(['page' => $page]);
    }

    /**
     * Update the specified resource in storage.
     * @TODO: Validation
     * @param  \Illuminate\Http\Request $request
     * @param  int                      $id
     * @return JsonResponse
     */
    public function update(Request $request, $id): JsonResponse
    {
        $model = Page::findOrFail($id);
//        $data = array_except(
//            $request->input('page'),
//            ['_method', '_token',]
//        );
        $data = $request->input();
        $data['name'] = strtolower($data['name']);
        $data['route_name'] = strtolower($data['route_name']);

        foreach ($data['title'] as $lang => $title) {
            $data['slug'][$lang] = str_slug($title);
        }

        //$data['slug'] = str_slug($data['name']);

        $model->update($data);

        return $this->respondOk(['page' => $model]);
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
        $page = Page::findOrFail($id);
        $page->delete();

        return $this->respondOk($page);
    }

    /**
     * Check if a page name exists
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function check (): JsonResponse
    {
        return $this->checkPage();
    }

    /**
     * Performs a check on whether a page exists or not
     *
     * @return JsonResponse
     */
    protected function checkPage(): JsonResponse
    {
        $name = request()->input('name');
        $id = request()->has('id') ? request()->id : false;

        $query = $id
            ? Page::where([['name', '=', $name], ['id', '<>', $id]])
            : Page::whereName($name);

        $found = $query->count() > 0;

        if ($found) {
            return $this->respondUnprocessable("A page named '{$name}' already exists");
        }

        return $this->respondOk();
    }

    /**
     * Returns a list of existing pages
     *
     * @return JsonResponse
     */
    public function list(): JsonResponse
    {
        return $this->respondOk(['list' => $this->getList()]);
    }

    /**
     * Lists the existing pages
     *
     * @return array
     */
    protected function getList(): array
    {
        $res = [];
        $pages = Page::all(['name', 'id']);

        foreach ($pages as $page) {
            $res[] = ['value' => $page->id, 'text' => $page->name];
        }

        return $res;
    }
}
