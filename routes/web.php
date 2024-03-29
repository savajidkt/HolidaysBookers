<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\AboutUsController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ContactUsController;
use App\Http\Controllers\HotelListController;
use App\Http\Controllers\Admin\Apis\ApisController;
use App\Http\Controllers\Admin\User\UsersController;
use App\Http\Controllers\Admin\Roles\RolesController;
use App\Http\Controllers\Customer\WishlistController;
use App\Http\Controllers\Admin\Admin\AdminsController;
use App\Http\Controllers\Admin\Agent\AgentsController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Customer\MyProfileController;
use App\Http\Controllers\Admin\Cities\CitiesController;
use App\Http\Controllers\Admin\Orders\OrdersController;
use App\Http\Controllers\Admin\States\StatesController;
use App\Http\Controllers\Admin\Vendor\VendorController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Admin\Auth\AdminAuthController;
use App\Http\Controllers\Admin\Reachus\ReachusController;
use App\Http\Controllers\Customer\VerificationController;
use App\Http\Controllers\Admin\Freebies\FreebiesController;
use App\Http\Controllers\Admin\Packages\PackagesController;
use App\Http\Controllers\Customer\BookingHistoryController;
use App\Http\Controllers\Admin\Amenities\AmenitiesController;
use App\Http\Controllers\Admin\ApiHotels\ApiHotelsController;
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
use App\Http\Controllers\Admin\OfflineRooms\OfflineRoomsController;
use App\Http\Controllers\Admin\VehicleTypes\VehicleTypesController;
use App\Http\Controllers\Admin\OfflineHotels\OfflineHotelsController;
use App\Http\Controllers\Admin\PropertyTypes\PropertyTypesController;
use App\Http\Controllers\Admin\ProductMarkups\ProductMarkupsController;
use App\Http\Controllers\Admin\Surcharge\SurchargeController;
use App\Http\Controllers\WishlistController as FrontWishlistController;
use App\Http\Controllers\Agent\WishlistController as AgentWishlistController;
use App\Http\Controllers\Admin\WalletTransactions\WalletTransactionsController;
use App\Http\Controllers\Agent\DashboardController as AgentDashboardController;
use App\Http\Controllers\Agent\MyProfileController as AgentMyProfileController;
use App\Http\Controllers\Agent\QuotationController as AgentQuotationController;
use App\Http\Controllers\Agent\TransactionController as AgentTransactionController;
use App\Http\Controllers\Customer\DashboardController as CustomerDashboardController;
use App\Http\Controllers\Corporate\DashboardController as CorporateDashboardController;
use App\Http\Controllers\Agent\BookingHistoryController as AgentBookingHistoryController;
use App\Http\Controllers\Agent\DraftHistoryController as AgentDraftHistoryController;
use App\Http\Controllers\Agent\TravelCalendarController as AgentTravelCalendarController;
use App\Http\Controllers\Admin\Complimentaries\ComplimentariesController;
use App\Http\Controllers\Admin\HotelFacilities\HotelFacilitiesController;
use App\Http\Controllers\Admin\HotelFacility\HotelFacilityController;
use App\Http\Controllers\Admin\Promotional\PromotionalController;
use App\Http\Controllers\Admin\Settings\SettingsController;
use App\Http\Controllers\Admin\StayRequest\StayRequestController;
use App\Http\Controllers\Admin\StopSale\StopSaleController;


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
    Route::get('/agent/export', [AgentsController::class, 'agentExcelExport'])->name('agentExport');

    Route::resource('/packages', PackagesController::class);
    Route::post('/package/change-status', [PackagesController::class, 'changeStatus'])->name('change-package-status');
    Route::post('/package/get-cities-by-country', [PackagesController::class, 'getCitiesByCountryList'])->name('get-cities-by-country-url');
    Route::post('/package/change-status', [PackagesController::class, 'changeStatus'])->name('change-package-status');
    Route::post('/package/get-room-type-by-hotel', [PackagesController::class, 'getRoomTypeByHotel'])->name('get-room-type-by-hotel-url');
    Route::post('/package/get-meal-plan-by-hotel', [PackagesController::class, 'getMealPlanByHotel'])->name('get-meal-plan-by-hotel-url');

    Route::resource('/customers', CustomersController::class);
    Route::post('/customer/change-status', [CustomersController::class, 'changeStatus'])->name('change-customer-status');
    Route::get('/customer/view/{customer}/customer', [CustomersController::class, 'show'])->name('view-profile-customer');
    Route::post('/customer/update-password', [CustomersController::class, 'updatePassword'])->name('update-customer-password');
    Route::post('/customer/import-customers', [CustomersController::class, 'importCustomers'])->name('importsCustomers');
    Route::get('/customer/export', [CustomersController::class, 'customerExcelExport'])->name('customerExport');

    // Hotels Route
    Route::resource('/offlinehotels', OfflineHotelsController::class);
    Route::post('/offlinehotels/change-status', [OfflineHotelsController::class, 'changeStatus'])->name('change-offlinehotels-status');
    Route::post('/offlinehotels/import-offilnehotels', [OfflineHotelsController::class, 'importOfflineHotels'])->name('import-offline-hotels');
    Route::get('/offlinehotels/export', [OfflineHotelsController::class, 'offlineHotelsExport'])->name('offline-hotels-export');
    Route::post('/offlinehotel/delete-hotel-image', [OfflineHotelsController::class, 'deleteHotelImage'])->name('delete-hotel-image');
    Route::post('/offlinehotel/delete-hotel-gallery-image', [OfflineHotelsController::class, 'deleteHotelGalleryImage'])->name('delete-hotel-gallery-image');
    Route::get('/offlinehotel/rezelive-import', [OfflineHotelsController::class, 'importRezliveHotels'])->name('importRezliveHotels');
    // API Hotels
    //Route::resource('apihotels', ApiHotelsController::class);
    Route::get('/apihotels/rezlive-api', [ApiHotelsController::class, 'rezliveHotels'])->name('rezlive-api');


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

    Route::resource('/hotelfacility', HotelFacilityController::class);
    Route::post('/hotelfacility/change-hotelfacility-status', [HotelFacilityController::class, 'changeStatus'])->name('change-hotelfacility-status');


    Route::resource('/stayrequest', StayRequestController::class);
    Route::post('/stayrequest/change-stayrequest-status', [StayRequestController::class, 'changeStatus'])->name('change-stayrequest-status');
    
    Route::resource('/hotelfacilities', HotelFacilitiesController::class);
    Route::post('/hotelfacilities/change-hotelfacilities-status', [HotelFacilitiesController::class, 'changeStatus'])->name('change-hotelfacilities-status');
    

    Route::resource('/freebies', FreebiesController::class);
    Route::post('/freebies/change-status', [FreebiesController::class, 'changeStatus'])->name('change-freebies-status');
    Route::post('/freebies/add-freebies', [FreebiesController::class, 'addFreebiesPopup'])->name('add-freebies');

    Route::resource('/vehicletypes', VehicleTypesController::class);
    Route::post('/vehicletype/change-status', [VehicleTypesController::class, 'changeStatus'])->name('change-vehicletype-status');

    Route::resource('/countries', CountriesController::class);
    Route::post('/country/change-status', [CountriesController::class, 'changeStatus'])->name('change-country-status');
    Route::post('/country/import-countries', [CountriesController::class, 'importCountries'])->name('importsCountries');
    Route::get('/country/import-rezlive-country', [CountriesController::class, 'importRezliveCountry'])->name('import-rezlive-country');

    Route::resource('/states', StatesController::class);
    Route::post('/state/change-status', [StatesController::class, 'changeStatus'])->name('change-state-status');
    Route::post('/state/import-states', [StatesController::class, 'importStates'])->name('importsStates');

    Route::resource('/cities', CitiesController::class);
    Route::post('/city/change-status', [CitiesController::class, 'changeStatus'])->name('change-city-status');
    Route::post('/city/get-state', [CitiesController::class, 'getStateList'])->name('get-state-list');
    Route::post('/city/get-cities', [CitiesController::class, 'getCitiesList'])->name('get-city-list');
    Route::post('/city/import-cities', [CitiesController::class, 'importCities'])->name('importsCities');
    Route::get('/city/rezelive-import-cities', [CitiesController::class, 'importRezliveCities'])->name('importRezliveCities');

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

    Route::get('/offlineroom/roomlist/{id}', [OfflineRoomsController::class, 'hotelRooms'])->name('hotel-room-list');

    Route::get('/offlineroom/view/{offlineroom}/offlineroom', [OfflineRoomsController::class, 'show'])->name('view-room');
    Route::get('/offlineroom/{offlineroom}/price', [OfflineRoomsController::class, 'viewPrice'])->name('view-room-price');
    Route::get('/offlineroom/{offlineroom}/price/add', [OfflineRoomsController::class, 'createPrice'])->name('add-room-price');
    Route::post('/offlineroom/{offlineroom}/price/add', [OfflineRoomsController::class, 'storePrice'])->name('add-room-price');
    Route::post('/offlineroom/{offlineroom}/price/add', [OfflineRoomsController::class, 'storePrice'])->name('add-new-room-price');
    Route::get('/offlineroom/{id}/price/edit', [OfflineRoomsController::class, 'editPrice'])->name('edit-room-price');
    Route::post('/offlineroom/{offlineroomprice}/price/edit', [OfflineRoomsController::class, 'updatePrice'])->name('edit-room-price');
    Route::delete('/offlineroom/{offlineroomprice}/price/delete', [OfflineRoomsController::class, 'destroyPrice'])->name('delete-room-price');
    Route::post('/offlineroom/delete-room-image', [OfflineRoomsController::class, 'deleteRoomImage'])->name('delete-room-image');
    Route::post('/offlineroom/delete-room-gallery-image', [OfflineRoomsController::class, 'deleteRoomGalleryImage'])->name('delete-room-gallery-image');
    Route::get('/offlineroom/{offlinehotel}/create', [OfflineRoomsController::class, 'roomCreate'])->name('room-create');
    Route::get('/offlineroom/{offlinehotel}/room-list', [OfflineRoomsController::class, 'viewRoomList'])->name('room-room-lists');
    Route::get('/offlineroom/get-hotel-rooms/{id}', [OfflineRoomsController::class, 'hotelWiseRooms'])->name('get-hotel-rooms-url');
    Route::get('/offlineroom/view/{offlineroomprice}/offlineroomprice', [OfflineRoomsController::class, 'showPrice'])->name('show-room-price');
    Route::post('/offlineroom/delete-child', [OfflineRoomsController::class, 'deleteChild'])->name('delete-repeter');

    Route::resource('/mealplans', MealPlansController::class);
    Route::post('/mealplan/change-status', [MealPlansController::class, 'changeStatus'])->name('change-meal-plan-status');
    Route::post('/mealplan/add-meal-plan', [MealPlansController::class, 'addMealPlansPopup'])->name('add-meal-plan');
    Route::post('/add-surcharge-plan', [SurchargeController::class, 'addSurchargePlansPopup'])->name('add-surcharge-plan');
    Route::post('/add-surcharge-list-plan', [SurchargeController::class, 'addSurchargePlanListPopup'])->name('add-surcharge-list-plan');
    Route::post('/add-surcharge-list-edit-plan', [SurchargeController::class, 'addSurchargePlanListEditPopup'])->name('add-surcharge-list-edit-plan');
    Route::post('/add-surcharge-list-delete-plan', [SurchargeController::class, 'addSurchargePlanListDeletePopup'])->name('add-surcharge-list-delete-plan');

    Route::post('/add-complimentary-plan', [ComplimentariesController::class, 'addComplimentaryPlanPopup'])->name('add-complimentary-plan');
    Route::post('/add-complimentary-list-plan', [ComplimentariesController::class, 'addComplimentaryPlanListPopup'])->name('add-complimentary-list-plan');
    Route::post('/add-complimentary-list-edit-plan', [ComplimentariesController::class, 'addComplimentaryPlanListEditPopup'])->name('add-complimentary-list-edit-plan');
    Route::post('/add-complimentary-list-delete-plan', [ComplimentariesController::class, 'addComplimentaryPlanListDeletePopup'])->name('add-complimentary-list-delete-plan');

    Route::post('/add-stop-sale-plan', [StopSaleController::class, 'addStopSalePlanPopup'])->name('add-stop-sale-plan');
    Route::post('/add-stop-sale-list-plan', [StopSaleController::class, 'addStopSalePlanListPopup'])->name('add-stop-sale-list-plan');
    Route::post('/add-stop-sale-list-edit-plan', [StopSaleController::class, 'addStopSalePlanListEditPopup'])->name('add-stop-sale-list-edit-plan');
    Route::post('/add-stop-sale-list-delete-plan', [StopSaleController::class, 'addStopSalePlanListDeletePopup'])->name('add-stop-sale-list-delete-plan');

    Route::post('/add-promotional-plan', [PromotionalController::class, 'addPromotionalPlanPopup'])->name('add-promotional-plan');
    Route::post('/add-promotional-list-plan', [PromotionalController::class, 'addPromotionalPlanListPopup'])->name('add-promotional-list-plan');
    Route::post('/add-promotional-list-edit-plan', [PromotionalController::class, 'addPromotionalPlanListEditPopup'])->name('add-promotional-list-edit-plan');
    Route::post('/add-promotional-list-delete-plan', [PromotionalController::class, 'addPromotionalPlanListDeletePopup'])->name('add-promotional-list-delete-plan');

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

    Route::resource('/orders', OrdersController::class);
    Route::get('/order/view-order-payment/{order}', [OrdersController::class, 'viewPayment'])->name('view-order-payment');
    Route::post('/order/update-order-payment', [OrdersController::class, 'updatePayment'])->name('update-order-payment');
    Route::get('/order/order-invoice/{order}', [OrdersController::class, 'orderInvoice'])->name('order-invoice');
    Route::get('/order/order-invoice-download/{order}', [OrdersController::class, 'orderInvoiceDownload'])->name('order-invoice-download');
    Route::get('/order/order-voucher/{order}', [OrdersController::class, 'orderVoucher'])->name('order-voucher');
    Route::post('/order/order-voucher-download', [OrdersController::class, 'orderVoucherDownload'])->name('order-voucher-download');
    Route::get('/order/order-itinerary/{order}', [OrdersController::class, 'orderItinerary'])->name('order-itinerary');
    Route::get('/order/order-itinerary-download/{order}', [OrdersController::class, 'orderItineraryDownload'])->name('order-itinerary-download');

    Route::post('/order/change-status', [OrdersController::class, 'changeStatus'])->name('change-order-status');
    Route::post('/get-booking-calendar-list', [OrdersController::class, 'getBookingCalendarList'])->name('get-booking-calendar-list');

    Route::resource('/settings', SettingsController::class);
    Route::get('/agent-global-markup', [SettingsController::class, 'markupCreate'])->name('setting-global-markup');
    Route::post('/agent-global-markup-add', [SettingsController::class, 'markupStore'])->name('setting-global-markup-add');
    Route::post('/agent-global-markup-update/{id}', [SettingsController::class, 'markupUpdate'])->name('setting-global-markup-update');


    Route::get('/hb-email-setting', [SettingsController::class, 'emailCreate'])->name('setting-hb-email');
    Route::post('/hb-email-setting-add', [SettingsController::class, 'emailStore'])->name('setting-hb-email-add');
    Route::post('/hb-email-setting-update/{id}', [SettingsController::class, 'emailUpdate'])->name('setting-hb-email-update');
});

