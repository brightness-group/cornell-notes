<?php

namespace App\Providers;

use App\Listeners\GenerateFavicons;
use App\Models\Folder;
use App\Models\Note;
use App\Models\User;
use App\Models\DemoFolder;
use App\Models\DemoNote;
use App\Observers\FolderObserver;
use App\Observers\NoteObserver;
use App\Observers\UserObserver;
use App\Observers\DemoFolderObserver;
use App\Observers\DemoNoteObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use Statamic\Events\GlobalSetSaved;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        GlobalSetSaved::class => [
            GenerateFavicons::class,
        ],
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     *
     * @return bool
     */
    public function shouldDiscoverEvents()
    {
        return false;
    }

    /**
     * The model observers for your application.
     *
     * @var array
     */
    protected $observers = [
        Folder::class => [FolderObserver::class],
        Note::class => [NoteObserver::class],
        User::class => [UserObserver::class],
        DemoFolder::class => [DemoFolderObserver::class],
        DemoNote::class => [DemoNoteObserver::class],

    ];
}
