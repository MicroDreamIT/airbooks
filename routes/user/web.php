<?php



Route::group(['middleware' => ['auth','roleUser','emailVerified_active']], function () {

    Route::post('/payment-history', 'PaymentHistoryController@store');
    Route::get('/{all}', function () {
//    auth()->loginUsingId(1, true);

//        if(request()->url()===url('user/bypass')){
//            auth()->loginUsingId(5, true);
//        }
        return view('user.user-dashboard');
    })->where(['all' => '.*']);
});


//"transaction_id" => "274081"
//  "order_id" => "101"
//  "response_code" => "100"
//  "response_message" => "Approved"
//  "customer_name" => "asdf asdf"
//  "customer_email" => "asdf@gmail.com"
//  "transaction_amount" => "25.000"
//  "transaction_currency" => "USD"
//  "customer_phone" => "973 46546465456"
//  "last_4_digits" => "1111"
//  "first_4_digits" => "4111"
//  "card_brand" => "Visa"
//  "trans_date" => "08-01-2019 12:50:36 PM"
//  "pt_customer_email" => null
//  "pt_customer_password" => null
//  "pt_token" => null
//  "secure_sign" => "cd49598fb92157f269b558ee61681e7c82c610fd"