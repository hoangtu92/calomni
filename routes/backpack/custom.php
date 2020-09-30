<?php

// --------------------------
// Custom Backpack Routes
// --------------------------
// This route file is loaded automatically by Backpack\Base.
// Routes you generate using Backpack\Generators will be placed here.

Route::group([
    'prefix'     => config('backpack.base.route_prefix', 'admin'),
    'middleware' => [
        config('backpack.base.web_middleware', 'web'),
        config('backpack.base.middleware_key', 'admin'),
    ],
    'namespace'  => 'App\Http\Controllers\Admin',
], function () { // custom admin routes
    Route::crud('user', 'UserCrudController');
    Route::crud('task', 'TaskCrudController');
    Route::crud('host-software', 'HostSoftwareCrudController');
    Route::crud('software', 'SoftwareCrudController');
    Route::crud('host', 'HostCrudController');
    Route::crud('log', 'LogCrudController');
    Route::crud('job', 'JobCrudController');
    Route::crud('billing', 'BillingCrudController');
    Route::crud('ticket', 'TicketCrudController');
    Route::crud('ticket-message', 'TicketMessageCrudController');
    Route::crud('affiliate', 'AffiliateCrudController');
    Route::crud('announcement', 'AnnouncementCrudController');
    Route::crud('software-test', 'SoftwareTestCrudController');
}); // this should be the absolute last line of this file
