<?php
$post_json = json_encode($_POST);

$after_success_transaction_log = fopen('after_success_transaction_log', 'a');

fwrite($after_success_transaction_log, $post_json);

fclose($after_success_transaction_log);
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>
<h1>After success transaction</h1>
</body>
</html>
