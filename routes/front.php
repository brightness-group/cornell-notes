<?php

use App\Http\Controllers\DynamicToken;
use Illuminate\Support\Facades\Route;
use Statamic\Facades\Site;

// Dynamic Token route for posting a form with Ajax.
Route::get('/!/DynamicToken/refresh', [DynamicToken::class, 'getRefresh']);

// The Sitemap route to the sitemap.xml
Route::statamic('/sitemap.xml', 'sitemap/sitemap', [
    'layout' => null,
    'content_type' => 'application/xml',
]);

// The Manifest route to the manifest.json
Route::statamic('/site.webmanifest', 'manifest/manifest', [
    'layout' => null,
    'content_type' => 'application/json',
]);

// The Social Image route to generate social images.
// Site::all()->each(function ($site) {
//     Route::statamic("{$site->url()}/social-images/{id}", 'social_images', [
//         'layout' => null,
//     ]);
// });

// The Search route to display search results with `views/search.antlers.html`.
// Route::statamic('/search', 'search', [
//     'title' => 'Search results'
// ]);
