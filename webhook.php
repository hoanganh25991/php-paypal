<?php

//$post_json = json_encode($_POST);

$req_body  = file_get_contents('php://input');

$webhook_log = fopen('webhook_log', 'a');

//fwrite($webhook_log, $post_json);
fwrite($webhook_log, $req_body);

fclose($webhook_log);

die;