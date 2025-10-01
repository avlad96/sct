<?php

use App\Http\Controllers\Api\V1\ActivityController;
use App\Http\Controllers\Api\V1\BuildingController;
use App\Http\Controllers\Api\V1\OrganizationController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::get('/organizations', [OrganizationController::class, 'index']);
    Route::get('/organizations/{organization}', [OrganizationController::class, 'show']);

    Route::get('/buildings/{building}/organizations', [BuildingController::class, 'organizations']);
    Route::post('/buildings/radius', [BuildingController::class, 'searchByRadius']);

    Route::get('/activities/{activity}/organizations', [ActivityController::class, 'organizations']);
});
