<?php

namespace App\Observers;

use App\Models\DemoFolder;

class DemoFolderObserver
{
    /**
     * Handle the DemoFolder "created" event.
     *
     * @param  \App\Models\DemoFolder  $demoFolder
     * @return void
     */
    public function created(DemoFolder $demoFolder)
    {
        //
    }

    /**
     * Handle the DemoFolder "updated" event.
     *
     * @param  \App\Models\DemoFolder  $demoFolder
     * @return void
     */
    public function updated(DemoFolder $demoFolder)
    {
        //
    }

    /**
     * Handle the DemoFolder "deleted" event.
     *
     * @param  \App\Models\DemoFolder  $demoFolder
     * @return void
     */
    public function deleted(DemoFolder $demoFolder)
    {
        $demoFolder->notes()->cursor()->each->delete();
    }

    /**
     * Handle the DemoFolder "restored" event.
     *
     * @param  \App\Models\DemoFolder  $demoFolder
     * @return void
     */
    public function restored(DemoFolder $demoFolder)
    {
        //
    }

    /**
     * Handle the DemoFolder "force deleted" event.
     *
     * @param  \App\Models\DemoFolder  $demoFolder
     * @return void
     */
    public function forceDeleted(DemoFolder $demoFolder)
    {
        //
    }
}
