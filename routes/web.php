<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware("announcement")->get('/', "FrontendController@home")->name("home");
Route::get('/sign-up-host', "FrontendController@signUpHost")->name("sign_up_host");
Route::any('/sign-up-host-verification', "FrontendController@signUpHostVerification")->name("sign_up_host_verification");

Route::get('/sign-up', "FrontendController@signUp")->name("signup");
Route::get("/sign-up-email-verification", "FrontendController@signUpVerification")->name("sign_up_verification");
Route::get("/sign-up-complete", "FrontendController@signUpComplete")->name("sign_up_complete");

Auth::routes(['verify' => true]);
Route::get("/test", function (){
    $zipFileName = md5('12').'.zip';
    $zip = new ZipArchive();
    $job_dir = public_path()."/jobs/";

    $zip->open( $job_dir .$zipFileName, ZipArchive::CREATE);
    $zip->addFile(base_path()."/public/index.php", "index.php");
    var_dump($zip);
    $zip->close();

});

Route::get("/mailtest", function (){
    dd(env('MAIL_DRIVER'));

});
