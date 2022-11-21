@php
    $logo = \Statamic\Facades\GlobalSet::findByHandle('configuration')->in('default')->get('main_logo');
@endphp

<img src="{{ asset('assets/' . $logo) }}" />
