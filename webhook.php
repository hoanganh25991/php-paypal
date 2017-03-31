<?php

$post_json = json_encode($_POST);

$webhook_log = fopen('webhook_log', 'a');

fwrite($webhook_log, $post_json);

fclose($webhook_log);

die;