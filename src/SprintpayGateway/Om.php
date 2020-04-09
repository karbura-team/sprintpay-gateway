<?php

namespace SprintpayGateway;

class Om {

    public static function initialize($token,$merchantid,$phone,$orderid,$amount,$currency,$description,$companyname,$success,$failure,$notification) {

        // initialisation du token

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.orange.com/oauth/v2/token",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 300,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "grant_type=client_credentials",
            CURLOPT_HTTPHEADER => array(
                "Authorization: Basic ".$token."",
                "Content-Type: application/x-www-form-urlencoded"
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        // initiation du paiement

        $array_reponse = json_decode($response, true);

        $token = $array_reponse["access_token"];

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.orange.com/orange-money-webpay/cm/v1/webpayment",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 300,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS =>"{\n  \"merchant_key\": \"".$merchantid."\",\n  \"currency\": \"".$currency."\",\n  \"order_id\": \"".$orderid."\",\n  \"amount\": ".$amount.",\n  \"return_url\": \"".$success."\",\n  \"cancel_url\": \"".$failure."\",\n  \"notif_url\": \"".$notification."\",\n  \"lang\": \"fr\",\n  \"reference\": \"Paiement prime\"\n}",
            CURLOPT_HTTPHEADER => array(
                "Content-Type: application/json",
                "Authorization: Bearer ".$token.""
            ),
        ));

        $response = curl_exec($curl);

        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {

            $retour =  '{   
                            
                            "transaction_id": "00000",
                            "status_desc": "Failed",
                            "amount": "'.$amount.'",
                            "payment_url": null,
                            "status_code": 400,
                            "description": "'.$err.'",
                            "order_id": "00"
                        
                        }';

        } else {

            $retour = $response;
        }

        return $retour;

    }
}

?>