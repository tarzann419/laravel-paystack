<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function PayIndex(){
        return view('pay.index');
    }

    public function MakePayment(Request $request){
        
        $form_data = [
            'email' => $request->email,
            'amount' => $request->amount,
        ];

    }

    // submitting to paystack for generating a payment link for user
    // we get the 'init' url from the paystack docs api

    public function InitPayment($form_data){
        $url = 'https://api.paystack.co/transaction/initialize';


        // trying to convert the array into something that can readable by the browser. 
        // so we convert it using http_build
        
        $fields_string = http_build_query($form_data);
    }
}
