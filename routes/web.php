<?php
// a.nabiil
use App\loginHistory as logActivity;
use App\Events\Notifications as notifyEvent;
use App\Notification as notifyModel;

// a.nabiil
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

if (version_compare(PHP_VERSION, '7.2.0', '>=')) {
    // Ignores notices and reports all other kinds... and warnings
    error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
    // error_reporting(E_ALL ^ E_WARNING); // Maybe this is enough
}

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::any('check-invoices-status', 'CronJobsController@Check_Invoices_status');

Route::any('welcome_message', function () {
    App\User::where('id', Auth::user()->id)->update(['welcome' => 1]);
    return 1;
});

Route::get('lang/{lang}', function ($lang) {

    Session::put('locale', $lang);

    return redirect()->back();
})->where(['lang' => 'en|ar']);

/*Route::get('/', function () {
    //return bcrypt('admin123');
    return redirect('admin/login');
})->name('index');*/

Route::get('url_check', function () {
    if (Auth::guard('web')->check() == true) {
        return redirect()->route('home');
    } else {
        return redirect('admin/login');
    }
});


Route::get('pass', function () {
    return ActivityLabel('items');
    return bcrypt('admin123');
})->name('index');

// ** INIT BOOKING ** //

//Route::get('/','UserBookingController@loadBooking')->name('index');
Route::post('weblogin', 'Auth\LoginController@frontlogin');
//Route::get('login', 'Auth\LoginController@Getlogin');
//Route::post('dologin', 'Auth\LoginController@dologin');
Route::any('logout', 'Auth\LoginController@logout');

Route::any('password/reset', 'Auth\ForgotPasswordController@PasswordRequest');
Route::any('password/email', 'Auth\ForgotPasswordController@PasswordSendmail');
Route::any('password/resetcustomer/{token}', 'Auth\ForgotPasswordController@PasswordReset');
Route::any('password/request', 'Auth\ForgotPasswordController@PasswordConfirm');

// Route::get('register/first_setting','CompleteRegisterController@index');
// Route::post('register/first_setting','CompleteRegisterController@add');
// Route::get('welcome','WelcomeController@index');
Route::get('master_auto_login/{token}/{lang}', 'WelcomeController@masterAutoLogin');
Route::get('register/check_phone', 'CompleteRegisterController@checkPhone');

Route::prefix('admin')->group(function () {
    // ** AUTHORIZATION ROUTE ** //
    Auth::routes();
    Route::post('login', 'Auth\LoginController@admin_login')->name('login');

    Route::get('password/reset', 'Auth\ForgotPasswordController@PasswordRequest');
    Route::post('password/email', 'Auth\ForgotPasswordController@PasswordAdminSendmail')->name('password.email');
    Route::get('password/reset/{token}', 'Auth\ForgotPasswordController@PasswordAdminReset');
    Route::post('password/request', 'Auth\ForgotPasswordController@PasswordAdminConfirm')->name('password.request');









    Route::post('logout', function () {
        // a.nabiil
        $addlogActivity = new logActivity();
        $addlogActivity->user_id = Auth::user()->id;
        $addlogActivity->org_id = Auth::user()->org_id;
        $addlogActivity->status = "logout";
        $user = Auth::user();
        // after logout  add save notify code and send event 
        Auth::guard('web')->logout();

        Session::forget('partents');
        Session::forget('childs');
        Session::forget('links');
        Session::forget('isadmin');
        $addlogActivity->save();
        event(new notifyEvent($user, $addlogActivity, 'logout'));
        // a.nabiil
        return redirect('admin/login');
    });
});

Route::any('ajax/logout', 'AjaxController@logout');
Route::any('ajax/login', 'AjaxController@login');

Route::get('invoice/{id}', 'ShareInvoiceController@index');
Route::get('hotel/invoice/{id}', 'ShareInvoiceController@hotel_reservation');
Route::post('share_submit', 'ShareInvoiceController@share_submit');
Route::post('hotel_share_submit', 'ShareInvoiceController@hotel_share_submit');
Route::get('invoice/{id}/{type}/share', 'ShareInvoiceController@share');

Route::get('card/{id}', 'ShareInvoiceController@card');
Route::post('card_submit', 'ShareInvoiceController@card_submit');
Route::post('share-print', 'ShareInvoiceController@share_print');

Route::post('share-invoice', 'ShareInvoiceController@share_invoice');
Route::get('membership/{id}', 'ShareInvoiceController@Membership');
// ** USER ROLE ADMIN ROUTES ** //

