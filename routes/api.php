<?php

use App\Http\Controllers\Api\V1\BuildingController;
use App\Http\Controllers\Api\V1\OrganizationController;
use App\Http\Resources\Api\V1\ActivityResource;
use App\Models\Activity;
use App\Models\OrganizationPhone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::get('/activities', function () {
        return ActivityResource::collection(Activity::all());
    });
    Route::get('/buildings', [BuildingController::class, 'index']);
    Route::get('/organizations', [OrganizationController::class, 'index']);
    Route::get('/organization-phones', function () {
        return OrganizationPhone::all();
    });
    Route::get('/activity-organization', function () {
        return DB::table('activity_organization')->get();
    });
    Route::post('/activities/create', function (Request $request) {
        Activity::create([
            'parent_id' => $request->parent_id ?? null,
            'name' => $request->name,
        ]);
    });
});
