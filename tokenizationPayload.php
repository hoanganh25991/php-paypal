<?php
use Braintree\Gateway;
$post_json = json_encode($_POST);

header("Content-type:application/json");

echo $post_json;

//if(isset($_POST['tokenizationPayload'])){
//    $tokenizationPayload = $_POST['tokenizationPayload'];
//
//    echo json_encode($tokenizationPayload);
//}
//
//if(isset($_POST["payment_method_nonce"])){
//    $nonce = $_POST["payment_method_nonce"];
//
//    /**
//     *  Use payment method nonce
//     */
//    $accessToken = file_get_contents(__DIR__ . '/access_token');
//
//    $gateway = new Gateway(array(
//        'accessToken' => $accessToken,
//    ));
//
//    $result = $gateway->transaction()->sale([
//        "amount" => $_POST['amount'],
//        'merchantAccountId' => 'USD',
//        "paymentMethodNonce" => $_POST['payment_method_nonce'],
//        "orderId" => $_POST['Mapped to PayPal Invoice Number'],
//        "descriptor" => [
//            "name" => "Descriptor displayed in customer CC statements. 22 char max"
//        ],
//        "shipping" => [
//            "firstName" => "Jen",
//            "lastName" => "Smith",
//            "company" => "Braintree",
//            "streetAddress" => "1 E 1st St",
//            "extendedAddress" => "Suite 403",
//            "locality" => "Bartlett",
//            "region" => "IL",
//            "postalCode" => "60103",
//            "countryCodeAlpha2" => "US"
//        ],
//        "options" => [
//            "paypal" => [
//                "customField" => $_POST["PayPal custom field"],
//                "description" => $_POST["Description for PayPal email receipt"]
//            ],
//        ]
//    ]);
//    if ($result->success) {
//        print_r("Success ID: " . $result->transaction->id);
//    } else {
//        print_r("Error Message: " . $result->message);
//    }
//}

die;