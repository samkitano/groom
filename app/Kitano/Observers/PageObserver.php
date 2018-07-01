<?php

namespace App\Kitano\Observers;

use App\Page;
use App\Kitano\Events\NewActivity;

class PageObserver
{
    public function created(Page $page)
    {
        event(
            new NewActivity(
                auth()->user()->id,
                'Created a page',
                null,
                json_encode($page)
            )
        );
    }

    public function deleted(Page $page)
    {
        event(
            new NewActivity(
                auth()->user()->id,
                'Deleted a page',
                json_encode($page),
                null
            )
        );
    }

    public function updated(Page $page)
    {
        event(
            new NewActivity(
                auth()->user()->id,
                'Updated a page',
                json_encode($page->getOriginal()),
                json_encode($page)
            )
        );
    }
}
