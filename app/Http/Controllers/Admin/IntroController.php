<?php

namespace App\Http\Controllers\Admin;

use App\Content;
use App\Module;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IntroController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $intro = Module::whereName('intro')->first();
        $introCss = $this->getModuleCss($intro->properties);

        return response()->json(['intro' =>$intro, 'css' => $introCss]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    protected function getModuleCss($moduleProps): ?string
    {
        $css = [];
        $styles = array_keys($moduleProps);

        foreach ($styles as $style) {
            if (! empty($moduleProps[$style])) {
                if ($style === 'custom_css') {
                    $css[] = $moduleProps[$style];
                    continue;
                }

                if (is_array($style)) {
                    $css[] = $this->getArrayProps($moduleProps[$style]);
                    continue;
                }

                $css[] = $style.':'.$moduleProps[$style];
            }
        }

        if (count($css)) {
            return implode(';', $css);
        }

        return null;
    }

    protected function getArrayProps(array $bgArray)
    {
        $res = [];

        foreach ($bgArray as $item => $val) {
            $res[] = $item.':'.$val;
        }

        return implode(';', $res);
    }
}