Route::group(['prefix' => 'admin', 'middleware' => 'admin'], function () {
    Route::get('login_user/ajax', 'Auth\LoginController@sessionTimeOutLogin');
    Route::any('session_log_out', function () {
        Auth::guard('web')->logout();
        Session::forget('isadmin');
        return redirect('admin/login');
    });
    Route::post('register/first_setting', 'CompleteRegisterController@add');
    Route::group(['middleware' => 'NotAccessWithActivity'], function () {
        Route::get('register/first_setting', 'CompleteRegisterController@index');

    });
    

        Route::get('welcome', 'WelcomeController@index');
        Route::any('dashboard', 'HomeController@index')->name('home');
        Route::get('/', function () {
            return redirect('login');
        })->name('index');


        //Inbox
        Route::get('inbox/users', 'NotificationsController@users_index');
        Route::get('inbox/users/message/{id}', 'NotificationsController@users_messages');
        Route::post('inbox/users/messages/new', 'NotificationsController@users_new_message');
        Route::any('inbox/users/messages/search', 'NotificationsController@users_search');
        Route::any('inbox/messages/fetch', 'NotificationsController@fetch_messages');

        Route::get('inbox/customers', 'NotificationsController@customers_index');
        Route::get('inbox/customers/message/{id}', 'NotificationsController@customers_messages');
        Route::post('inbox/customers/messages/new', 'NotificationsController@customers_new_messages');
        Route::post('inbox/customers/messages/search', 'NotificationsController@customers_search');


        //Notifications
        Route::post('notification/reply/{id}', 'NotificationsController@customer_reply');
        Route::any('notification/user_message/{id}', 'NotificationsController@UsersMessage');
        Route::post('notification/send_message', 'NotificationsController@AddUsersMessage');

        Route::any('users/validator/{type}', 'AdminUsersController@Validator');
        Route::resource('users', 'AdminUsersController');
        Route::resource('employees', 'AdminUsersController');
        Route::get('users/{id}/change-password', 'AdminUsersController@getPassword');
        Route::post('users/change-password', 'AdminUsersController@change_password');
        Route::get('users/send-password/{id}', 'AdminUsersController@SendPassword')->name('users.send_password');

        Route::post('users-type', 'AdminUsersController@UsersType')->name('usersType');
        Route::get('users/{id}/profile', 'AdminUsersController@getProfile');

        Route::get('customers/{id}/print', 'CustomersController@getPrint');
        //Route::any('customers/search', 'CustomersController@GetSearch');
        Route::get('customers/search', 'CustomersController@index');
        Route::post('customers/search', 'CustomersController@GetSearch');
        Route::any('customers/search/{type}', 'CustomersController@search');
        Route::get('customers/{id}/change-password', 'CustomersController@getPassword');
        Route::post('customers/change-password', 'CustomersController@change_password');
        Route::resource('/roles', 'RolesController');
      
        Route::resource('functions', 'FunctionsController');
        Route::resource('/customers', 'CustomersController');
        Route::resource('/sections', 'AdminSectionsController');

        Route::resource('/weekly_vacations', 'WeeklyVacationsController');
        Route::resource('/yearly_vacations', 'YearlyVacationsController');

        Route::resource('/available', 'AvailableController');
        Route::get('/available/active/{id}/{value}', 'AvailableController@Active');

        Route::get('/transactions/{id}/edit', 'TransactionsController@edit');
        Route::get('items', 'TransactionsController@GetItems');

        Route::resource('transactions', 'TransactionsController');

        Route::get('transactions/{id}/transactions', 'TransactionsController@GetTransactions');
        Route::get('transactions/{id}/search', 'TransactionsController@GetSearchResults');
        Route::get('transactions/create/{id}', 'TransactionsController@GetHead');
        Route::any('search', 'TransactionsController@GetSearch');
        Route::get('transactions/{id}/print', 'TransactionsController@Print');
        Route::any('transactions/item-details', 'TransactionsController@Details');
        Route::any('transactions/transactions-item-price', 'TransactionsController@TransactionsPrice');

        Route::get('transactions/paid/{id}', 'TransactionsController@PaidInvoice');
        Route::post('transactions/invoice/create-paid', 'TransactionsController@CreatePaid');

        Route::get('settings/create_template', 'AdminSettingsController@create_template');
        Route::get('settings/select_template/{name}', 'AdminSettingsController@select_template');
        Route::post('settings/customize_template', 'AdminSettingsController@customize_template');
        Route::get('settings/customize_template/{template_id}', 'AdminSettingsController@customize');
        Route::post('settings/invoice_template', 'AdminSettingsController@invoice_template');
        Route::post('settings/customize_update', 'AdminSettingsController@customize_update');

        Route::post('settings/invoice_setup', 'AdminSettingsController@invoice_setup');
        Route::get('settings/invoice-setup-type-value/{id}', 'AdminSettingsController@invoice_setup_value');

        Route::get('/settings/{type}', 'AdminSettingsController@settings_view');
        Route::get('/settings/tax/{id}', 'AdminSettingsController@GetTax');
        Route::post('settings/tax', 'AdminSettingsController@Tax');
        Route::post('settings/banking', 'AdminSettingsController@Banking');
        Route::get('/settings/banking/{id}', 'AdminSettingsController@GetBanking');
        Route::any('/settings/banking/delete/{id}', 'AdminSettingsController@Bankdestroy');
        Route::get('/settings/banking/default/{id}/{value}', 'AdminSettingsController@DefaultBanking');

        Route::get('categories_type/items', 'CategoriesTypeController@index');
        Route::get('categories_type/offers', 'CategoriesTypeController@index');
        Route::get('categories_type/items/offers', 'CategoriesTypeController@index');
        Route::post('categories_type/store', 'CategoriesTypeController@store');

        Route::get('categories_type/suggestion', 'CategoriesTypeController@index');
        Route::get('categories_type/suggest_product', 'CategoriesTypeController@index');
        Route::post('categories_type/add_suggest_product', 'CategoriesTypeController@AddSuggestProduct');
        Route::get('categories_type/suggest_product/{id}/edit', 'CategoriesTypeController@ViewSuggestProduct');
        Route::any('categories_type/edit_suggest_product/{id}', 'CategoriesTypeController@EditSuggestProduct');
        Route::get('categories_type/suggestion-details/{id}', 'CategoriesTypeController@SuggestionDetails');

        Route::get('categories/{type}/create', 'CategoriesController@create')->where('type', '1|2');
        Route::get('categories/{type}/{id}/edit', 'CategoriesController@edit')->where('type', '1|2');
        Route::get('categories/{type}/list', 'CategoriesController@index')->where('type', '1|2');
        Route::any('categories/search', 'CategoriesController@search');
        Route::any('categories/{id}/destroy', 'CategoriesController@destroy');
        
        Route::get('categories/photos/del/{id?}', 'CategoriesController@delPhoto');

        Route::resource('/categories', 'CategoriesController');

        Route::get('categories_type/{type}/create', 'CategoriesTypeController@create')->where('type', '1|2');
        Route::get('categories_type/{type}/{id}/edit', 'CategoriesTypeController@edit')->where('type', '1|2');
        Route::get('categories_type/{type}/list', 'CategoriesTypeController@index')->where('type', '1|2');
        Route::resource('/categories_type', 'CategoriesTypeController');
          Route::post('categories_type/update', 'CategoriesTypeController@update');
        Route::get('/categories/get-type/{type}', 'CategoriesController@GetType');
        Route::get('/categories/get-categories/{type}', 'CategoriesController@GetCategories');

        // Transactions  -  invoices by ahmed
        Route::post('ajax/tax', 'AjaxController@Tax');
        Route::post('ajax/categories_type', 'AjaxController@CategoriesType');
        Route::post('ajax/add_customer', 'AjaxController@AddCustomer');
        Route::get('ajax/categories_modal/{type}', 'AjaxController@CategoriesModal');
        Route::post('ajax/add_categories', 'AjaxController@AddCategories');
        Route::post('ajax/edit_categories', 'AjaxController@EditCategories');
        Route::get('ajax/price_modal', 'AjaxController@PriceModal');
        Route::post('ajax/add_price', 'AjaxController@AddPrice');
        Route::post('ajax/add_section', 'AjaxController@addSection');
        Route::post('ajax/add_measure', 'AjaxController@addMeasure');
        Route::post('ajax/update_measures', 'AjaxController@updateMeasures');
        Route::get('ajax/measure_list/{id}', 'AjaxController@MeasureList');
        Route::post('ajax/add_companies', 'AjaxController@AddCompanies');
        Route::post('ajax/add_supplier', 'AjaxController@AddSupplier');
        Route::post('ajax/add_suppliers_items', 'AjaxController@AddSupplierItems');
        Route::post('ajax/add_store', 'AjaxController@AddStore');
        Route::get('ajax/category_modal/{id}/{type}', 'AjaxController@CategoryModal');
        Route::post('ajax/availability_update_price', 'AjaxController@UpdatePrice')->name('availability_update_price');

        Route::get('price_list/{type}/create', 'PriceListController@create')->where('type', '1|2');
        Route::get('price_list/{type}/{id}/edit', 'PriceListController@edit')->where('type', '1|2');
        Route::get('price_list/{type}/list', 'PriceListController@index')->where('type', '1|2');
        Route::resource('/price_list', 'PriceListController');
        Route::get('/price_list/get-categories/{type}', 'PriceListController@GetCategories');
        Route::get('/price_list/get-tax/{id}', 'PriceListController@GetTax');
        Route::get('/price_list/check-price/{id}/{date}', 'PriceListController@CheckPrice');
        Route::get('/price_list/check-purchasing-price/{id}/{value}', 'PriceListController@CheckPurchasingPrice');
        
        Route::get('offers/properties', 'OffersController@PropertiesView');
        Route::get('offers/properties/create', 'OffersController@PropertiesCreate');
        Route::get('offers/properties/{id}/edit', 'OffersController@PropertiesEdit');
        Route::get('offers/properties/{id}/delete', 'OffersController@PropertiesDelete');
        Route::post('offers/properties/store', 'OffersController@Properties')->name('offers.properties_store');
        Route::any('offers/properties/{id}/update', 'OffersController@PropertiesUpdate')->name('offers.properties_edit');


        Route::get('offers/service', 'OffersController@ServiceView');
        Route::get('offers/service/{id}/edit', 'OffersController@ServiceEdit');
        Route::get('offers/service/{id}/delete', 'OffersController@ServiceDelete');

        Route::get('offers/service/create', 'OffersController@ServiceCreate');
        Route::any('offers/service/{id}/update', 'OffersController@ServiceUpdate')->name('offers.service_edit');
        Route::post('offers/service/store', 'OffersController@Service')->name('offers.service_store');


        Route::get('offers/{type}/create', 'OffersController@create')->where('type', '1|2');
        Route::get('offers/{type}/{id}/edit', 'OffersController@edit')->where('type', '1|2');
        Route::get('offers/{type}/list', 'OffersController@index')->where('type', '1|2');
        Route::resource('/offers', 'OffersController');
        Route::get('/offers/get-categories/{type}', 'OffersController@GetCategories');
        Route::get('/offers/get-price/{id}', 'OffersController@GetPrice');

        Route::get('suppliers/invoices', 'SuppliersController@Invoices');
        Route::get('suppliers/locators/{id}', 'SuppliersController@GetLocators');
        Route::get('suppliers/damaged', 'SuppliersController@GetDamaged');
        Route::get('suppliers/damaged/{id}', 'SuppliersController@showDamaged');
        Route::any('suppliers/damaged/destroy/{id}', 'SuppliersController@DeleteDamaged');

        Route::post('suppliers/update-damaged/{id}', 'SuppliersController@CreateDamaged');
        Route::any('suppliers/search', 'SuppliersController@Search');
        Route::any('suppliers/accounts', 'SuppliersController@Accounts');

        Route::get('suppliers/search/invoices/{id}', 'SuppliersController@invoiceids');
        Route::any('suppliers/items/{id}', 'SuppliersController@Items');
        Route::any('suppliers/invoice_no/{id}/{invoice}', 'SuppliersController@InvoiceCheck');

        Route::resource('suppliers', 'SuppliersController');
        Route::get('suppliers/{id}/items', 'SuppliersController@GetItems');
        Route::post('suppliers/update-items/{id}', 'SuppliersController@UpdateItems');
        Route::post('suppliers/create-invoice', 'SuppliersController@CreateInvoice');
        Route::get('suppliers/{id}/invoices', 'SuppliersController@GetInvoices');
        Route::get('suppliers/invoice/{id}', 'SuppliersController@GetInvoice');
        Route::get('suppliers/invoice/paid/{id}', 'SuppliersController@PaidInvoice');
        Route::get('suppliers/invoice/last-price/{id}/{invoice}', 'SuppliersController@GetPrice');
        Route::post('suppliers/invoice/create-paid', 'SuppliersController@CreatePaid');
        Route::get('suppliers/price/{id}', 'SuppliersController@Details');
        Route::post('suppliers/create-damaged', 'SuppliersController@CreateDamaged');
        Route::get('suppliers/supplier_item/{id}', 'SuppliersController@supplier_item');
        Route::get('stores/report', 'StoresReportController@Stores');
        Route::get('stores/value-report', 'StoresReportController@Store_value');

        Route::any('transactions/store-quantity/{id}/{store_id}', 'TransactionsController@StoreQuantity');

        Route::resource('/stores', 'StoresController');
        Route::get('/stores/{id}/locators', 'StoresController@GetLocators');
        Route::get('/stores/default/{id}/{value}', 'StoresController@DefaultStore');

        Route::resource('/locators', 'LocatorsController');

        Route::get('measures/terms', 'MeasuresController@Terms')->name('measures.terms');
        Route::get('measures/assign', 'MeasuresController@Assign')->name('measures.assign');
        Route::any('measures/search', 'MeasuresController@Search');
        Route::any('measures/reports', 'MeasuresController@Reports');

        Route::resource('measures', 'MeasuresController');
        Route::post('measures/create-terms', 'MeasuresController@CreateTerms');
        Route::get('measures/terms/{id}', 'MeasuresController@Term');
        Route::any('measures/terms/update/{id}', 'MeasuresController@UpdateTerm');
        Route::get('measures/assign/{id}', 'MeasuresController@NewAssign');
        Route::post('measures/assign/create-assign', 'MeasuresController@CreateAssign');
        Route::get('measures/assign/{id}/edit', 'MeasuresController@GetAssign');
        Route::any('measures/assign/update/{id}', 'MeasuresController@UpdateAssign');
        Route::get('measures/assign/{id}/list', 'MeasuresController@GetAssignlist');
        Route::get('measures/order/{id}', 'MeasuresController@Order');
        Route::get('measures/order/{id}/store', 'MeasuresController@Order');
        Route::get('measures/customer/order', 'MeasuresController@CustomerOrder');

        Route::post('measures/assign/create-order', 'MeasuresController@CreateOrder');
        Route::get('measures/order/details/{id}', 'MeasuresController@GetOrder');
        Route::get('measures/order/show/{id}', 'MeasuresController@ShowOrder');
        Route::any('measures/order/update/{id}', 'MeasuresController@UpdateOrder');

        Route::post('measures/order/confirm/{id}', 'MeasuresController@ConfirmOrder');
        Route::get('measures/order/refund/{id}', 'MeasuresController@RefundOrder');
        Route::post('measures/order/delivery/{id}', 'MeasuresController@DeliveryOrder');
        Route::post('measures/order/cancel/{id}', 'MeasuresController@CancelOrder');

        Route::post('/news/savenew', 'newController@store');
        Route::get('/news', 'newController@shownews');
        Route::get('/news/{new}/edit', 'newController@edit');
        Route::post('/news/{new}/update', 'newController@update');
        Route::get('/news/{new}/delete', 'newController@delete');
        Route::get('/news/savenew', 'newController@openstore');

        Route::get('/orgs', 'orgController@GetOrgs');
        Route::get('/orgs/{id}/edit', 'orgController@edit');
        Route::post('/orgs/update/{id}', 'orgController@updata');

        Route::resource('/settings', 'AdminSettingsController');
        Route::post('/settings/display', 'AdminSettingsController@Display');

        Route::get('/settings/delete_template/{template_id}', 'AdminSettingsController@delete_template');
        Route::post('settings/payment', 'AdminSettingsController@payment_setting');

        Route::get('purchases/{iuser}/{type}', 'PurchasesReportController@Purchases');
        Route::get('exports/{user}/{type}', 'PurchasesReportController@exports');

        Route::get('attendance', 'PayrollController@attendance');
        Route::any('attendance/list', 'PayrollController@index');
        Route::post('attendance/create', 'PayrollController@attendance_create')->name('attendance.create');
        Route::post('attendance/update', 'PayrollController@attendance_update');
        Route::any('attendance/colsed-list', 'PayrollController@attendance_colsed');

        Route::resource('/companies', 'CompaniesController');

        //<!-- Mostafa Change Last Modified  02/06/2019 14:49:7  -->
        Route::get('/reservations', 'ReservationController@index');
        Route::post('/reservations', 'ReservationController@store');
        Route::post('/reservations', 'ReservationController@storeadmin');
        Route::put('/reservations/{id}', 'ReservationController@update');
        Route::get('/reservations/{id}/edit', 'ReservationController@edit');
        Route::any('/reservations/search', 'ReservationController@getReservationsWithFilters');
        Route::get('/reservations/create', 'ReservationController@getAdminReservation');
        Route::get('/reservations/{id}/confirm', 'ReservationController@confirm');
        Route::get('/reservations/{id}/cancel', 'ReservationController@cancel');
        Route::get('/reservations/{id}/show', 'ReservationController@show');
        Route::post('/reservations/update', 'ReservationController@update');
        Route::get('/reservation_details/{id}','ReservationController@getReservedData');
        

        Route::get('/reservations/test', 'ReservationController@test');

        Route::get('/reservations/getCategories/{category_type_id}', 'ReservationController@getCategoriesByTypeID');
        Route::get('/reservations/captains/{date}', 'ReservationController@getAvailableCaptainsInDay_admin');
        Route::get('/reservations/captains/{captain_id}/{date}/{duration}', 'ReservationController@getCaptainAvTimes');
        Route::get('/reservations/captins_time','ReservationController@getCaptainTimes');
        Route::get('/reservations/captains/reserved/{captain_id}/{date}/{reservation_id}', 'ReservationController@getReservedCaptainAvTimes');
        Route::get('/reservations/settings','ReservationController@settings');
        Route::post('/reservation/settings','ReservationController@updatesettings');
        //<!-- End of Mostafa Change Last Modified  02/06/2019 14:49:7  -->

        //<!-- Ghada Change for reports  02/26/2019 14:49:7  -->
        Route::any('/reports', 'ReportController@index');
        Route::any('searchreport', 'ReportController@search_report');
        Route::any('detailsreport', 'ReportController@searchWithDetails');
        Route::any('/reportsUsers', 'ReportController@index_user');
        Route::any('searchreportuser', 'ReportController@search_user');
        Route::any('userdetails', 'ReportController@searchWithUserDetails');
        Route::any('/reportscash', 'CashController@index');
        Route::any('ReportsCashSearch', 'CashController@search_cash');
        Route::any('ReportsCashSearchBank', 'CashController@search_cash_bank');
        
        Route::any('PayMethod', 'pay_methodController@index');
        Route::post('PayMethod_search', 'pay_methodController@search');
        Route::any('/reportscashbank', 'CashController@index_bank');
        Route::any('reportscashdetails', 'CashController@search_cash_WithDetails');
        Route::any('reportsbankdetails', 'CashController@search_bank_WithDetails');

        //<!-- Ghada Change for payroll  19-mar-2019 14:49:7  -->
        Route::post('/pay_types/savepay_type', 'Pay_typesController@store');
        Route::get('/pay_types', 'Pay_typesController@index');
        Route::get('/pay_types/{pay_type}/edit', 'Pay_typesController@edit');
        Route::post('/pay_types/{pay_type}/update', 'Pay_typesController@update');
        Route::get('/pay_types/savepay_type', 'Pay_typesController@openstore');

//<!-- Ghada Change for payroll  28-mar-2019  -->
        Route::get('/employee_pay_types', 'Pay_typesController@emp_pay_type');
        Route::any('search_epmp_types', 'Pay_typesController@emp_pay_type_search');
        Route::post('update_emp_types/{id}', 'Pay_typesController@update_emp');
        Route::post('save_emp_type', 'Pay_typesController@store_emp');
        Route::get('add_emp_type', 'Pay_typesController@open_add_emptype');

        //<!-- Ghada Change for loans  8-Apr-2019  -->
        Route::get('upate_emp_loan/{loan_dt}/{id}', 'Loan_EmpController@open_edit');
        Route::post('update_many', 'Loan_EmpController@multiUpdate');

        Route::post('update_emp_types_add/{id}', 'Pay_typesController@update_emp_add');
        Route::post('save_emp_type', 'Pay_typesController@store_emp');
        Route::get('add_emp_type', 'Pay_typesController@open_add_emptype');
        
        //ghada change 17/9/2019
        Route::get('destinations', 'destinationsController@index');
        Route::post('add_destinations', 'destinationsController@store');
        Route::get('delete_destinations/{id}', 'destinationsController@delete');
        Route::get('edit_destinations/{id}', 'destinationsController@edit');
        Route::post('update_destinations/{id}', 'destinationsController@update');
        Route::get('search', 'destinationsController@search');
        
        //ghada change 19/09/2019
        Route::get('add_locations', 'locationsController@create');
        Route::get('locations', 'locationsController@index');
        Route::post('save_locations', 'locationsController@store');
        Route::post('update_locations', 'locationsController@update');
        Route::get('destination/get-location/{id}', 'locationsController@get_destination');
        Route::get('delete_location/{id}', 'locationsController@delete');
         // ghada change 23/09/2019
        Route::get('Facilities', 'FacilitiesController@index');
        Route::post('store_category', 'FacilitiesController@store');
        Route::get('edit_category/{id}', 'FacilitiesController@edit');
        Route::post('update_category/{id}', 'FacilitiesController@update');
        Route::get('categorey_search', 'FacilitiesController@search');
        Route::get('delete_facility/{id}', 'FacilitiesController@delete');
        
        // ghada change 26/09/2019
        Route::get('rooms_type', 'Room_typeController@index');
        Route::get('get_room_types/{id}', 'Room_typeController@edit');
        Route::post('store_category_type', 'Room_typeController@store');
        Route::get('category_type_search', 'Room_typeController@search');
        Route::get('delete_cat_type/{id}', 'Room_typeController@delete');
        
  //<!-- Hotel Reservation Routes -->
        Route::get('hotel_reservation','HotelReservationController@index');
        Route::get('/hotel/reservation/search','HotelReservationController@search');
        Route::post('reserve_hotel','HotelReservationController@reserve_hotel');
        Route::get('customer_details/{id}','HotelReservationController@customer_detail');
        Route::get('/get_additional_categories','HotelReservationController@get_additional_categories');
        Route::post('/getcategoryprice','HotelReservationController@getcategoryprice');
        Route::post('hotel_reservation/store','HotelReservationController@store');
        Route::get('hotel_available/{id}','HotelReservationController@search_room');
        Route::Resource('hotel_bookings','BookingsController');
        Route::post('/booking/search','BookingsController@search');
        Route::post('/check_new_date','BookingsController@check_new_date');
        Route::post('/change_booking_date','BookingsController@change_booking_date');
        Route::post('/get_available_rooms','BookingsController@available_rooms');
        Route::post('/add_room','BookingsController@add_rooms');
        Route::post('/get_booked_rooms','BookingsController@get_booked_rooms');
        Route::post('/cancel_room','BookingsController@cancel_room');
        Route::get('/booking/{id}/edit','BookingsController@edit');
        Route::post('booking/update','BookingsController@update');
        Route::post('get_invoice_for_booking','BookingsController@get_invoice_no');
        Route::post('pay_confirm_booking','BookingsController@pay_confirm_booking');
        Route::get('check_in_customer_data','BookingsController@check_in_customer_data');
        Route::post('save_customer_id_data','BookingsController@save_customer_id_data');
        Route::post('check_in_booking','BookingsController@check_in_booking');
        Route::post('confirm_cancel','BookingsController@confirm_cancel');
        Route::post('cancel_booking_data','BookingsController@cancel_booking_data');
        Route::get('check_in_data','BookingsController@check_in_data');
        Route::post('checkout_check_invoice','BookingsController@checkout_check_invoice');
        Route::post('checkout_pay_invoice','BookingsController@checkout_pay_invoice');
        Route::post('checkout_booking','BookingsController@checkout_booking');
        //ghada ghange 20/10/2019
        Route::get('booking/{id}/show','BookingsController@show_resrvation');
        Route::get('booking/{id}/invoice','BookingsController@print_invoice');
        
        //ghada change 21/10/2019
         Route::get('/property_book_cancel','BookCancelReasonController@index');
         Route::get('/get_book_cancel_reasons','BookCancelReasonController@get_property_cancel_reason');
         Route::post('/store_book_cancel_reason', 'BookCancelReasonController@store');
         Route::get('/delete_cancel_reasons/{id}','BookCancelReasonController@delete');
         Route::get('Facilities', 'FacilitiesController@index');
        Route::post('store_category', 'FacilitiesController@store');
        Route::get('edit_category/{id}', 'FacilitiesController@edit');
        Route::post('update_category/{id}', 'FacilitiesController@update');
        Route::get('categorey_search', 'FacilitiesController@search');
        Route::get('delete_facility/{id}', 'FacilitiesController@delete');
        
        //ghada 23/10/2019
        Route::post('/policy/save_room','HotelRoomsController@add_policy');
        Route::post('/policy_main/save_room','HotelRoomsController@add_main_policy');
        Route::get('/delete_propery_polic_room/{id}/{type}/{tab}','HotelRoomsController@delete_policy_details');
        Route::post('/update_policy_details_room', 'HotelRoomsController@update_policy_type');
        Route::get('get_itemdetails2/{id}/{room_id}', 'HotelRoomsController@policy_type');
        
        //ghada change 28/10/2019
        Route::get('/cleaning_priority','CleaningPriorityController@index');
        Route::post('/Cleaning_Priority_add','CleaningPriorityController@get_property_cleaning_priority');

        
        //<!--End Hotel Reservation Routes -->

//<!--  Hosam Calc Sal Routs  -->

        Route::get('/calculate_salary', 'CalculateSalaryController@calculate_salary');
        Route::get('/calculate_salary', 'CalculateSalaryController@calculate_salary');
        Route::any('/salary_report', 'CalculateSalaryController@salary_report');
        
        //<!--  Hosam reciet Routs  -->
         Route::resource('reciet', 'RecietController');
         Route::post('/getServiceDetails', 'RecietController@getServiceDetails')->name('getServiceDetails');
         Route::post('/getServiceReturn', 'RecietController@getServiceReturn')->name('getServiceReturn');
         Route::post('/payServiceamount', 'RecietController@payServiceamount')->name('payServiceamount');
         Route::post('/addNewServiceRequest', 'RecietController@addNewServiceRequest')->name('addNewServiceRequest');
         Route::get('getpaymentdata','RecietController@getPaymentdata');
         Route::get('getdeliverydata','RecietController@getDeliverydata');
         Route::post('deliverservice','RecietController@deliverService');
         Route::get('servicereport','RecietController@serviceReport');
         Route::get('search_service','RecietController@searchService')->name('search_service');
         Route::get('show_reciet/{id}','RecietController@showReciet');
         Route::get('print_reciet/{id}','RecietController@printReciet');
         Route::get('invoice_reciet/{id}','RecietController@invoiceReciet');
         Route::get('getreportpaymentdata','RecietController@getReportPaymentdata');
         Route::post('payreportServiceamount','RecietController@payReportserviceamount');
         Route::get('getreportdeliverydata','RecietController@getReportdeliverydata');
         Route::post('deliverreportservice','RecietController@deliverReportservice');
         Route::get('getservices','RecietController@getServices');
         Route::get('getitems','RecietController@getItems');
           Route::resource('shift', 'ShiftsController');
           Route::get('/shifts/default/{id}/true','ShiftsController@DefaultShift');
           Route::get('get_staff_work_days/{captin_id}','ShiftsController@captin_days');
         
         //<!--  Hosam return item report Routs  -->
         Route::any('retunitemsreports', 'ReturnItemReportController@index');
         Route::any('returnitemsearchreport', 'ReturnItemReportController@search_report');
         Route::any('returnitemsdetailsreport', 'ReturnItemReportController@searchWithDetails');
         Route::get('testnotification',function(){
             $notifiyHidden = DB::table("notifications")->where('org_id',Auth::user()->org_id)
            ->select(
            "id",
            "content"
            ,"content_en"
            ,"content_type"
            ,"created_at"
            );
            $reservationHidden = DB::table("reservations")->where('org_id',Auth::user()->org_id)
            ->select(
            "id"
            ,"cust_id"
            ,"org_id"
            ,"confirm"
            ,"reservation_date"
            );
            $front_messages=DB::table("front_messages")->where('org_id',Auth::user()->org_id)
            ->select(
            "id"
            ,"name"
            ,"message"
            ,"open"
          ,"created_at"
            );

            $msgsHidden = DB::table("users_messages")->where('org_id',Auth::user()->org_id)->where('to_id',Auth::user()->id)
            ->select(
            "id"
            ,"from_id"
            ,"message"
            ,"to_id"
            ,"created_at"
            );
          
            $loginHistoryHidden = DB::table("login_history")->where('org_id',Auth::user()->org_id)
            ->select(
            "id"
            ,"user_id"
            ,"org_id"
            ,"status"
            ,"created_at"
            )
            ->unionAll($notifiyHidden)->unionAll($reservationHidden)->unionAll($msgsHidden)->unionAll($front_messages)

            ->orderBy('created_at','desc')->get();
            dd($loginHistoryHidden);
         });


//<!-- End Hosam return item report Routs  -->


        Route::get('kpi/list', 'KPIController@list')->name('kpi.list');
        Route::get('kpi/assign', 'KPIController@assign_view');
        Route::get('kpi/average/list', 'KPIController@average_list')->name('kpi.average');
        Route::post('kpi/crate-assign', 'KPIController@assign')->name('kpi.assign');
        Route::post('kpi/rating-update/{id}', 'KPIController@rating_update');
        Route::get('kpi/{page}', 'KPIController@reports_view')->where('page', 'average-reports|reports');
        Route::get('kpi/rules', 'KPIController@rules')->name('kpi.rules');
        Route::post('kpi/crate-rules', 'KPIController@create_rules');
        Route::any('kpi/rules/update/{id}', 'KPIController@rules_update');
        Route::get('salary_report/{id}/{date}/print', 'CalculateSalaryController@print');

        Route::resource('kpi', 'KPIController');
//<!-- Ghada Change for Loans  7-apr-2019  -->

        Route::get('/loan_emp', 'Loan_EmpController@index');
        Route::any('search_loan_emp', 'Loan_EmpController@search');
        Route::get('create_emp_loan', 'Loan_EmpController@openstore');
        Route::post('save_emp_loan', 'Loan_EmpController@create');
        Route::get('upate_emp_loan', 'Loan_EmpController@open_edit');
        Route::post('search_upate', 'Loan_EmpController@search_emp_update');
        Route::post('update_emp_loan', 'Loan_EmpController@multiUpdate');

        Route::get('files.download/{id}', 'Loan_EmpController@downloadImage');


        Route::get('inventory/report', 'InventoryController@report');
        Route::resource('inventory', 'InventoryController');
        Route::post('inventory/submit', 'InventoryController@submit');
        
        
        
        Route::resource('followup', 'FollowupController');
        Route::get('followup/get-customer/{id}', 'FollowupController@customer');
        Route::get('followup/delete_image/{id}', 'FollowupController@DeleteImage');
        Route::get('followup/delete_session/{id}', 'FollowupController@DeleteSession');
        Route::get('followup/{id}/confirm', 'FollowupController@edit')->name('followup.confirm');
        Route::get('followup/{type}/report', 'FollowupController@Reports');


        Route::any('rates/{id}/destroy', 'RatesController@destroy');
        Route::get('rates/search', 'RatesController@search');
        Route::get('rates/smart-pricing', 'RatesController@SmartPrice');
        
        Route::resource('rates', 'RatesController');
        Route::get('rates/check-tax/{id}/{price}', 'RatesController@check');
        Route::get('rates/get-rooms/{id}', 'RatesController@GetRoom');
        Route::get('rates/smart-pricing-get-rooms/{id}', 'RatesController@SmartPriceGetRoom');
        Route::get('rates/get-fees/{id}', 'RatesController@GetFees');
        Route::get('rates/smart/{id}', 'RatesController@SmartPricing');
        Route::any('rates/smart/post', 'RatesController@SmartPricingPost');
        Route::get('rates/get-details/{id}', 'RatesController@GetDetails');
       // By Esraa Today
        Route::get('property/{id}/statistics', 'HomeController@PropertyStatistics');
        // 
        
        Route::get('property/{id}/rooms', 'HomeController@PropertyRooms');
		Route::get('availability', 'AvailabilityHotelsController@index');


    ///                   Mohamed 22/9/2019 -- Property ---                 //

    // Property
    // index
    Route::get('/property','PropertyControllers@index');
    Route::post('/property/search','PropertyControllers@search');
    Route::get('/property/search','PropertyControllers@index');
    Route::get('/property/iamge/del/{id?}','PropertyControllers@PhotoDel');
    // updated
    Route::get('/property/updated/{id?}','PropertyControllers@updatedView');
    Route::post('/property/updated','PropertyControllers@updatedProcess');
    // add
    Route::get('/property/add','PropertyControllers@addviwe');
    Route::post('/property/add','PropertyControllers@addProcess');
    //Property Slider
    Route::get('/property/slider/{id?}','PropertySilderControllers@index');
    //add
    Route::get('/property/slider/add/{id?}','PropertySilderControllers@addView');
    Route::post('/property/slider/add','PropertySilderControllers@addProcess');
    //del
    Route::get('/property/slider/remove/{id?}','PropertySilderControllers@del');
    //updated
    Route::get('/property/slider/updated/{id?}','PropertySilderControllers@updatedView');
    Route::post('/property/slider/updated','PropertySilderControllers@updatedProcess');


//ghada 6/10/2019
    Route::post('/policy/save','PropertyControllers@add_policy');
    Route::post('/policy_main/save','PropertyControllers@add_main_policy');
    Route::get('/delete_propery_polic/{id}/{type}/{tab}','PropertyControllers@delete_policy_details');
    Route::post('/update_policy_details', 'PropertyControllers@update_policy_type');
    Route::get('get_itemdetails/{id}/{hotel_id}', 'PropertyControllers@policy_type');
    
      //ghada change 9/10/2019
     Route::get('/property_payment','property_pay_methodControllers@index');
     Route::get('/edit_hotel_pay_method/{id}','property_pay_methodControllers@edit');
     Route::get('/delete_hotel_pay_method/{id}','property_pay_methodControllers@delete');
     Route::get('/serach_hotel_pay_method','property_pay_methodControllers@search');
     Route::post('/hotel/payment', 'property_pay_methodControllers@update');
// end Property 

// sart Rooms 
    Route::get('/rooms','HotelRoomsController@index');
    Route::get('/hotel/search','HotelRoomsController@search');
    Route::post('/rooms/add','HotelRoomsController@add');
      Route::get('rooms/add','HotelRoomsController@index');
    Route::get('/rooms/get/rooms/{id?}','HotelRoomsController@getCateigors');
    
    Route::get('/rooms/iamge/del/{id?}','HotelRoomsController@delPhoto');
    
    Route::get('rooms/updated/{id?}','HotelRoomsController@updatedView');
    Route::post('rooms/updated','HotelRoomsController@updatedProcess');
    Route::get('rooms/create/prices/{id?}','HotelRoomsController@createPrices');
    Route::post('rooms/create/prices','HotelRoomsController@createdPricesProcess');
    Route::get('rooms/cloth/day/del/{id?}','HotelRoomsController@deletedClothDay');
    Route::get('rooms/my-prices/{id?}','HotelRoomsController@getPrices');
    // room slider

    Route::get('rooms/photos/{id?}','HotelRoomsSilderControler@index');
    Route::post('rooms/photos/add-new','HotelRoomsSilderControler@add');
    Route::get('rooms/photos/add-new','HotelRoomsSilderControler@index');
    Route::get('rooms/photos/deleted/{id?}','HotelRoomsSilderControler@delSlider');
    Route::get('rooms/photos/updated','HotelRoomsSilderControler@index');
    Route::post('rooms/photos/updated','HotelRoomsSilderControler@updated');
      // room del prices
    Route::get('rooms/my-prices/del/{id?}','HotelRoomsController@delPries');
    // del room
    Route::get('rooms/deleted/{id?}','HotelRoomsController@delroom');
    
     // Category_num
    Route::get('rooms/number','RoomNumberController@index');
    Route::get('rooms/number/get-cate-num/{id?}','RoomNumberController@getCategoryNum');
    Route::get('rooms/number/search','RoomNumberController@search');
    Route::post('rooms/number/add','RoomNumberController@addNewCatNum');
    Route::get('rooms/number/add','RoomNumberController@index');
    Route::get('rooms/number/updated/{id?}','RoomNumberController@updatedView');
    Route::post('rooms/number/updated','RoomNumberController@updatedProcess');
    Route::get('rooms/number/cloth/del/{id?}','RoomNumberController@delCloth');
    Route::get('rooms/number/del/{id?}','RoomNumberController@delCatNum');
    //filter 
    Route::get('rooms/number/filter','RoomNumperSearchControllers@viewSearch');
    Route::post('rooms/number/filter','RoomNumperSearchControllers@searchProcess');




    Route::get('property/registration/setup/{id?}', function ($id=0) {
        $property = \App\Property::find($id);
        // check Property
        if(!empty($property) && $property->org_id == Auth()->user()->org_id)
        {
          $nots=  \Illuminate\Support\Facades\DB::table('property_policy')
                ->join('policy_type','policy_type.id','property_policy.policy_type_id')
                ->select('property_policy.*')
                ->where([
                    ['property_policy.org_id',Auth()->user()->org_id],
                    ['property_policy.property_id',$id],
                    ['policy_type.checkin_card','=','y']
                ])->first();
            
            return view('property.registrationSetup')
                ->with('property',$property)
                ->with('nots',$nots);
        }
    
        return redirect()->back();
    
    });
    
    
    // destinations
    Route::get('/del/destinations/photo/{id?}','DeletedPhotosControllers@delDestPhoto');
    // user & employees
    Route::get('/employees/del/photo/{id?}','DeletedPhotosControllers@delUserPhoto');
    // customer
    Route::get('/customer/del/photo/{id?}','DeletedPhotosControllers@delCustomerPhoto');
    // org -> ( image_id , Front , map )
    Route::get('/org/del/image_id/{id?}','DeletedPhotosControllers@delOrgImageID');
    Route::get('/org/front/del/{id?}','DeletedPhotosControllers@delOrgFrontImage');
    Route::get('/org/del/map/{id?}','DeletedPhotosControllers@delOrgMap');

    



    
    

 
});

