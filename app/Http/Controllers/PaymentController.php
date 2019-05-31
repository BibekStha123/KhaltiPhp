<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PaymentController extends Controller
{
    
    public function verification(Request $request)
    {
        //hit the khalit server
        $args = http_build_query(array(
            'token' => $request->input('trans_token'),
            'amount'  => $request->input('amount')
        ));
        
        $url = "https://khalti.com/api/v2/payment/verify/";
        
        # Make the call using API.
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,$args);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        
        $headers = ['Authorization: Key test_secret_key_2ff879c83221405bad79b372e79b049f'];
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        
        // Response
        $response = curl_exec($ch);
        // dd($response); //see the response from khalti server
        $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        $res = json_decode($response, true);//decode the response
        if(isset($res['idx']))  //check whether there is idx and also the amount in response with your database(I havenot done that)
        {
            //perform your database operation here,,,
            return response()->json([  //returns success to ajax
                'success' => 'Your Account is succesfully credited.',
            ], 200);

        }else{

            return response()->json([ //returns failure to ajax
                'error' => 'Something went Wrong.',
            ], 404);
        }
        
    }
}
