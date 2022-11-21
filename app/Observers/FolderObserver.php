<?php

namespace App\Observers;

use App\Models\Folder;

class FolderObserver
{
    /**
     * Handle the Folder "created" event.
     *
     * @param  \App\Models\Folder  $folder
     * @return void
     */
    public function created(Folder $folder)
    {
        //
    }

    /**
     * Handle the Folder "updated" event.
     *
     * @param  \App\Models\Folder  $folder
     * @return void
     */
    public function updated(Folder $folder)
    {
        //
    }

    /**
     * Handle the Folder "deleted" event.
     *
     * @param  \App\Models\Folder  $folder
     * @return void
     */
    public function deleted(Folder $folder)
    {
        $folder->notes()->cursor()->each->delete();
    }

    /**
     * Handle the Folder "restored" event.
     *
     * @param  \App\Models\Folder  $folder
     * @return void
     */
    public function restored(Folder $folder)
    {
        //
    }

    /**
     * Handle the Folder "force deleted" event.
     *
     * @param  \App\Models\Folder  $folder
     * @return void
     */
    public function forceDeleted(Folder $folder)
    {
        //
    }
}