Auth::routes();

Route::group(['prefix' => 'agent', 'middleware' => ['agentauth']], function () {
    Route::get('/dashboard', [AgentDashboardController::class, 'dashboard'])->name('agent.dashboard');
    Route::get('/booking', [AgentDashboardController::class, 'booking'])->name('agent.booking');
    Route::get('/booking-history/{id}', [AgentBookingHistoryController::class, 'index'])->name('agent.booking-history');
    Route::get('/view-booking-history/{id}', [AgentBookingHistoryController::class, 'show'])->name('agent.view-booking-history');
    Route::get('/invoice-download/{order}', [AgentBookingHistoryController::class, 'orderInvoiceDownload'])->name('agent-invoice-download');
    Route::get('/voucher-download/{order}', [AgentBookingHistoryController::class, 'orderVoucherDownload'])->name('agent-voucher-download');
    Route::get('/export-single-order/{order}', [AgentBookingHistoryController::class, 'exportSingleOrder'])->name('agent-export-single-order');
    Route::post('/export-orders', [AgentBookingHistoryController::class, 'exportOrders'])->name('agent-export-orders');

    Route::get('/booking-hotel-cancel/{id}', [AgentBookingHistoryController::class, 'orderCancel'])->name('agent.booking-hotel-cancel');

    Route::get('/save-history/draft', [AgentDraftHistoryController::class, 'index'])->name('agent.draft');

    Route::get('/travel-calendar', [AgentTravelCalendarController::class, 'index'])->name('agent.travel-calendar');
    Route::get('/wishlist', [AgentWishlistController::class, 'index'])->name('agent.wishlist');
    Route::get('/my-profile', [AgentMyProfileController::class, 'editProfile'])->name('agent.my-profile');
    Route::post('/my-profile', [AgentMyProfileController::class, 'updateProfile'])->name('agent.my-profile');
    Route::get('/my-location', [AgentMyProfileController::class, 'editLocation'])->name('agent.my-location');
    Route::post('/my-location', [AgentMyProfileController::class, 'updateLocation'])->name('agent.my-location');
    Route::get('/my-change-password', [AgentMyProfileController::class, 'editChangePassword'])->name('agent.my-change-password');
    Route::post('/my-change-password', [AgentMyProfileController::class, 'updateChangePassword'])->name('agent.my-change-password');
    Route::get('/transaction/{id}', [AgentTransactionController::class, 'index'])->name('agent.transaction');
    Route::get('/quotation', [AgentQuotationController::class, 'index'])->name('agent.quotation');
    Route::get('/quotation/order-delete/{id}', [AgentQuotationController::class, 'deleteOrder'])->name('agent.order-delete');
    Route::get('/quotation/order-room-delete/{id}', [AgentQuotationController::class, 'deleteRoom'])->name('agent.order-room-delete');
    
    Route::get('/draft/draft-order-delete/{id}', [AgentDraftHistoryController::class, 'draftDeleteOrder'])->name('agent.draft-order-delete');
    Route::get('/draft/draft-order-room-delete/{id}', [AgentDraftHistoryController::class, 'draftDeleteRoom'])->name('agent.draft-order-room-delete');
    Route::get('/draft/view/{id}', [AgentDraftHistoryController::class, 'view'])->name('agent.draft-order-view');

    Route::get('/quotation/view/{id}', [AgentQuotationController::class, 'view'])->name('agent.order-view');
    Route::get('/quotation/order-download/{id}', [AgentQuotationController::class, 'downloadPdf'])->name('agent.order-download');
    Route::post('/quotation/order-send/{id}', [AgentQuotationController::class, 'sendEmailPdf'])->name('agent.order-send');
    Route::post('/quotation/edit-price', [AgentQuotationController::class, 'editPrice'])->name('agent.order-edit-price');
    //Route::get('/new-quotation', [AgentQuotationController::class, 'home'])->name('agent.new-quotation');

    Route::post('/hotel-list', [HotelListController::class, 'index'])->name('hotel-list');
    Route::get('/hotel-list', [HotelListController::class, 'index'])->name('hotel-list');
    Route::get('/hotel-details/{id}', [HotelListController::class, 'show'])->name('hotel-details');
    Route::get('/review-your-booking/{id}', [CheckoutController::class, 'checkout'])->name('review-your-booking');
    Route::resource('/checkout', CheckoutController::class);

    Route::post('/get-booking-list', [AgentDashboardController::class, 'getBookingList'])->name('get-booking-list');        
    Route::post('razorpaypayment', [CheckoutController::class, 'payOnOnline'])->name('razorpaypayment');
    Route::post('razorpaypayment-success', [CheckoutController::class, 'payOnOnlineSuccess'])->name('razorpaypaymentSuccess');
    Route::post('razorpaypayment-failed', [CheckoutController::class, 'payOnOnlineFailed'])->name('razorpaypaymentFailed');

    Route::get('cart', [CartController::class, 'index'])->name('cart');
    Route::post('remove-cart-hotel', [CartController::class, 'removeCartHotel'])->name('remove-cart-hotel');
    Route::post('save-cart-quote', [CartController::class, 'saveCartQuote'])->name('save-cart-quote');
    Route::get('remove-cart', [CartController::class, 'removeCart'])->name('remove-cart');
    Route::post('checkout/quote-add-to-cart', [CheckoutController::class, 'quoteTempStore'])->name('quote-temp-store');
    Route::post('checkout/draft-add-to-cart', [CheckoutController::class, 'draftTempStore'])->name('draft-temp-store');

    Route::get('/get-currencies', [CurrenciesController::class, 'getAllCurrencies'])->name('get-currencies');
    Route::post('/set-currencies', [CurrenciesController::class, 'setCurrencies'])->name('set-currencies');
});

