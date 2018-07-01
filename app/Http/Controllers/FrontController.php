<?php

namespace App\Http\Controllers;

use App\Faq;
use App\Page;

class FrontController extends Controller
{
    public function home()
    {
        $page = Page::whereName('home')
                    ->first()
                    ->load([
                        'modules' => function ($q) {
                        $q->orderBy('order');
                    }]);

        return view('front.index', compact('page'));
    }

    public function maintenance()
    {
        $page = Page::whereName('maintenance')
            ->first()
            ->load([
                'modules' => function ($q) {
                    $q->orderBy('order');
                }]);

        return view('front.index', compact('page'));
    }

    public function lease()
    {
        $page = Page::whereName('lease')
            ->first()
            ->load([
                'modules' => function ($q) {
                    $q->orderBy('order');
                }]);

        return view('front.index', compact('page'));

    }

    public function services()
    {
        $page = Page::whereName('services')
            ->first()
            ->load([
                'modules' => function ($q) {
                    $q->orderBy('order');
                }]);

        return view('front.index', compact('page'));
    }

    public function faq()
    {
        $faq = Faq::all();

        return view('front.faq')->with(compact('faq'));
    }

    public function contact()
    {
        return view('front.contact');
    }
}
