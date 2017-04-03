<?php
require __DIR__  . '/vendor/autoload.php';
use Braintree\Gateway;
use Braintree\Transaction;



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
                    "amount"             => 10.00,
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
//                    'options' => [
//                        'submitForSettlement' => true
//                    ]
                ]);

            if ($result->success) {
                $msg = [
                    'Success ID' => $result->transaction->id
                ];

                /**
                 * Store transaction id for later use
                 * To refund|void it later
                 */
                $transaction_log = fopen('transaction_log', 'a');
                $datetime = date('Y-m-d H:i:s');
                $transaction_id = $result->transaction->id;
                fwrite($transaction_log, "[$datetime] transaction id: $transaction_id \n");

                $result = $gateway->transaction()->submitForSettlement('the_transaction_id');

                if ($result->success) {
                    /**
                     * Try to settle transaction
                     * If not, it only pending on buyer account
                     * Pending request >>> can not run refund|void
                     */
                    $settledTransaction = $result->transaction;
                    fwrite(var_export($settledTransaction));
                } else {
                    echo "<pre>";
                    print_r($result->errors);
                }

                fclose($transaction_log);
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