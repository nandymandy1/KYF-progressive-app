<?php
use Illuminate\Notifications\RoutesNotifications;
use SebastianBergmann\CodeCoverage\Report\Xml\Report;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();



Route::get('/home', 'HomeController@index')->name('home');

// Fetch Factory for register
Route::get('/factorylist', 'OutputController@fetchFactory');

Route::prefix('/factory')->group(function(){
  // Cutting Data Routes
  Route::get('/cuttinginput', function(){
    return view('factory.forms.cutting');
  });
  Route::post('/cutting/data', 'InputController@saveCutting');
  // Sewing Data Routes
  Route::get('/sewinginput', function(){
    return view('factory.forms.sewing');
  });
  Route::post('/sewing/data', 'InputController@saveSewing');
  // Finishing Data
  Route::get('finishinginput', function(){
    return view('factory.forms.finishing');
  });
  Route::post('/finish/data', 'InputController@saveFinishing');
  // Quality Routes
  Route::get('qualityinput', function(){
    return view('factory.forms.quality');
  });
  Route::post('/quality/data', 'InputController@saveQuality');
  // General Routes
  Route::get('generalinput', function(){
    return view('factory.forms.general');
  });
  Route::post('/general/data', 'InputController@saveGeneral');
});



// MASTER ROUTES
Route::prefix('/master')->group(function(){
  Route::get('/cutting', 'FactoryController@cutting');
  Route::get('/sewing', 'FactoryController@sewing');
  Route::get('/finishing', 'FactoryController@finishing');
  Route::get('/quality', 'FactoryController@quality');
  Route::get('/general', 'FactoryController@general');
  // For crisp report
  Route::get('/factory/main/dashboard', function() {
    return view('factory.master');
  });

  Route::get('/users/{id}', function($id) {
    return view('factory.users', ['id'=> $id]);
  });

  Route::post('/usersfetch/{id}', 'FactController@getFactoryUsers');

});


// Admin Routes
Route::prefix('/admin')->group(function () {

  // View reports routes for the factories
  Route::get('/factory/master/{id}', 'OutputController@factoryDashboard');
  Route::post('/factory/reports/{req}', 'OutputController@master');

  Route::post('/factory', 'FactController@store');
  Route::resource('/factory', 'FactController');
  Route::post('/factorydel/{id}', 'FactController@del');
  Route::get('/factory/endis/{id}', 'FactController@enable_disable');
  Route::post('/factories', 'FactController@getFactory');
  Route::get('/user/endis/{id}', 'FactController@endisUser');

  Route::get('/users', function(){
    return view('admin.users');
  });

  // To fetch all the factory owners to the super user
  Route::post('/usersfetch', 'FactController@getUsers');
  // To fetch all the admins to the super user
  Route::post('/adminsfetch', 'FactController@getAdmins');

  // Create super Admin
  // Route::get('/create/superuser', 'FactController@createAdmin');

  // To get the View for the admins
  Route::get('/getadmins', function(){
    return view('admin.admins');
  });

});


// To fetch the reports of different departments

Route::prefix('/reports')->group(function () {
  Route::post('/cutting/{id}', 'FactoryController@cut');
  Route::get('/sewing/{id}', 'FactoryController@sew');
  Route::post('/finishing/{id}', 'FactoryController@fin');
  Route::post('/quality/{id}', 'FactoryController@qua');
  Route::get('/general/{id}', 'FactoryController@gen');
  Route::get('/test/{id}', 'FactoryController@test');
});

Route::get('/merchandiser', function(){
  return view('new.simple');
});

Route::post('/add/style', 'MerchantController@addStyles');
Route::get('/get/styles/{id}', 'MerchantController@getStyles');
Route::get('/del/styles/{id}', 'MerchantController@delStyles');

Route::post('/add/order', 'MerchantController@addOrders');
Route::get('/get/orders/{id}', 'MerchantController@getOrders');
Route::get('/del/orders/{id}', 'MerchantController@delOrders');

Route::get('/order/reports/{id}', function($id){ return view('new.order', ['id' => $id]); });


Route::post('/add/order/breakup', 'MerchantController@addBreakup');
Route::get('/get/orders/breakups/{id}', 'MerchantController@getBreakups');
Route::get('/del/orders/breakups/{id}', 'MerchantController@delBreakups');

Route::get('/sewingline', function(){ return view('new.line'); });
Route::post('/addline', 'MerchantController@addLine');
Route::get('get/lines/today/{id}', 'MerchantController@getLinesToday');

// Get order sewing status
Route::get('/order/sewing/status/{id}', 'MerchantController@getOrderSewingStatus');
// Cutting orderwise
Route::get('/cutting/orders', function(){
  return view('new.cut');
});
Route::post('/add/cutting/order', 'MerchantController@saveCutting');
// Get Today's Cutting plans
Route::get('/get/cutting/order/{id}', 'MerchantController@getCutting');
// Go to the Finishing Route
Route::get('/finish/orders', function(){
  return view('new.fin');
});
Route::post('/add/finishing/orders', 'MerchantController@addFinish');
Route::get('/get/finishing/orders/{id}', 'MerchantController@getFinish');

// Go to the Quality
Route::get('/quality/orders', function(){
  return view('new.quality');
});
Route::post('/add/quality/orders', 'MerchantController@addQuality');
Route::get('/get/quality/orders/{id}', 'MerchantController@getQuality');

// Get all data of the order
Route::get('/get/order/details/{id}', 'MerchantController@getOrderDetail');
// Get Complete Order Details
Route::get('/get/order/data/{id}','MerchantController@getOrder');
Route::get('/get/stylename/{id}', 'MerchantController@getStyleName');

Route::get('/test', 'MerchantController@test');
