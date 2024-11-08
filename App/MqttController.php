<?php

namespace App;

use PhpMqtt\Client\ConnectionSettings;
use PhpMqtt\Client\MqttClient;

class MqttController
{

    public function initConnection()
    {

        $host = 'broker.mqtt.cool'; #env('MQTT_HOST'),
        $port = 1883;
        $clean_session = false;

        $connectionSettings = (new ConnectionSettings)
        ->setConnectTimeout(10)
        // ->setUseTls(true)
        // ->setTlsSelfSignedAllowed(true)
        ->setKeepAliveInterval(60);
        // ->setTlsClientCertificateFile('D:\dev\teste\mqtt-teste\certificates\previsiown.com.csr')
        // ->setTlsCertificateAuthorityFile('D:\dev\teste\mqtt-teste\certificates\grouplink-ca.crt')
        // ->setTlsClientCertificateKeyFile('D:\dev\teste\mqtt-teste\certificates\previsiown.com.key');

        // echo "ConnnectionSettings:";
        // var_dump($connectionSettings);

        $mqtt = new MqttClient($host, $port, 'acquax');
        $mqtt->connect($connectionSettings, $clean_session);

        $mqtt->registerLoopEventHandler(function ($mqtt, float $elapsedTime) {
            if ($elapsedTime >= 590) {
                $mqtt->interrupt();
            }
        });
        $mqtt->subscribe('message/vini', function ($topic, $message) use($mqtt){
            // var_dump($topic);
            // var_dump($message);
            echo $topic . ": " . $message;
            $mqtt->interrupt();
        }, 1);
        $mqtt->loop(true, false, 100);
        
    }
}