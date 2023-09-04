<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class PaymentController extends Controller
{
    public function PayIndex(){
        return view('pay.index');
    }


    public function PaymentCallback(Request $req){
        $response = json_decode($this->VerifyPayment($req->reference));

        if ($response) {
            if ($response->status) {
                // dd($response);
                // return redirect($response->data->authorization_url);
                $data = $response->data;
                return view('pay.callback', compact('data'));
            }
            else{
                return back()->withError($response->message);
            }
            
        } else{
            return back()->withError("Something went wrong"); 
        }
        dd($response);
        
    }



    // after making payment, we will be redirected to the callback page. 
    // which should contain all the details from the form fields
    public function MakePayment(Request $request){
        
        $form_data = [
            'email' => $request->email,
            // amount is alkways in kobo so we have to convert
            'amount' => $request->amount * 100,

            // adding a callback url to redirect us to the merchant url
            'callback_url' => route('pay.callback')
        ];

        // format properly using jsondecode
        $pay = json_decode($this->InitPayment($form_data));

        if ($pay) {
            if ($pay->status) {
                // dd($pay);
                return redirect($pay->data->authorization_url);
            }
            else{
                return back()->withError($pay->message);
            }
            
        } else{
            return back()->withError("Something went wrong"); 
        }
        

    }

    // submitting to paystack for generating a payment link for user
    // we get the 'init' url from the paystack docs api

    public function InitPayment($form_data){
        $url = 'https://api.paystack.co/transaction/initialize';


        // trying to convert the array into something that can readable by the browser. 
        // so we convert it using http_build
        
        $fields_string = http_build_query($form_data);
        // init curl first! and always make sure to close when  done
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Authorization: Bearer " . env("PAYSTACK_SECRET_KEY"),
            // "Authorization: Bearer secret_key",
            "Cache-Control: no-cache "
        ));

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);

        return $result;
    }


    // we need to also verify the payments made
    public function VerifyPayment($reference){
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.paystack.co/transaction/verify/{$reference}",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING =>"",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "Authorization: Bearer " . env("PAYSTACK_SECRET_KEY"),
                "Cache-Control: no-cache "
            )
        ));


        $response = curl_exec($curl);
        curl_close($curl);

        return $response; 
    }
}
