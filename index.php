<?php

require __DIR__ . '/vendor/autoload.php';
use App\MqttController;

$mqtt = new MqttController();
$mqtt->initConnection();