// ** USER ROLE CUSTOMER ROUTES ** //
/*Route::get('/dashboard', 'CustomerHomeController@index');*/

// a.nabiil Routes

// a.nabiil Routes

Route::get('admin/user_menu', 'menuEditController@showeditmenuPage')->name('EditMenu');
Route::get('admin/testMenu', 'menuEditController@testMenu')->name('testMenu');
Route::get('admin/menuManger', 'menuEditController@menuManger')->name('menuManger');
Route::post('admin/menuMangerEdit', 'menuEditController@menuMangerEdit')->name('menuMangerEdit');
Route::get('admin/all_menus_list', 'menuEditController@menu_list')->name('menu_list');
Route::post('admin/default_menu', 'menuEditController@default_menu')->name('default_menu');
Route::get('/admin/trans_limit', 'transactionReportController@searchIndex')->name('trans_limit');
Route::get('/admin/trans_limit_search', 'transactionReportController@search')->name('trans_limit_search');
Route::get('admin/testCron', function () {
    Artisan::call('schedule:run');
});
Route::get('admin/testSum', function () {
    $activityUser = App\NotificationsUser::where('user_id', Auth::user()->id)->where('notification_id', $value->id)->where('type', 'reservation')->first();
    $trans = DB::table('transactions')->where('org_id', Auth::user()->org_id)->groupBy('cat_id')->get();
    foreach ($trans as $key) {
        $cat = DB::table('categories')->find($key->cat_id);
        $transsss = DB::table('transactions')->where('org_id', $key->org_id)->where('cat_id', $cat->id)->sum('quantity', "*", 'req_flag');
        if ($transsss <= $cat->d_limit || $cat->d_limit == null) {
            $oldNotify = notifyModel::where('cat_id', $cat->id)->first();
            if (!$oldNotify) {
                $Notify = new notifyModel();
                $Notify->org_id = $key->org_id;
                $Notify->cat_id = $cat->id;
                $Notify->content = "تست  $cat->name";
                $Notify->content_en = "the test $cat->name_en test ";
                $Notify->content_type = "transaction";
                $Notify->save();
            }
        }
    }
});
Route::get('admin/testnoti', function () {

    $notifiy = DB::table("notifications")->where('org_id', Auth::user()->org_id)
        ->select(
            "id",
            "content"
            , "content_en"
            , "content_type"
            , "created_at"
        );

    // $offers = DB::table("offers")->where('org_id',Auth::user()->org_id)->whereDate("date_to" , date("Y-m-d"))
    //     ->select(
    //       "id",
    //       "cat_id"
    //       ,"date_from"
    //       ,"discount_price"
    //       ,"date_to");

    $reservation = DB::table("reservations")->where('org_id', Auth::user()->org_id)
        ->select(
            "id"
            , "user_id"
            , "org_id"
            , "confirm"
            , "reservation_date"
        );
    $msgs = DB::table("users_messages")->where('org_id', Auth::user()->org_id)->where('to_id', Auth::user()->id)
        ->select(
            "id"
            , "from_id"
            , "message"
            , "to_id"
            , "created_at"
        );
        $front_messages=DB::table("front_messages")->where('org_id',Auth::user()->org_id)
            ->select(
            "id"
            ,"name"
            ,"message"
            ,"open"
          ,"created_at"
            );
    $loginHistory = DB::table("login_history")->where('org_id', Auth::user()->org_id)
        ->select(
            "id"
            , "user_id"
            , "org_id"
            , "status"
            , "created_at"
        )
        ->unionAll($notifiy)->unionAll($reservation)->unionAll($msgs)->unionAll($front_messages)
        ->orderBy('created_at', 'desc')->get();
    dd($loginHistory);
});

