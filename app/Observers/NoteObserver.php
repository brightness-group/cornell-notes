<?php

namespace App\Observers;

use App\Models\Note;
use Illuminate\Support\Facades\Storage;

class NoteObserver
{
    /**
     * Handle the Note "creating" event.
     *
     * @param  \App\Models\Note  $note
     * @return void
     */
    public function creating(Note $note)
    {
        $note->setUpdatedAt(null);
    }

    /**
     * Handle the Note "created" event.
     *
     * @param  \App\Models\Note  $note
     * @return void
     */
    public function created(Note $note)
    {
        //
    }

    /**
     * Handle the Note "updated" event.
     *
     * @param  \App\Models\Note  $note
     * @return void
     */
    public function updated(Note $note)
    {
        //
    }

    /**
     * Handle the Note "deleted" event.
     *
     * @param  \App\Models\Note  $note
     * @return void
     */
    public function deleted(Note $note)
    {
        Storage::deleteDirectory($note->dirPath());
    }

    /**
     * Handle the Note "restored" event.
     *
     * @param  \App\Models\Note  $note
     * @return void
     */
    public function restored(Note $note)
    {
        //
    }

    /**
     * Handle the Note "force deleted" event.
     *
     * @param  \App\Models\Note  $note
     * @return void
     */
    public function forceDeleted(Note $note)
    {
        //
    }
}
