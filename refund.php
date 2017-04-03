<?php
require __DIR__  . '/vendor/autoload.php';
//require_once __DIR___ .'vendor/braintree/braintree_php/lib/Braintree.php';
use Braintree\Gateway;
use Braintree\Transaction;
use Braintree\Configuration;


/**
 * Config environment
 */

//Configuration::environment('sandbox');
//Configuration::merchantId('USD');
//Configuration::publicKey('AR5lJaa2rHSxGVfSP3nb-nx11jvXQTy5eLLuIM4yB88z7wHIHxqtEE34oTpwdWM-oT_H6gmJfkWLzl3k');
//Configuration::privateKey('EGGpMHTbSXCZIRyFsVjnOPd36FI8pHDtXwet5ymzkncFELqUzb07XOPPsRYXR9JuFfKtH7P_vQTjzRl0');



$accessToken = file_get_contents(__DIR__ . '/access_token');
$gateway = new Gateway(array(
    'accessToken' => $accessToken,
));


$msg = 'Please give me the transaction-id';
if(isset($_GET['transaction-id'])){
    $transaction_id = $_GET['transaction-id'];
    try{
        //$result = Transaction::refund($transaction_id);
        $result = $gateway->transaction()->refund($transaction_id);

        if($result->success){
            $msg = 'Transaction refunded';
        }else{
            //var_dump($result);
            $msg  = 'Error, fail to refund';
            $msg .= $result->transaction->status;
            $msg .= $result->transaction->processorSettlementResponseCode;
            $msg .= $result->transaction->processorSettlementResponseText;
        }


    }catch(\Exception $e){
        //var_dump($e);
        $msg  = 'Got exception';
        $msg .= $e->getMessage();
    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>
<h1>Refund</h1>
<p><?php echo $msg; ?></p>
</body>
</html>