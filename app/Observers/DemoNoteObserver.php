<?php

namespace App\Observers;

use App\Models\DemoNote;
use Illuminate\Support\Facades\Storage;

class DemoNoteObserver
{
    /**
     * Handle the DemoNote "created" event.
     *
     * @param  \App\Models\DemoNote  $demoNote
     * @return void
     */
    public function created(DemoNote $demoNote)
    {
        //
    }

    /**
     * Handle the DemoNote "updated" event.
     *
     * @param  \App\Models\DemoNote  $demoNote
     * @return void
     */
    public function updated(DemoNote $demoNote)
    {
        //
    }

    /**
     * Handle the DemoNote "deleted" event.
     *
     * @param  \App\Models\DemoNote  $demoNote
     * @return void
     */
    public function deleted(DemoNote $demoNote)
    {
        Storage::deleteDirectory($demoNote->dirPath());
    }

    /**
     * Handle the DemoNote "restored" event.
     *
     * @param  \App\Models\DemoNote  $demoNote
     * @return void
     */
    public function restored(DemoNote $demoNote)
    {
        //
    }

    /**
     * Handle the DemoNote "force deleted" event.
     *
     * @param  \App\Models\DemoNote  $demoNote
     * @return void
     */
    public function forceDeleted(DemoNote $demoNote)
    {
        //
    }
}