// Route::get('admin/testSum', function(){
//   $transactions = DB::table('transactions')->groupBy('org_id')->get();
//   foreach ($transactions as   $value) {
//     $trans =  DB::table('transactions')->where('org_id',$value->org_id)->groupBy('cat_id')->get();
//     // echo $transsss ."<br>";
//     foreach ($trans as $key ) {
//       $cat = DB::table('categories')->find($key->cat_id);
//       $transsss =  DB::table('transactions')->where('org_id',$key->org_id)->where('cat_id' ,$cat->id)->sum('quantity',"*",'req_flag');
//       if ($transsss <= $cat->d_limit || $cat->d_limit == null ) {
//       // echo "$transsss <br>";
//       $Notify = new notifyModel();
//       $Notify->org_id = $key->org_id;
//       $Notify->content = "تست  $cat->name";
//       $Notify->content_en = "the test $cat->name_en test ";
//       $Notify->content_type = "transaction";
//       $Notify->save();
//       }
//
//     }
//   }
//
// });

// external req routes
Route::get('/admin/cancel_external_req', 'external_reqController@cancel')->name('cancel_external_req');
Route::get('/admin/confirm_external_req', 'external_reqController@confirm')->name('confirm_external_req');
Route::get('/admin/done_external_req', 'external_reqController@done')->name('done_external_req');
Route::get('/admin/waiting_external_req', 'external_reqController@waiting')->name('waiting_external_req');
Route::post('/admin/cancel_req', 'external_reqController@cancel_req')->name('cancel_req');
Route::post('/admin/confirm_req', 'external_reqController@confirm_req')->name('confirm_req');
Route::post('/admin/doneReq', 'external_reqController@doneReq')->name('doneReq');
Route::post('/admin/addNewRequests', 'external_reqController@addNewRequests')->name('addNewRequests');
Route::post('/admin/deleteTrans', 'external_reqController@deleteTrans')->name('deleteTrans');
Route::post('/admin/getCatDetails', 'external_reqController@getCatDetails')->name('getCatDetails');
Route::get('/admin/search_cust_req', 'external_reqController@search_cust_req')->name('search_cust_req');
Route::get('/admin/showReq/{Req_id}', 'external_reqController@showReq')->name('showReq');
Route::post('/admin/editQuantity', 'external_reqController@editQuantity')->name('editQuantity');
Route::get('/admin/external_reports', 'external_reqController@external_reports')->name('external_reports');
Route::get('/admin/external_reports_search', 'external_reqController@external_reports_search')->name('external_reports_search');
Route::post('/admin/adminConfirm', 'external_reqController@adminConfirm')->name('adminConfirm');
Route::post('/admin/getProductReturn', 'external_reqController@getProductReturn')->name('getProductReturn');

