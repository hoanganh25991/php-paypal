<?php
require __DIR__  . '/vendor/autoload.php';
use Braintree\Gateway;



$accessToken = file_get_contents(__DIR__ . '/access_token');
$gateway = new Gateway(array(
    'accessToken' => $accessToken,
));


$msg = 'Please give me the transaction-id';
if(isset($_GET['transaction-id'])){
    $transaction_id = $_GET['transaction-id'];
    try{
        //$result = Transaction::refund($transaction_id);
        $result = $gateway->transaction()->void($transaction_id);

        if($result->success){
            $msg = 'Transaction voided';
        }else{
            //var_dump($result);
            $msg  = 'Error, fail to refund';
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
<h1>Void</h1>
<p><?php echo $msg; ?></p>
</body>
</html>