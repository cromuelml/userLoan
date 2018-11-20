<?php


use Illuminate\Http\Request;


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//please refer to .env file for the database name & change the database credentials
//execute the following in cmd
	//1. composer update
	//2. php artisan migrate
	//3. php artisan serve

//you can use Postman to execute the API

//User
	Route::post('/un', 'UserController@store')->name('user.new');
	// api sample call : http://127.0.0.1:8000/api/un?inputFName=crom&inputLName=uel&inputEmail=crom@me.com
	// api sample call 2 : http://127.0.0.1:8000/api/un?inputFName=crom2&inputLName=uel2&inputEmail=crom2@me.com

	Route::patch('/uu', 'UserController@update')->name('user.update');
	// api sample call : http://127.0.0.1:8000/api/uu?inputFName=cromx&inputLName=uelx&inputEmail=crom@me.com

	Route::delete('/ud', 'UserController@destroy')->name('user.delete');
	// api sample call : http://127.0.0.1:8000/api/ud?inputEmail=crom2@me.com

//Loans
	Route::post('/ln', 'LoanController@store')->name('loan.new');
	// api sample call : http://127.0.0.1:8000/api/ln?inputEmail=crom@me.com&duration=34&repayment_frequency=2017-11-19&interest_rate=10&arrangement_fee=1800&loan_amount=20000
	// api sample call 2 : http://127.0.0.1:8000/api/ln?inputEmail=crom@me.com&duration=34&repayment_frequency=2017-11-19&interest_rate=10&arrangement_fee=1800&loan_amount=5000

	Route::patch('/lu', 'LoanController@update')->name('loan.update');
	// api sample call : http://127.0.0.1:8000/api/lu?id=1&duration=34&repayment_frequency=2017-11-19&interest_rate=10&arrangement_fee=2200&loan_amount=30000

	Route::delete('/ld', 'LoanController@destroy')->name('loan.delete');
	// api sample call : http://127.0.0.1:8000/api/ld?id=2

//Payments
	Route::post('/pn', 'RepaymentController@store')->name('payment.new');
	// api sample call : http://127.0.0.1:8000/api/pn?id=1&repayment_date=2017-11-17&arrangement_fee=5000
	// api sample call2 : http://127.0.0.1:8000/api/pn?id=1&repayment_date=2017-11-17&arrangement_fee=500

	Route::patch('/pu', 'RepaymentController@update')->name('payment.update');
	// api sample call : http://127.0.0.1:8000/api/pu?id=2&repayment_date=2017-11-19&arrangement_fee=10000

	Route::delete('/pd', 'RepaymentController@destroy')->name('payment.delete');
	// api sample call : http://127.0.0.1:8000/api/pd?id=2


//Call all user's info with loans status and corresponding repayments
//loan_balance field under loans will be updated according to the payments made
Route::get('/ul', 'UserController@index')->name('user.list');
// api sample call : http://127.0.0.1:8000/api/ul