Route::get('/admin/externalTransPrint/{id}', 'external_reqController@externalTransPrint')->name('externalTransPrint');
// external req routes

Route::post('admin/addNewMenu', 'menuEditController@addNewMenu')->name('addNewMenu');
Route::post('admin/editMenu', 'menuEditController@editMenu')->name('editMenu');
Route::post('admin/editAllMenus', 'menuEditController@editAllMenus')->name('editAllMenus');
Route::post('admin/deleteMenu', 'menuEditController@deleteMenu')->name('deleteMenu');


// display login report page
Route::get('/admin/login_history', 'loginHistoryController@index')->name('loginHistory');
Route::get('/admin/login_history_search', 'loginHistoryController@search')->name('loginHistorySearch');

Route::post('/admin/editNotify', 'loginHistoryController@editNotify')->name('editNotify');
// a.nabiil Routes

// a.nabiil Routes

Route::group(['middleware' => 'customer'], function () {


    Route::get('/reservation', 'ReservationController@create');
    Route::get('/reservations/customer_captains/{captain_id}/{date}/{duration}', 'ReservationController@getCaptainAvTimesCustomer');
    Route::post('/reservation', 'ReservationController@store');
    Route::get('/reservation/getCategories/{category_type_id}', 'ReservationController@getCategoriesByTypeID');
    Route::get('/reservation/captains/{captain_id}/{date}', 'ReservationController@getCaptainAvTimes');
    Route::get('/reservation/captains/{date}', 'ReservationController@getAvailableCaptainsInDay_customer');
    Route::get('/reservation/categories/{category_id}/type', 'ReservationController@getCategoryType');
    Route::get('/reservation/service/{service_type}/categories', 'ReservationController@getCategoriesOfServiceType');
    Route::get('/reservations/get-details/{id}','ReservationController@get_details');
    


    Route::get('transactions/{id}/print', 'HomeController@Print');
    Route::post('password/update/{id}', 'UserPasswordController@update');


    Route::get('/customer/profile', 'CustomerProfileController@index')->name('customerProfile');
    Route::patch('/customer/{id}', 'CustomerProfileController@update')->name('customerUpdate');
    Route::get('passwordCheck', 'UserPasswordController@check_password');
    //payment
    Route::get('payment/{total}/{id}', 'PaymentController@index');
    Route::get('/paypal/checkout/{order}/cancelled', [
        'name' => 'PayPal Express Checkout',
        'as' => 'paypal.checkout.cancelled',
        'uses' => 'PayPalController@cancelled',
    ]);

    Route::post('/webhook/paypal/{order?}/{env?}', [
        'name' => 'PayPal Express IPN',
        'as' => 'webhook.paypal.ipn',
        'uses' => 'PayPalController@webhook',
    ]);

    Route::post('execute_payment', 'PaymentController@executePayment');
    Route::get('payment_completed/{external_req_id}/{price}/{name}/{email}/{org}/{support_email}', 'PayPalController@completed');
    Route::get('payment/cancelled', 'PaymentController@paymentcancelled');
    Route::get('payment/failed/{error}', 'PaymentController@paymentfailed');

});