Route::group(['prefix' => 'customer', 'middleware' => ['customerauth']], function () {
    Route::get('/dashboard', [CustomerDashboardController::class, 'dashboard'])->name('customer.dashboard');
    Route::get('/booking-history/{id}', [BookingHistoryController::class, 'index'])->name('customer.booking-history');
    Route::get('/wishlist', [WishlistController::class, 'index'])->name('customer.wishlist');
    Route::get('/verification', [VerificationController::class, 'index'])->name('customer.verification');
    Route::get('/verification/update/{id}', [VerificationController::class, 'edit'])->name('customer.verification-update');
    Route::post('/verification/update/{id}', [VerificationController::class, 'update'])->name('customer.verification-update');
   
    Route::get('/my-profile', [MyProfileController::class, 'editProfile'])->name('customer.my-profile');
    Route::post('/my-profile', [MyProfileController::class, 'updateProfile'])->name('customer.my-profile');
    Route::get('/my-location', [MyProfileController::class, 'editLocation'])->name('customer.my-location');
    Route::post('/my-location', [MyProfileController::class, 'updateLocation'])->name('customer.my-location');
    Route::get('/my-change-password', [MyProfileController::class, 'editChangePassword'])->name('customer.my-change-password');
    Route::post('/my-change-password', [MyProfileController::class, 'updateChangePassword'])->name('customer.my-change-password');
    
});

