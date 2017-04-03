<?php
require __DIR__  . '/vendor/autoload.php';
//require_once __DIR___ .'vendor/braintree/braintree_php/lib/Braintree.php';
use Braintree\Gateway;
use Braintree\Transaction;




$accessToken = file_get_contents(__DIR__ . '/access_token');
$gateway = new Gateway(array(
    'accessToken' => $accessToken,
));


$msg = 'Please give me the transaction-id';
if(isset($_GET['transaction-id'])){
    $transaction_id = $_GET['transaction-id'];
    $result = Transaction::refund($transaction_id);

    if($result->success){
        $msg = 'Transaction refunded';
    }else{
        $msg = 'Error, fail to refund';
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