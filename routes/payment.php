<?php

Route::post('create-customer', function(){
    return (new \App\Http\StripePayment())->createCustomer();
});

Route::post('swap',function(){
    return (new \App\Http\StripePayment())->swap();
});

Route::post('create-or-update-customer',function(){
    return (new \App\Http\StripePayment())->createOrUpdateCustomer();
});
