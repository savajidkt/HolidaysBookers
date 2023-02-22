<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Admin\User\UsersController;
use App\Http\Controllers\Admin\Roles\RolesController;
use App\Http\Controllers\Admin\Admin\AdminsController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Admin\Auth\AdminAuthController;
use App\Http\Controllers\Admin\Amenities\AmenitiesController;
use App\Http\Controllers\Admin\Countries\CountriesController;
use App\Http\Controllers\Admin\Dashboard\DashboardController;
use App\Http\Controllers\Admin\RoomTypes\RoomTypesController;
use App\Http\Controllers\Admin\Permission\PermissionController;
use App\Http\Controllers\Admin\HotelGroups\HotelGroupsController;
use App\Http\Controllers\Admin\Language\LocalizationController;
use App\Http\Controllers\Admin\Permissions\PermissionsController;
use App\Http\Controllers\Admin\VehicleTypes\VehicleTypesController;
use App\Http\Controllers\Admin\PropertyTypes\PropertyTypesController;

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

// Route::get('/', function () {
//     return view('welcome');
// });


Route::post('forgot-password', [ForgotPasswordController::class, 'forgotPassword'])->name('forgot-password');
Route::post('reset-password', [ForgotPasswordController::class, 'submitResetPasswordForm'])->name('reset.password.post');
Route::post('first-password-change', [UserController::class, 'changePassword'])->name('first.password.change');

Route::get('unsubscribe', [UserController::class, 'unSubscribe'])->name('unsubscribe');

#Admin Routes
Route::get('admin', [AdminAuthController::class, 'getLogin'])->name('adminLogin')->middleware('guest:admin');
Route::get('admin', [AdminAuthController::class, 'getLogin'])->name('adminLogin')->middleware('guest:admin');
Route::get('admin/login', [AdminAuthController::class, 'getLogin'])->name('adminLogin')->middleware('guest:admin');
Route::post('admin/login', [AdminAuthController::class, 'postLogin'])->name('adminLoginPost');
Route::get('admin/logout', [AdminAuthController::class, 'logout'])->name('adminLogout');

Route::group(['prefix' => 'admin', 'middleware' => 'auth:admin'], function () {

    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('get-dashboard', [DashboardController::class, 'getDashboardData'])->name('get-dashboard');
    Route::resource('/users', UsersController::class);
    Route::resource('/admins', AdminsController::class);
    Route::resource('/roles', RolesController::class);
    Route::resource('/permissions', PermissionsController::class);

    Route::resource('/hotelgroups', HotelGroupsController::class);
    Route::post('/hotelgroup/change-status', [HotelGroupsController::class, 'changeStatus'])->name('change-hotel-group-status');

    Route::resource('/propertytypes', PropertyTypesController::class);
    Route::post('/propertytype/change-status', [PropertyTypesController::class, 'changeStatus'])->name('change-propertytype-status');

    Route::resource('/roomtypes', RoomTypesController::class);
    Route::post('/roomtype/change-status', [RoomTypesController::class, 'changeStatus'])->name('change-roomtype-status');

    Route::resource('/amenities', AmenitiesController::class);
    Route::post('/amenity/change-status', [AmenitiesController::class, 'changeStatus'])->name('change-amenity-status');

    Route::resource('/vehicletypes', VehicleTypesController::class);
    Route::post('/vehicletype/change-status', [VehicleTypesController::class, 'changeStatus'])->name('change-vehicletype-status');

    Route::resource('/countries', CountriesController::class);
    Route::post('/country/change-status', [CountriesController::class, 'changeStatus'])->name('change-country-status');

    Route::get('/generate-pdf/{id}', [UsersController::class, 'generatePDF'])->name('generate-pdf');
    Route::get('/chart-image/{id}', [UsersController::class, 'generateChartImage'])->name('chart-image');
    Route::post('/user/change-status', [UsersController::class, 'changeStatus'])->name('change-user-status');
    Route::post('/admin/change-status', [AdminsController::class, 'changeStatus'])->name('change-admin-status');
    Route::post('/role/change-status', [RolesController::class, 'changeStatus'])->name('change-role-status');
    Route::post('/permission/change-status', [PermissionsController::class, 'changeStatus'])->name('change-permission-status');

    Route::get('/export/{user}',[UsersController::class, 'reportExcelExport'])->name('export');
    Route::post('/save-chart-image', [UsersController::class, 'saveChartImage'])->name('save-chart-image');

    Route::get('index',[LocalizationController::class, 'index'])->name('index');
    Route::get('change/lang',[LocalizationController::class, 'lang_change'])->name('LangChange');
   
});

Auth::routes();
// Route::post('/login', [
//     'uses'          => 'App\Http\Controllers\Auth\LoginController@login',
//     'middleware'    => 'checkstatus',
// ]);
# Front Routes
Route::group(['authGrouping' => 'users.auth'], function () {
    Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware('checkSurveyStatus');
    Route::get('/change-password', [ResetPasswordController::class, 'firstTimePasswordChange'])->name('change-password');
    //Route::resource('/survey', SurveyController::class);
    // Route::get('/thank-you', [App\Http\Controllers\SurveyController::class, 'thankYou'])->name('thank-you')->middleware('checkSurveyStatus');
    // Route::get('/time-out', [App\Http\Controllers\SurveyController::class, 'timeOut'])->name('time-out')->middleware('checkSurveyStatus');
    // Route::get('/take-survey', [App\Http\Controllers\SurveyController::class, 'index'])->name('take-survey')->middleware('checkSurveyStatus');
    // Route::post('/take-survey/store', [App\Http\Controllers\SurveyController::class, 'store'])->name('take-survey-store');
    // Route::post('/get-question', [App\Http\Controllers\SurveyController::class, 'getQuestion'])->name('get-question');
    // Route::get('/demographic', [App\Http\Controllers\SurveyController::class, 'demographic'])->name('demographic');

    // Route::post('/update-survey-time', [App\Http\Controllers\SurveyController::class, 'updateSurveyTime'])->name('update-survey-time');
    // Route::post('/demographic-save', [App\Http\Controllers\UserController::class, 'demoGraphicSave'])->name('demographic-save');

    //Route::get('/export/{id}',[UsersController::class, 'reportExcelExport'])->name('survey-export');
    Route::get('/user/survey-export/{id}', [App\Http\Controllers\UserController::class, 'reportExcelExport'])->name('survey-export');
    // Route::get('/demo-survey', [App\Http\Controllers\SurveyController::class, 'demoSurvey'])->name('demo-survey');
});


// Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');