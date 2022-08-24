<?php

namespace App\Http\Controllers\Payments;

use App\Http\Controllers\Auth\UserController;
use App\Http\Controllers\Controller;
use App\Models\Funds;
use Illuminate\Http\Request;

class VerifyPaymentController extends Controller
{
    //
    public function verifyPayment($reference)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.paystack.co/transaction/verify/" . $reference,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "Authorization: Bearer " . env('PAYSTACT_SECRET_KEY'),
                "Cache-Control: no-cache",
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            $response = json_decode($response);

            //checking if the verification was successful and storing amount to DB
            if( $response->message == 'Verification successful' )
            {
                //getting the user id\\
                $userId = UserController::User()->id;

                //getting the amount paid in naria\\
                $amountPayedKobo = $response->data->amount; //kobo
                $amountPayed = $amountPayedKobo / 100; //naira

                //getting the previous wallet balance and adding it to the new balance
                $previousBalance = Funds::where('user_id', $userId)->value('amount');

                $newBalance = $amountPayed + $previousBalance;

                if(Funds::where('user_id', $userId)->exists())
                {
                    Funds::where('user_id',$userId)->update([
                        'amount' => $newBalance,
                        'currency' => $response->data->authorization->country_code //getting the currency
                    ]);
                } else
                {
                    //new instanciation of the Funds model
                    $fund = new Funds();
                    $fund->user_id = $userId;
                    $fund->currency = $response->data->authorization->country_code; //getting the currency
                    $fund->amount = $newBalance;
                    $fund->save();
                }


            }
            return response()->json($response);
        }
    }
}
