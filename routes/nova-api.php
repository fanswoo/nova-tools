<?php

use Illuminate\Support\Facades\Route;
use FF\NovaTools\Http\Controllers\MorphTagSearchController;

Route::get('/{resource}/morph-tag-search', MorphTagSearchController::class);