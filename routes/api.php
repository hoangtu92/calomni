<?php


use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/**
 * Authentication API
 */
Route::prefix("auth")->group(function () {
    //Login
    Route::post('/login', "Api\UserController@login");

    //Logout
    Route::post('/logout', "Api\UserController@logout");
});

/**
 * Protected API
 */
Route::middleware(["verified", "auth:sanctum"])->group(function () {

    Route::prefix("user")->group(function (){
        //Get current user information
        Route::get('/', "Api\UserController@detail");
        Route::get("/tasks", "Api\UserController@tasks");
    });

    /**
     * Host API
     */
    Route::prefix("host")->group(function () {

        //Create host
        Route::post("/create", "Api\HostController@create");

        //List all current user's host
        Route::get("/list", "Api\HostController@list");

        Route::get("/tasks", "Api\HostController@tasks");

        //Get host info
        Route::get("/item/{token}", "Api\HostController@detail");

        //Update host info
        Route::post("/item/{token}", "Api\HostController@update");


        Route::delete("/item/{token}", "Api\HostController@delete");
    });


    /**
     * Host API
     */
    Route::prefix("software")->group(function () {

        //Get list of all software
        Route::get("/list", "Api\SoftwareController@list");
        Route::get("/sh_list", "Api\SoftwareController@sh_list");

        //Get all verified host (that can run current software)
        Route::get("/{id}/verified-hosts", "Api\SoftwareController@host_software");

        //Get software info
        Route::get("/{id}/item", "Api\SoftwareController@detail");

        //Update host software price
        Route::post("/{id}/item", "Api\SoftwareController@update_price");

        //Request to test the software with current host
        //Host will send this api to indicate that user want to test the software in their machine
        Route::post("/{id}/test", "Api\SoftwareController@request_for_testing");

        //After running test. Host Update test information back to CS
        Route::put("/{id}/test", "Api\SoftwareController@submit_test_result");


    });

    /**
     * Job API
     */
    Route::prefix("job")->group(function (){

        Route::post("/create", "Api\JobController@create");

        //RH get all jobs of himself
        Route::get("/list", "Api\JobController@list");

        //SH get all job assigned to current host
        Route::get("/assignments", "Api\JobController@host_assignments");

        Route::get("/{id}/item", "Api\JobController@detail");

        //Assign another host to job
        Route::put("/{id}/item", "Api\JobController@assign_host");

        //upload additional files to the job
        Route::post("/{id}/item", "Api\JobController@upload_file");

        Route::delete("/{id}/item", "Api\JobController@delete");


        //Task
        Route::get("/{id}/tasks", "Api\JobController@tasks");
        Route::post("/{id}/start", "Api\JobController@startJob");
        Route::post("/{id}/stop", "Api\JobController@stopJob");

        Route::post("/{id}/report", "Api\JobController@report");
        Route::get("/{id}/download_report", "Api\JobController@download_report");
    });

    Route::prefix("billing")->group(function (){

        //List all billing records of current user (RH)
        #Route::get("/my-bills", "Api\BillingController@list");


        //List income of host user
        #Route::get("/income", "Api\BillingController@list");
    });



});
