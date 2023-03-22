<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Admin\Apis\ApisController;
use App\Http\Controllers\Admin\User\UsersController;
use App\Http\Controllers\Admin\Roles\RolesController;
use App\Http\Controllers\Admin\Admin\AdminsController;
use App\Http\Controllers\Admin\Agent\AgentsController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Admin\Cities\CitiesController;
use App\Http\Controllers\Admin\States\StatesController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Admin\Auth\AdminAuthController;
use App\Http\Controllers\Admin\Reachus\ReachusController;
use App\Http\Controllers\Admin\Packages\PackagesController;
use App\Http\Controllers\Admin\Amenities\AmenitiesController;
use App\Http\Controllers\Admin\Countries\CountriesController;
use App\Http\Controllers\Admin\Customers\CustomersController;
use App\Http\Controllers\Admin\Dashboard\DashboardController;
use App\Http\Controllers\Admin\MealPlans\MealPlansController;
use App\Http\Controllers\Admin\RoomTypes\RoomTypesController;
use App\Http\Controllers\Admin\Currencies\CurrenciesController;
use App\Http\Controllers\Admin\Language\LocalizationController;
use App\Http\Controllers\Admin\Permission\PermissionController;
use App\Http\Controllers\Admin\HotelGroups\HotelGroupsController;
use App\Http\Controllers\Admin\Permissions\PermissionsController;
use App\Http\Controllers\Admin\AgentMarkups\AgentMarkupsController;
use App\Http\Controllers\Admin\CompanyTypes\CompanyTypesController;
use App\Http\Controllers\Admin\Freebies\FreebiesController;
use App\Http\Controllers\Admin\OfflineRooms\OfflineRoomsController;
use App\Http\Controllers\Admin\VehicleTypes\VehicleTypesController;
use App\Http\Controllers\Admin\OfflineHotels\OfflineHotelsController;
use App\Http\Controllers\Admin\PropertyTypes\PropertyTypesController;
use App\Http\Controllers\Admin\ProductMarkups\ProductMarkupsController;
use App\Http\Controllers\Admin\WalletTransactions\WalletTransactionsController;

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

    Route::resource('/agents', AgentsController::class);
    Route::post('/agent/change-status', [AgentsController::class, 'changeStatus'])->name('change-agent-status');
    Route::post('/agent/update-password', [AgentsController::class, 'updatePassword'])->name('update-agent-password');
    Route::post('/agent/import-agents', [AgentsController::class, 'importAgents'])->name('importsAgents');
    Route::get('/agent/export',[AgentsController::class, 'agentExcelExport'])->name('agentExport');    

    Route::resource('/packages', PackagesController::class);
    Route::post('/package/change-status', [PackagesController::class, 'changeStatus'])->name('change-package-status');

    Route::resource('/customers', CustomersController::class);
    Route::post('/customer/change-status', [CustomersController::class, 'changeStatus'])->name('change-customer-status');
    Route::get('/customer/view/{customer}/customer', [CustomersController::class, 'show'])->name('view-profile-customer'); 
    Route::post('/customer/update-password', [CustomersController::class, 'updatePassword'])->name('update-customer-password');
    Route::post('/customer/import-customers', [CustomersController::class, 'importCustomers'])->name('importsCustomers');
    Route::get('/customer/export',[CustomersController::class, 'customerExcelExport'])->name('customerExport');   

    // Hotels Route
    Route::resource('/offlinehotels', OfflineHotelsController::class);
    Route::post('/offlinehotels/change-status', [OfflineHotelsController::class, 'changeStatus'])->name('change-offlinehotels-status');
    Route::post('/offlinehotels/import-offilnehotels', [OfflineHotelsController::class, 'importOfflineHotels'])->name('import-offline-hotels');
    Route::get('/offlinehotels/export',[OfflineHotelsController::class, 'offlineHotelsExport'])->name('offline-hotels-export'); 
    Route::post('/offlinehotel/delete-hotel-image', [OfflineHotelsController::class, 'deleteHotelImage'])->name('delete-hotel-image');     
    Route::post('/offlinehotel/delete-hotel-gallery-image', [OfflineHotelsController::class, 'deleteHotelGalleryImage'])->name('delete-hotel-gallery-image');     
    

    Route::resource('/hotelgroups', HotelGroupsController::class);
    Route::post('/hotelgroup/change-status', [HotelGroupsController::class, 'changeStatus'])->name('change-hotel-group-status');
    Route::post('/hotelgroup/add-group', [HotelGroupsController::class, 'addGroupPopup'])->name('add-group');
    

    Route::resource('/propertytypes', PropertyTypesController::class);
    Route::post('/propertytype/change-status', [PropertyTypesController::class, 'changeStatus'])->name('change-propertytype-status');
    Route::post('/propertytype/add-property', [PropertyTypesController::class, 'addPropertyPopup'])->name('add-property');
    
    Route::resource('/roomtypes', RoomTypesController::class);
    Route::post('/roomtype/change-status', [RoomTypesController::class, 'changeStatus'])->name('change-roomtype-status');
    Route::post('/roomtype/add-room-type', [RoomTypesController::class, 'addRoomTypePopup'])->name('add-room-type');

    Route::resource('/amenities', AmenitiesController::class);
    Route::post('/amenity/change-status', [AmenitiesController::class, 'changeStatus'])->name('change-amenity-status');
    Route::post('/amenity/add-amenity', [AmenitiesController::class, 'addAmenityPopup'])->name('add-amenity');

    Route::resource('/freebies', FreebiesController::class);
    Route::post('/freebies/change-status', [FreebiesController::class, 'changeStatus'])->name('change-freebies-status');
    Route::post('/freebies/add-freebies', [FreebiesController::class, 'addFreebiesPopup'])->name('add-freebies');

    Route::resource('/vehicletypes', VehicleTypesController::class);
    Route::post('/vehicletype/change-status', [VehicleTypesController::class, 'changeStatus'])->name('change-vehicletype-status');

    Route::resource('/countries', CountriesController::class);
    Route::post('/country/change-status', [CountriesController::class, 'changeStatus'])->name('change-country-status');
    Route::post('/country/import-countries', [CountriesController::class, 'importCountries'])->name('importsCountries');

    Route::resource('/states', StatesController::class);
    Route::post('/state/change-status', [StatesController::class, 'changeStatus'])->name('change-state-status');
    Route::post('/state/import-states', [StatesController::class, 'importStates'])->name('importsStates');

    Route::resource('/cities', CitiesController::class);
    Route::post('/city/change-status', [CitiesController::class, 'changeStatus'])->name('change-city-status');
    Route::post('/city/get-state', [CitiesController::class, 'getStateList'])->name('get-state-list');
    Route::post('/city/get-cities', [CitiesController::class, 'getCitiesList'])->name('get-city-list');
    Route::post('/state/import-cities', [CitiesController::class, 'importCities'])->name('importsCities');

    Route::resource('/apis', ApisController::class);
    Route::post('/api/change-status', [ApisController::class, 'changeStatus'])->name('change-api-status');

    Route::resource('/companytypes', CompanytypesController::class);
    Route::post('/companytype/change-status', [CompanytypesController::class, 'changeStatus'])->name('change-company-type-status');

    Route::resource('/reachus', ReachusController::class);
    Route::post('/reach/change-status', [ReachusController::class, 'changeStatus'])->name('change-reach-status');

    Route::resource('/productmarkups', ProductmarkupsController::class);
    Route::post('/productmarkup/change-status', [ProductmarkupsController::class, 'changeStatus'])->name('change-product-markup-status');

    Route::resource('/agentmarkups', AgentmarkupsController::class);
    Route::post('/agentmarkup/change-status', [AgentmarkupsController::class, 'changeStatus'])->name('change-agent-markup-status');


   // Route::resource('/wallettransactions', WalletTransactionsController::class);    
    Route::post('/wallettransaction/update-hb-credit', [WalletTransactionsController::class, 'updateHBCredit'])->name('update-hb-credit');    
    Route::get('/wallettransaction/{agent}/agent', [WalletTransactionsController::class, 'index'])->name('list-hb-credit');    
    Route::get('/wallettransaction/view/{agent}/agent', [WalletTransactionsController::class, 'show'])->name('view-profile'); 
       
    Route::resource('/offlinerooms', OfflineRoomsController::class);
    Route::post('/offlineroom/change-status', [OfflineRoomsController::class, 'changeStatus'])->name('change-offline-room-status');
    Route::get('/offlineroom/view/{offlineroom}/offlineroom', [OfflineRoomsController::class, 'show'])->name('view-room');     
    Route::get('/offlineroom/{offlineroom}/price', [OfflineRoomsController::class, 'viewPrice'])->name('view-room-price');     
    Route::get('/offlineroom/{offlineroom}/price/add', [OfflineRoomsController::class, 'createPrice'])->name('add-room-price');     
    Route::post('/offlineroom/{offlineroom}/price/add', [OfflineRoomsController::class, 'storePrice'])->name('add-room-price');     
    Route::get('/offlineroom/{id}/price/edit', [OfflineRoomsController::class, 'editPrice'])->name('edit-room-price');     
    Route::post('/offlineroom/{offlineroomprice}/price/edit', [OfflineRoomsController::class, 'updatePrice'])->name('edit-room-price');     
    Route::delete('/offlineroom/{offlineroomprice}/price/delete', [OfflineRoomsController::class, 'destroyPrice'])->name('delete-room-price');     
    Route::post('/offlineroom/delete-room-image', [OfflineRoomsController::class, 'deleteRoomImage'])->name('delete-room-image');     
    Route::post('/offlineroom/delete-room-gallery-image', [OfflineRoomsController::class, 'deleteRoomGalleryImage'])->name('delete-room-gallery-image');     
    Route::get('/offlineroom/{offlinehotel}/create', [OfflineRoomsController::class, 'roomCreate'])->name('room-create');     
    Route::get('/offlineroom/get-hotel-rooms/{id}', [OfflineRoomsController::class, 'hotelWiseRooms'])->name('get-hotel-rooms-url');     

    Route::resource('/mealplans', MealPlansController::class);
    Route::post('/mealplan/change-status', [MealPlansController::class, 'changeStatus'])->name('change-meal-plan-status');
    Route::post('/mealplan/add-meal-plan', [MealPlansController::class, 'addMealPlansPopup'])->name('add-meal-plan');

    Route::resource('/currencies', CurrenciesController::class);
    Route::post('/currency/change-status', [CurrenciesController::class, 'changeStatus'])->name('change-currency-status');
    
    Route::get('/generate-pdf/{id}', [UsersController::class, 'generatePDF'])->name('generate-pdf');
    Route::get('/chart-image/{id}', [UsersController::class, 'generateChartImage'])->name('chart-image');
    Route::post('/user/change-status', [UsersController::class, 'changeStatus'])->name('change-user-status');
    Route::post('/admin/change-status', [AdminsController::class, 'changeStatus'])->name('change-admin-status');
    Route::post('/role/change-status', [RolesController::class, 'changeStatus'])->name('change-role-status');
    Route::post('/permission/change-status', [PermissionsController::class, 'changeStatus'])->name('change-permission-status');

    Route::get('/export/{user}', [UsersController::class, 'reportExcelExport'])->name('export');
    Route::post('/save-chart-image', [UsersController::class, 'saveChartImage'])->name('save-chart-image');

    Route::get('index', [LocalizationController::class, 'index'])->name('index');
    Route::get('change/lang', [LocalizationController::class, 'lang_change'])->name('LangChange');
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