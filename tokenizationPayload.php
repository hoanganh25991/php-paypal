<?php
require __DIR__  . '/vendor/autoload.php';
use Braintree\Gateway;



$post_json = json_encode($_POST);

header("Content-type:application/json");

//echo $post_json;

if(isset($_POST['tokenizationPayload'])){
    $tokenizationPayload = json_decode($_POST['tokenizationPayload'], true);

//    $nonce = $_POST["payment_method_nonce"];

    /**
     *  Use payment method nonce
     */
    $accessToken = file_get_contents(__DIR__ . '/access_token');

    $gateway = new Gateway(array(
        'accessToken' => $accessToken,
    ));

    try{
        $result =
            $gateway
                ->transaction()
                ->sale([
                    "amount"             => 100,
                    'merchantAccountId'  => 'USD',
                    "paymentMethodNonce" => $tokenizationPayload['nonce'],
//                    "company" => "OUS",
                    "descriptor" => [
                        "name" => "cmp*productdescription",
                    ],
                    "shipping" => [
                        "firstName" => "Jen",
                        "lastName" => "Smith",
                        "company" => "Braintree",
                        "streetAddress" => "1 E 1st St",
                        "extendedAddress" => "Suite 403",
                        "locality" => "Bartlett",
                        "region" => "IL",
                        "postalCode" => "60103",
                        "countryCodeAlpha2" => "US"
                    ],
                ]);

            if ($result->success) {
                $msg = [
                    'Success ID' => $result->transaction->id
                ];
            } else if ($result->errors->deepSize() > 0) {
                echo "<pre>";
                print_r($result->errors);
            } else {
                echo $result->transaction->processorSettlementResponseCode;
                echo $result->transaction->processorSettlementResponseText;
            }

    }catch(\Exception $e){
        $msg = [
            'Server error' => $e->getMessage()
        ];
    }

    echo json_encode($msg);
}

die;