Route::group(['prefix' => 'corporate', 'middleware' => ['corporateauth']], function () {
    Route::get('/dashboard', [CorporateDashboardController::class, 'dashboard'])->name('corporate.dashboard');
});

# Front Routes
Route::group(['authGrouping' => 'users.auth'], function () {
    Route::get('/change-password', [ResetPasswordController::class, 'firstTimePasswordChange'])->name('change-password');
});


// Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::post('/city-hotel-list', [HotelListController::class, 'getLocations'])->name('city-hotel-list');
Route::get('/hotel-list-ajax', [HotelListController::class, 'ajaxHotelListing'])->name('hotel-list-ajax');
Route::post('/room-list-ajax', [HotelListController::class, 'ajaxRoomListing'])->name('room-list-ajax');

Route::get('/about-us', [AboutUsController::class, 'index'])->name('about-us');
Route::get('/contact-us', [ContactUsController::class, 'index'])->name('contact-us');
Route::post('/contact-us', [ContactUsController::class, 'submitForm'])->name('contact-us-submit');
Route::get('/offers', [OfferController::class, 'index'])->name('offers');

Route::post('/user/post-registration', [UserController::class, 'userPostRegistration'])->name('user-post-registration');
Route::post('/user/post-login', [UserController::class, 'userPostLogin'])->name('user-post-login');

Route::post('/checkout/post-registration', [CheckoutController::class, 'postRegistration'])->name('post-registration');
Route::post('/checkout/post-login', [CheckoutController::class, 'postLogin'])->name('post-login');

Route::post('/checkout/ajax', [CheckoutController::class, 'ajaxTempStore'])->name('ajax-temp-store');
Route::post('/checkout/ajax-remove', [CheckoutController::class, 'ajaxTempRemove'])->name('ajax-temp-remove');
Route::post('wishlist', [FrontWishlistController::class, 'store'])->name('add-to-wishlist');