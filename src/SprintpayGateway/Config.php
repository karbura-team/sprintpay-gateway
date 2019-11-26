<?php

namespace SprintpayGateway;

class Config {

    public function buildDateHeader() {
        date_default_timezone_set('UTC');
        return date('Y-m-d\TH:i:s\Z', time());
    }

    public function buildAuthorizationHeader($apiKey, $apiSecret, $date) {
        //Concat your keys and DateTime in the following order : APISecret + APIKey + DateTime
        $toSign = $apiSecret . $apiKey . $date;

        //Sign using SHA1.
        $messageBytes = utf8_encode($toSign);
        $secretBytes = utf8_encode($apiSecret);
        $result = hash_hmac('sha1', $messageBytes, $secretBytes);

        //Encode the result in base 64.
        $signature = base64_encode($result);

        //Concat all results like this: SP:APIKey:signature
        return "SP:" . $apiKey . ':' . $signature;
    }
}

?>