//ghada change 02/07/2019


Route::get('/', 'frontController@index');
Route::any('subscribers_message', 'frontController@subscribers');
Route::get('aboutus', 'frontController@about_us');
Route::get('contact', 'frontController@contact');
Route::get('categorys', 'frontController@get_categorys');
Route::get('offers', 'frontController@get_offers');
Route::any('frontmessage', 'frontController@front_message');
Route::get('customerdashboard', 'CustomerHomeController@index');
Route::get('CustomerReservations', 'frontController@reservations');
Route::get('customerprofile/{id}', 'CustomerHomeController@customerProfile');
Route::get('/dashboard/reservations', 'CustomerHomeController@reservations');
Route::any('frontmessage', 'frontController@front_message');
Route::any('CreateCustomer', 'Auth\LoginController@create_customer');
Route::post('updatacustomerprofile', 'CustomerHomeController@customerProfileUpdata')->name('updatacustomerprofile');
Route::get('/reservation', 'ReservationController@create');
Route::post('/reservation', 'ReservationController@store');
Route::get('/reservation/getCategories/{category_type_id}', 'ReservationController@getCategoriesByTypeID');
Route::get('/reservation/captains/{captain_id}/{date}', 'ReservationController@getCaptainAvTimes');
Route::get('/reservation/captains/{date}', 'ReservationController@getAvailableCaptainsInDay_customer');
Route::get('/reservation/categories/{category_id}/type', 'ReservationController@getCategoryType');
Route::get('/reservation/service/{service_type}/categories', 'ReservationController@getCategoriesOfServiceType');
Route::get('checkout', 'frontController@view_invoice')->name('userCheckout');
Route::post('cartstore/json', 'frontController@storeCart');
Route::post('details/cartstore/json', 'frontController@storeCart');
Route::get('cart', 'frontController@cart_check_out');
Route::any('checkCustomer', 'Auth\LoginController@test');
Route::any('logoutCustomer', 'Auth\LoginController@logout');
Route::get('search', 'frontController@search');
Route::get('details/{id}', 'frontController@product_details');
Route::get('cart_list', 'frontController@cart_list');
Route::post('/autocomplete/fetch', 'frontController@fetch')->name('autocomplete.fetch');


// ** PASSWORD CHANGE ROUTES ** //

Route::get('/password/update', 'UserPasswordController@index')->name('changePassword');
//Route::patch('/password/update/{id}', 'UserPasswordController@update')->name('postChangePassword');

// ** Chart ROUTES ** //
Route::get('charts', 'CustomerHomeController@Charts');

