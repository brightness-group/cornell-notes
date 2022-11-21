<?php

use Statamic\Facades\GlobalSet;

if ( !function_exists("favicon") ) {
    function favicon() {
        $icon = GlobalSet::findByHandle('browser_appearance')->in('default')->get('svg');

        return asset("favicons/{$icon}");
    }
}
