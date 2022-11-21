<?php

namespace App\Observers;

use App\Models\User;
use App\Models\DemoFolder;
use App\Models\DemoNote;

class UserObserver
{
    /**
     * Handle the User "created" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function created(User $user)
    {
        $demoFolder = DemoFolder::welcome()->with('notes')->first();

        $folder = $user->folders()->create(['name' => $demoFolder->name]);

        foreach ($demoFolder->notes as $value) {
            $user->notes()->create([
                'title' => $value->title,
                'content' => $value->content,
                'folder_id' => $folder->id,
            ]);
        }
    }

    /**
     * Handle the User "updated" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function updated(User $user)
    {
        //
    }

    /**
     * Handle the User "deleted" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function deleting(User $user)
    {
        if ($user->current_plan) {
            $user->cancelSubscription();
        }

        $subscription = $user->subscriptions()->get();
        foreach ($subscription as $key => $value) {
            $value->items()->delete();
            $value->delete();
        }

        $user->folders()->cursor()->each->delete();

        auth()->guard('web')->logout();
    }

    public function deleted(User $user)
    {
        //
    }

    /**
     * Handle the User "restored" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function restored(User $user)
    {
        //
    }

    /**
     * Handle the User "force deleted" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function forceDeleted(User $user)
    {
        //
    }
}
