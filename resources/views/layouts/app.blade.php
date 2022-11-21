<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-gray-100">
    <head>
        @include('layouts.partials.meta')

        @include('layouts.partials.prologue')

        @include('layouts.partials.tracker')
    </head>
    <body class="h-full" id="app">
        @if(Auth::user() && Auth::user()->name == 'Admin' && Auth::user()->super == 1)
            <app-layout :user="{{ Auth::user()->name.'-'.Auth::user()->super }}" :admin='true'>
        @else
            <app-layout  @if(Auth::user()) :user="{{ Auth::user() }}" @endif :admin='false'>
        @endif

            <template #content>
                {{ $slot }}
            </template>
        </app-layout>
    </body>
</html>
